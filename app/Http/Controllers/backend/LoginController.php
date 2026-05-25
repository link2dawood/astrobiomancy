<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Hash;
use App\User;

/**
 * The class LoginController extends Controller class is responsible for user login 
 * Author : Syed Ali Raza
 *

*/
class LoginController extends Controller
{   
	protected $namespace = null;

	

	/**
	* Function to load the view of login page
	*
	* @param \Illuminate\Http\Request $request
	* @return view of login
	*/
	public function login(Request $request)
	{
		return view('backend.login.login');
	}

	public function login_action(Request $request)
	{

		$credentials = $request->only('email', 'password');
		$credentials_username = array(
		'email'=>$request->email,
		'password'=>$request->password
		); 
		
		if (Auth::attempt($credentials)){
			$user=auth()->user();
			if(isset($user->roles[0]->name) && $user->roles[0]->name==='partner'){
				return redirect()->intended('cashjobslist/10');
			}else{
				return redirect()->intended('dashboard/');
			}
			

		}else{
			return redirect()->back()->with('message', 'Invalid Email or Password.');
		}
	}
	/**
	* Function logout from the system
	*
	* @return success message
	*/
	public function logout()
	{
		Auth::logout();
		return redirect('login')->with('message', 'Logout Successfully.');
	}		
}