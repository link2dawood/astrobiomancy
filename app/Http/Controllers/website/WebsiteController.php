<?php
namespace App\Http\Controllers\website;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Hash;
use Illuminate\Support\Collection;
use App\User;
use App\Models\Blog;
use App\Models\Comments;
use App\Models\Aboutus;
use App\Models\Settings;
use App\Models\Disclaimer;
use App\Models\Services;
use App\Models\Orders;
use App\Models\Privacypolicy;
use App\Models\Homepage;
use App\Models\Pages;
use App\Models\Testimonial;
use Stripe;
use Carbon\Carbon;


/**
 * The class WebsiteController extends Controller class is responsible for managing the blog view 
 * Author : Syed Ali Raza
*/
class WebsiteController extends Controller
{  
	/**
	 * Singleton-page lookup that respects the active locale, falling back to
	 * EN when the localized row hasn't been created yet. Keeps the public
	 * site rendering rather than 404-ing while editors backfill DE content.
	 */
	private function localized($modelClass)
	{
		$loc = app()->getLocale();
		return $modelClass::where('lang', $loc)->first()
			?: $modelClass::where('lang', 'en')->first()
			?: $modelClass::first();
	}

	public function index ()
	{
		$homepage = $this->localized(Homepage::class);
		$testimonials = Testimonial::published()->forLocale()
			->orderBy('sort')->orderBy('id', 'desc')
			->limit(12)->get();
		return view('website.home.index', compact('homepage', 'testimonials'));
	}

	public function testimonials ()
	{
		$testimonials = Testimonial::published()->forLocale()
			->orderBy('sort')->orderBy('id', 'desc')
			->paginate(24);
		return view('website.testimonials', compact('testimonials'));
	}

	public function contactus () 
	{
		return view('website.contactus.contactus');
	}

	public function createaccount () 
	{
		return view('website.account.createaccount');
	}

	public function login () 
	{
		return view('website.account.login');
	}

	public function verifycode ($account_token)  {
		$user = User::where('account_token', $account_token)->first();
		if (!isset($user->id)) {
			abort(404);
		}
		$user->account_token = '';
		$user->is_verify = 1;
		$user->save();
		return redirect(app()->getLocale() . '/user/login')->with('success', __('site.flash_verified'));
	}

