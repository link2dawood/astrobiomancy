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
	public function index ()
	{
		$homepage = Homepage::find(1);
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

				$user = User::where('email', $request->email)->first();


				if (isset($user->id)) {
					return back()->with('error', __('site.flash_user_exists'));
				}
				$random_number = rand(10000, 1000000000000000);
				$random_number = md5($random_number);

				$user = new User();
				$user->name = $request->name;
				$user->email = $request->email;
				$user->account_token = $random_number;
				$user->is_verify = 0;
				$user->password =bcrypt($request->password) ;
				$user->save();
				$user->assignRole(2);

				$subject = __('site.mail_subject_register');

				$email_data = ['verfiylink'=>url(app()->getLocale() . '/account-verfiy/'.$random_number), 'name'=>$request->name];
				$to_email= $request->email;
				\Mail::send('mail.register', $email_data, function($message) use( $to_email, $subject) {
					$message->to($to_email)->subject
					($subject);
					$message->from(env('MAIL_FROM_ADDRESS'));
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
		$aboutus =  Aboutus::find(1);
		return view('website.pages.aboutus', compact('aboutus'));
	}

	public function privacypolicy () 
	{
		$privacypolicy =  Privacypolicy::find(1);
		return view('website.pages.privacypolicy', compact('privacypolicy'));
	}

	public function page ( $slug ) 
	{
		$page =  Pages::where('slug', $slug)->first();
		if(!isset($page->id)) {
			abort(404);
		}
		return view('website.pages.page', compact('page'));
	}

	public function service ($slug) 
	{
		$service =  Services::where('slug', $slug)->first();
		$service->packages_details = json_decode($service->packages_details, true);
		$groupedData = [];
		foreach ($service->packages_details as $item) {
			$name = $item['package_name'];

		    // Check if the group exists
			if (!isset($groupedData[$name])) {
		        // If the group doesn't exist, create it
				$groupedData[$name] = [];
			}

		    // Add the item to the group
			$groupedData[$name][] = $item;
		}
		$order =[];
		if (isset(\Auth::user()->id)) {
			$order = Orders::where('user_id', \Auth::user()->id)->orderBy('id', 'DESC')->first();
		}
		
		return view('website.pages.service', compact('service', 'groupedData', 'order'));
	}

	public function disclaimer () 
	{
		$disclaimer =  Disclaimer::find(1);
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
		$post = Blog::where('slug', $slug)
			->where('status', 'Published')
			->first();
		if (!isset($post->id)) {
			abort(404);
		}
		$settings = Settings::first();
		if (isset($settings->enable_blog) && $settings->enable_blog==='0') {
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
		Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
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
		if (isset($settings->admin_email) && $settings->admin_email!='') {
			$toemail = $settings->admin_email;
			$data = ['order'=>$orders,'user'=>Auth::user()];
			\Mail::send('mail.orderconfirm', $data, function ($message) use($toemail) {
				$message->to($toemail)
				->subject("Great news: You've received an order from astrobiomancy.com")->from(env('MAIL_FROM_ADDRESS'));
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