<?php
namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Hash;
use Illuminate\Support\Collection;
use App\User;
use App\Models\Settings;

/**
 * The class SettingsController extends Controller class is responsible for managing the blog view 
 * Author : Syed Ali Raza
*/
class SettingsController extends Controller
{  
	public function settings () 
	{
		$settings = Settings::first();
		return view('backend.settings.settings', compact('settings'));
	}

	public function settings_save ( Request $request ) 
	{
		$settings = Settings::first();
		if (isset($request->enable_blog)) {
			$settings->enable_blog = '1';
		} else {
			$settings->enable_blog = '0';
		}
		$settings->max_num_of_files = $request->max_num_of_files;
		$settings->admin_email = $request->admin_email;
		$settings->facebook_link = $request->facebook_link;
		$settings->twitter_link = $request->twitter_link;
		$settings->instagram_link = $request->instagram_link;
		$settings->stripe_text = $request->stripe_text;
		$settings->admin_message_length = $request->admin_message_length;
		$settings->client_message_length = $request->client_message_length;

		$settings->save();
		return back()->with('message','update');
	}
}