	public function userlogin ( Request $request ) 
	{
		
		$credentials = $request->only('email', 'password');
		$credentials_username = array(
			'email'=>$request->email,
			'password'=>$request->password
		); 

		// check if g-rececaptcha-response set 
		if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
			
			if($this->verifyGoogleCaptcha($_POST['g-recaptcha-response'])){
				if (Auth::attempt($credentials)){
					$user=auth()->user();

					if ($user->is_verify==1) {
						return redirect()->intended(app()->getLocale() . '/users/account');
					} else {
						Auth::logout();
						// Account exists but isn't verified. Generate a fresh
						// token + actually resend the verification email so the
						// "we sent you a link" message is truthful.
						$this->resendVerification($user);
						return redirect()->back()->with('error', __('site.flash_verify_required'));
					}
				}else{
					return redirect()->back()->with('error', __('site.flash_invalid_login'));
				}
			}else{
				return redirect()->back()->with('error', __('site.flash_captcha_required'));
			}

		}else{
			return redirect()->back()->with('error', __('site.flash_captcha_invalid'));
		}
		
	}
	
	public function createuser ( Request $request )
	{

		if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {

			if($this->verifyGoogleCaptcha($_POST['g-recaptcha-response'])){

				// Validate the address block + core fields before creating
				// the row. Returns to the form with errors on failure.
				$validated = $request->validate([
					'name'       => 'required|string|max:191',
					'email'      => 'required|email|max:191',
					'password'   => 'required|string|min:6',
					'first_name' => 'required|string|max:191',
					'last_name'  => 'required|string|max:191',
					'address'    => 'required|string|max:191',
					'address2'   => 'nullable|string|max:191',
					'city'       => 'required|string|max:191',
					'zipcode'    => 'required|string|max:32',
					'state'      => 'required|string|max:191',
					'country'    => 'required|string|max:191',
				]);

				$user = User::where('email', $request->email)->first();
				if (isset($user->id)) {
					return back()->with('error', __('site.flash_user_exists'))->withInput();
				}

				$random_number = md5(rand(10000, 1000000000000000));

				$user = new User();
				$user->name          = $request->name;
				$user->email         = $request->email;
				$user->account_token = $random_number;
				$user->is_verify     = 0;
				$user->password      = bcrypt($request->password);
				$user->first_name    = $request->first_name;
				$user->last_name     = $request->last_name;
				$user->address       = $request->address;
				$user->address2      = $request->address2;
				$user->city          = $request->city;
				$user->zipcode       = $request->zipcode;
				$user->state         = $request->state;
				$user->country       = $request->country;
				$user->save();
				$user->assignRole(2);

				$subject = __('site.mail_subject_register');

				$email_data = ['verfiylink'=>url(app()->getLocale() . '/account-verfiy/'.$random_number), 'name'=>$request->name];
				$to_email= $request->email;
				\Mail::send('mail.register', $email_data, function($message) use( $to_email, $subject) {
					// Default From comes from config/mail.php; don't call
					// env() at runtime — it returns null under config:cache.
					$message->to($to_email)->subject($subject);
				});

				return redirect(app()->getLocale() . '/user/login')->with('success', __('site.flash_account_created'));
			}else{
				return redirect()->back()->with('error', __('site.flash_captcha_required'));
			}
		}else{
			return redirect()->back()->with('error', __('site.flash_captcha_invalid'));
		}
		

	}

	public function aboutus ()
	{
		$aboutus = $this->localized(Aboutus::class);
		return view('website.pages.aboutus', compact('aboutus'));
	}

	public function privacypolicy ()
	{
		$privacypolicy = $this->localized(Privacypolicy::class);
		return view('website.pages.privacypolicy', compact('privacypolicy'));
	}

	/**
	 * Catch-all resolver for renamed singleton URLs. When admin renames a
	 * page's slug (e.g. about-us -> about-me), the slug column on the
	 * Aboutus / Privacypolicy / Disclaimer row holds the new value, and
	 * this method dispatches /{locale}/{slug} to the right view.
	 */
	public function singletonBySlug($slug)
	{
		$loc = app()->getLocale();

		$row = Aboutus::where('lang', $loc)->where('slug', $slug)->first()
			?: Aboutus::where('lang', 'en')->where('slug', $slug)->first();
		if ($row) return view('website.pages.aboutus', ['aboutus' => $row]);

		$row = Privacypolicy::where('lang', $loc)->where('slug', $slug)->first()
			?: Privacypolicy::where('lang', 'en')->where('slug', $slug)->first();
		if ($row) return view('website.pages.privacypolicy', ['privacypolicy' => $row]);

		$row = Disclaimer::where('lang', $loc)->where('slug', $slug)->first()
			?: Disclaimer::where('lang', 'en')->where('slug', $slug)->first();
		if ($row) return view('website.pages.disclaimer', ['disclaimer' => $row]);

		abort(404);
	}

	public function page ( $slug )
	{
		$loc = app()->getLocale();
		$page = Pages::where('slug', $slug)->where('lang', $loc)->first()
			 ?: Pages::where('slug', $slug)->where('lang', 'en')->first()
			 ?: Pages::where('slug', $slug)->first();
		if (!isset($page->id)) {
			abort(404);
		}
		return view('website.pages.page', compact('page'));
	}

	public function service ($slug)
	{
		$loc = app()->getLocale();
		$service = Services::where('slug', $slug)->where('lang', $loc)->first()
				?: Services::where('slug', $slug)->where('lang', 'en')->first()
				?: Services::where('slug', $slug)->first();
		if (!$service) {
			abort(404);
		}

		// Packages (pricing JSON) are shared across languages in practice.
		// If the localized row has no packages, fall back to the EN row so the
		// page still renders with German copy + shared price structure.
		$packagesRaw = $service->packages_details;
		$packages = is_string($packagesRaw) ? json_decode($packagesRaw, true) : null;
		if (empty($packages) && $service->lang !== 'en') {
			$enService = Services::where('slug', $slug)->where('lang', 'en')->first();
			if ($enService && $enService->packages_details) {
				$packages = json_decode($enService->packages_details, true);
			}
		}
		$service->packages_details = is_array($packages) ? $packages : [];

		$groupedData = [];
		foreach ($service->packages_details as $item) {
			$name = $item['package_name'] ?? '';
			if (!isset($groupedData[$name])) {
				$groupedData[$name] = [];
			}
			$groupedData[$name][] = $item;
		}
		$order = [];
		if (isset(\Auth::user()->id)) {
			$order = Orders::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->first();
			// No prior order yet — fall back to the user's saved address so
			// the order modal pre-fills from /users/address instead of being
			// blank. Wrap in a stdClass so the view's $order->field accessors
			// keep working without changes.
			if (!$order) {
				$u = \Auth::user();
				$order = (object) [
					'first_name' => $u->first_name,
					'last_name'  => $u->last_name,
					'email'      => $u->email,
					'address'    => $u->address,
					'address2'   => $u->address2,
					'city'       => $u->city,
					'zipcode'    => $u->zipcode,
					'state'      => $u->state,
					'country'    => $u->country,
				];
			}
		}

		return view('website.pages.service', compact('service', 'groupedData', 'order'));
	}

	public function disclaimer ()
	{
		$disclaimer = $this->localized(Disclaimer::class);
		return view('website.pages.disclaimer', compact('disclaimer'));
	}

	public function blog () 
	{
		$settings = Settings::first();
		if (isset($settings->enable_blog) && $settings->enable_blog==='0') {
			abort(404);
		}
		$posts = Blog::where('status', 'Published')
			->forLocale()
			->orderBy('id', 'DESC')
			->paginate(10);
		return view('website.blog.list', compact('posts'));
	}

	public function postcomment ( Request $request ) 
	{
		if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
			
			if($this->verifyGoogleCaptcha($_POST['g-recaptcha-response'])){

				$comments = new Comments ();
				$comments->fullname = $request->fullname;
				$comments->email = $request->email;
				$comments->post_id = $request->post_id;
				$comments->comment = $request->comments;
				$comments->save();
				return back()->with('success', __('site.flash_comment_added'));
			}else{
				return redirect()->back()->with('error', __('site.flash_captcha_required'));
			}

		}else{
			return redirect()->back()->with('error', __('site.flash_captcha_invalid'));
		}
	}
	public function singlePost ( $slug )
	{
		$settings = Settings::first();
		if (isset($settings->enable_blog) && $settings->enable_blog==='0') {
			abort(404);
		}

		$loc = app()->getLocale();

		// First preference: the post in the active locale.
		$post = Blog::where('slug', $slug)
			->where('lang', $loc)
			->where('status', 'Published')
			->first();

		// If the slug belongs to a post in another locale, redirect to the
		// localized counterpart's slug so the URL, language, and content
		// stay consistent. Falls back to /{locale}/blog if no translation.
		if (!$post) {
			$other = Blog::where('slug', $slug)->where('status', 'Published')->first();
			if ($other) {
				$parentId = $other->translation_of ?: $other->id;
				$sibling = Blog::where('lang', $loc)
					->where('status', 'Published')
					->where(function ($q) use ($parentId) {
						$q->where('id', $parentId)->orWhere('translation_of', $parentId);
					})
					->first();
				if ($sibling) {
					return redirect('/' . $loc . '/post/' . $sibling->slug, 301);
				}
				return redirect('/' . $loc . '/blog');
			}
			abort(404);
		}

		$comments = Comments::where('post_id', $post->id)->orderBy('id', 'DESC')->get();
		return view('website.blog.single', compact('post', 'comments'));
	}



	public function postorder ( Request $request ) 
	{
		$service = Services::where('id', $request->service_id)->first();
		if (!isset($service->id)) {
			abort(404);
		}
		$packages_details = json_decode($service->packages_details, true);
		foreach ($packages_details as $key => $value) {
			if ($value['package_id'] == $request->plan_key) {
				$packages_details = $value;
			}
		}
		$settings  = Settings::find(1);
		// Use config() not env() — env() returns null when config:cache has run.
		Stripe\Stripe::setApiKey(config('services.stripe.secret'));
		$stripe_id = '';
		$erro_message = '';
		if ($request->stripe_token!='' && $request->stripe_token!='paypal') {
			try {
				$stripe_object = Stripe\Charge::create ([
					"amount" => $request->amount * 100,
					"currency" => 'EUR',
					"source" =>  $request->stripe_token,
					"description" =>"Order #".$request->order_id.". " .Auth::user()->name." has purchased the plan. Package details = ".$packages_details['package_details'] 
				]);
				$stripe_id = $stripe_object->id;

			} catch(\Stripe\Exception\CardException $e) {
				$erro_message = $e->getError()->message;
				return back()->with('error', $erro_message);
			} catch(\Stripe\Exception\InvalidRequestException $e) {
				$erro_message = $e->getError()->message;
				return back()->with('error', $erro_message);

			} catch (Exception $e) {
				$erro_message ='Some thing wrong in payment';
				return back()->with('error', $erro_message);
			} 
		}
		$orders = new Orders();
		$orders->package_details = $packages_details['package_details'];
		$orders->number_of_question = $packages_details['number_of_question'];
		$orders->package_number_of_question = $packages_details['number_of_question'];
		$orders->package_amount = $packages_details['package_amount'];
		$orders->package_name = $packages_details['package_name'];
		$orders->customer_ask_question_page = $packages_details['customer_ask_question_page'];
		$orders->user_id = Auth::user()->id;
		$orders->first_name = $request->first_name;
		$orders->order_id = $request->order_id;
		$orders->last_name = $request->last_name;
		$orders->email = $request->email;
		$orders->address = $request->address;
		$orders->address2 = $request->address2;
		$orders->city = $request->city;
		$orders->zipcode = $request->zipcode;
		$orders->state = $request->state;
		$orders->country = $request->country;
		$orders->stripe_id = $stripe_id;
		$orders->paypal_id = $request->paypal_id;
		$orders->service_id = $request->service_id;
		$orders->save();

		// Sync the typed address back into the user's account so the next
		// order pre-fills automatically and /users/address reflects what
		// the customer just entered. Only updates fields that the form
		// actually submitted — empty inputs are skipped to avoid wiping
		// existing data.
		$u = User::find(Auth::user()->id);
		if ($u) {
			foreach (['first_name','last_name','address','address2','city','zipcode','state','country'] as $f) {
				if ($request->filled($f)) {
					$u->{$f} = $request->input($f);
				}
			}
			$u->save();
		}

		if (isset($settings->admin_email) && $settings->admin_email!='') {
			$toemail = $settings->admin_email;
			$data = ['order'=>$orders,'user'=>Auth::user()];
			\Mail::send('mail.orderconfirm', $data, function ($message) use($toemail) {
				$message->to($toemail)
					->subject("Great news: You've received an order from astrobiomancy.com");
				// Default From handled by config/mail.php
			});
		}

		return redirect('users/orders/'.$orders->id)->with('success', 'Your order has been placed now you can ask the question.');


	}

	public function verifyGoogleCaptcha($token){
		 /**
   * CAPTCHA V2
   */
		 $handler = curl_init();
		 curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
		 curl_setopt($handler, CURLOPT_POST, true);
		 curl_setopt($handler, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
		 curl_setopt($handler, CURLOPT_POSTFIELDS, array(
		 	'secret' => '6LfM4nYqAAAAAMQcNflskmSsYPGK14mdTaHyfIVU',
		 	'response' => $token,
		 ));
		 $response = curl_exec($handler);
		 $response = json_decode($response);
		 curl_close($handler);

		 if($response->success){
		 	return true;
		 }else{
		 	return false;
		 }

		}


		/**
		 * Generate a fresh verification token and send the verification email
		 * to an unverified user. Used both at signup and when an unverified
		 * user attempts to log in (so the "we sent a link" flash is truthful).
		 *
		 * Errors are swallowed and logged — a transient mail failure must not
		 * break the login flow.
		 */
		private function resendVerification($user)
		{
			try {
				$user->account_token = md5(rand(10000, 1000000000000000));
				$user->save();

				$subject    = __('site.mail_subject_register');
				$email_data = [
					'verfiylink' => url(app()->getLocale() . '/account-verfiy/' . $user->account_token),
					'name'       => $user->name,
				];
				$to_email = $user->email;

				\Mail::send('mail.register', $email_data, function ($message) use ($to_email, $subject) {
					// Don't set from() here — Laravel pulls the default From
					// from config/mail.php (which reads MAIL_FROM_ADDRESS at
					// boot). Calling env() at runtime returns null when
					// config is cached, which previously caused "Cannot send
					// message without a sender address".
					$message->to($to_email)->subject($subject);
				});
			} catch (\Throwable $e) {
				\Log::error('Verification email failed for ' . ($user->email ?? '?') . ': ' . $e->getMessage());
			}
		}

		public function deleteUnverifiedUserCron(){
			
		// Get the current time minus 60 minutes
			$timeLimit = Carbon::now()->subMinutes(60);
        // Find all users who have not verified their email
			$unverifiedUsers = User::where('is_verify', 0)->get();
        // Delete each unverified user
			foreach ($unverifiedUsers as $user) {
				$user->delete();
			}
		}
	}