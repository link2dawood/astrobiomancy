<?php
namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Hash;
use Illuminate\Support\Collection;
use App\Models\Orders;
use App\Models\Orderchat;
use App\Models\Settings;
	

/**
 * The class OrdersController extends Controller class is responsible for managing the dashboard view 
 * Author : Syed Ali Raza
*/
class OrdersController extends Controller
{  
	public function orders() 
	{
		$orders = Orders::orderBy('id', 'DESC');
		if (isset($_GET['status']) && $_GET['status']!='') {
			$orders->where('status', $_GET['status']);
		} else {
			$orders->where('status', 'inprogress');
		}
		$orders = $orders->paginate(20);
		if (isset($_GET['status']) && $_GET['status']!='') {
			$orders->appends(['status' => $_GET['status']]);
		}
		foreach ($orders as $key=>$value) {
			$answ = Orderchat::where('order_id', $value->id)->where('type', 'admin')->count();
			$unansw = Orderchat::where('order_id', $value->id)->where('type', 'admin')->orderBy('id', 'DESC')->first();
			if (!isset($unansw->id)) {

				$orders[$key]->unansw = Orderchat::where('order_id', $value->id)->where('type', 'user')->orderBy('id', 'DESC')->count();
			}else if(isset($unansw->id)){
				$orders[$key]->unansw = Orderchat::where('id','>', $unansw->id)->where('type', 'user')->where('order_id', $value->id)->orderBy('id', 'DESC')->count();
				
			} else {
				$orders[$key]->unansw = 0;
			}
			
			$orders[$key]->answ = $answ;
			
		}
		
		return view('backend.orders.list', compact('orders'));
	}
	public function getorder( $id ) 
	{
		$orders = Orders::findOrFail($id);
		$order_chat = Orderchat::where('order_id', $orders->id)->get();
		$editChat = [];
		if (isset($_GET['chatid'])) {
			$editChat = Orderchat::where('id', $_GET['chatid'])->first();
		}

		foreach ($order_chat as $key => $value) {
			if ($value->is_read!=1) {
				$value->is_read = 1;
				$value->read_text = 'I am working on your request and will get back to you as soon as possible';
				$value->read_at = date('Y-m-d H:i:s');
				$value->save();
			}
		}
			$settings = Settings::first();
		//dd($orders);
		return view('backend.orders.single', compact('orders', 'order_chat', 'editChat','settings' ));
	}
	
	public function ordersupdate ( Request $request ) 
	{
		$orders = Orders::findOrFail($request->order_id);
		$orders->number_of_question = $request->number_of_question;
		if (isset($request->status) && $request->status==='on') {
			$orders->status = 'completed';
		} else {
			$orders->status = 'inprogress';
		}
		$orders->save();
		if ($request->message!='') {
			if (isset($request->chatid)) {
				$orderchat =  Orderchat::find($request->chatid);
			} else{
				$orderchat = new Orderchat();
			}
			$orderchat->order_id = $request->order_id;
			$orderchat->type ='admin';
			$orderchat->message = $request->message;
			$orderchat->user_id = Auth::user()->id;
			$toemail = $orders->userdata->email;
			if (isset($request->attachment_name) && count($request->attachment_name)>0) {
				$orderchat->attachment = implode(',', $request->attachment_name);
			}

			/*if ($request->file('attachment')) {
		     	$file = $request->file('attachment');
		        $name = time().rand(1,100).'.'.$file->extension();
		        $file->move(public_path('uploads/orderchat/'), $name);
				$orderchat->attachment = $name;
	     	}*/

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
			
			$data = ['order'=>$orders,'user'=>$orders->userdata, 'answer'=>$request->message];

			\Mail::send('mail.orderreply', $data, function ($message) use($toemail) {
			$message->to($toemail)
			->subject("You received the answer to your question")->from(env('MAIL_FROM_ADDRESS'));
			});

			$orderchat->save();
		}
		
		return redirect('dashboard/orders/'.$request->order_id)->with('message', 'add');
	}

	public function orderschatdelete ( $id ) {
		$orderchat = Orderchat::findOrFail($id);
		$orderchat->delete();
		return back()->with('message', 'deleted');

	}

	public function updatereadchat ( Request $request ) 
	{
		$orderchat = Orderchat::findOrFail($request->id);
		$orderchat->read_text= $request->read_text;
		$orderchat->save();
		return back()->with('message', 'update');
	}

	public function deleteorders( $id )
	{
		Orders::where('id', $id)->delete();
		Orderchat::where('order_id',$id)->delete();

		return back()->with('message', 'deleted');

	}
}