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
use App\Models\Orderchat;
use Stripe;


/**
 * The class AccountController extends Controller class is responsible for managing the blog view 
 * Author : Syed Ali Raza
*/
class AccountController extends Controller
{  
	public function logout () 
	{
		Auth::logout();
		return redirect('user/login');
	}
	public function orders () 
	{
		$orders  = Orders::where('user_id', Auth::user()->id)->get();
		return view('website.account.orders', compact('orders'));
	}

	public function useraccount () 
	{
		return view('website.account.useraccount');
	}

	public function accountupdate ( Request $request ) 
	{
		$user = User::find(Auth::user()->id);
		if (!isset($user->id)) {
			abort(404);
		}
		$user->name = $request->name;
		if ( $request->password!='') {
			$user->password =bcrypt($request->password) ;
		}
		$user->save();
		return back()->with('message', 'Account has been updated.');
	}

	public function userorder ( $id ) {
		$orders = Orders::where('id', $id)->where('user_id', Auth::user()->id)->first();
		if (!isset($orders->id)) {
			abort(404);
		}
		$order_chat = Orderchat::where('order_id', $orders->id)->get();
		$order_chat_count = Orderchat::where('order_id', $orders->id)->where('user_id', Auth::user()->id)->count();
		
		$settings = Settings::first();
		

		return view('website.account.singleorder', compact('orders', 'order_chat', 'order_chat_count', 'settings'));

	} 

	public function ordersaveques ( Request $request ) 
	{
		$settings  = Settings::find(1);
		$orders = Orders::where('id', $request->order_id)->where('user_id', Auth::user()->id)->first();
		$orders->number_of_question = $orders->number_of_question-1;
		$orders->save();
		
		$orderchat  = new Orderchat();
		$orderchat->message = $request->question;
		
		if (isset($request->attachment_name) && count($request->attachment_name)>0) {
			$orderchat->attachment = implode(',', $request->attachment_name);
		}
		$orderchat->type = 'user';
		$orderchat->order_id = $request->order_id;
		$orderchat->is_read = 0;
		$orderchat->user_id = Auth::user()->id;
		if (isset($request->attachment_name) && count($request->attachment_name)>0) {
			foreach ($request->attachment_name as $key => $value) {
				$sourceFilePath =public_path('uploads/orderchattemp/'.$value); 
				$destinationDirectory =public_path('uploads/orderchat/'); 
		        if (\File::exists($sourceFilePath)) {
	            	// Move the file to the destination directory
	            	\File::move($sourceFilePath, $destinationDirectory . '/' . basename($sourceFilePath));
	        	}
			}
			
		}
           
		if (isset($settings->admin_email) && $settings->admin_email!='') {
			$toemail = $settings->admin_email;
			$data = ['order'=>$orders,'user'=>Auth::user(), 'question'=>$request->question];
			\Mail::send('mail.orderquestion', $data, function ($message) use($toemail) {
			$message->to($toemail)
			->subject(Auth::user()->name." Asked the question. Please reply")->from(env('MAIL_FROM_ADDRESS'));
			});
	    }

		$orderchat->save();
		return back()->with('message', 'Your question has been sent. I am going to reply as soon as possible.');
	}

	public function uploadtempfile ( Request $request ) 
	{
		$allowedExtensions = ['txt', 'docx', 'jpg', 'jpeg', 'png', 'xlsx', 'pdf'];
		if ($request->file('file')) {
	     	$file = $request->file('file');
	     	$extension=$file->extension();

	     	if (!in_array($file->extension(), $allowedExtensions)) {
	     		return response()->json(['status'=>false, 'message'=>'Invalid file type please upload these type of file '.implode(',', $allowedExtensions)]);
	     	} 

	        $name = $file->getClientOriginalName();
	        $file->move(public_path('uploads/orderchattemp/'), $name);

	        return response()->json(['status'=>true,'extension'=>$extension, 'tempurl'=>url('public/uploads/orderchattemp/'.$name), 'name'=>$name]);
     	}
		return response()->json(['status'=>false, 'message'=>'Fail to upload.']);
	}
}