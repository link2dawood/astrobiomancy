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
/**
 * The class UsersController extends Controller class is responsible for managing the dashboard view 
 * Author : Syed Ali Raza
*/
class UsersController extends Controller
{  
	public function adminList() 
	{
		$users = User::whereHas('roles', function($query){
			$query->where('name', 'Admin');
		})->orderBy('id', 'DESC')->paginate(20);
		return view('backend.users.list', compact('users'));
	}
	public function list() 
	{
		$users = User::whereHas('roles', function($query){
			$query->where('name', 'User');
		})->orderBy('id', 'DESC')->paginate(20);
		// dd($users);
		return view('backend.users.user-list', compact('users'));
	}
	public function add() 
	{
		return view('backend.users.add');
	}
	public function edit( $id ) 
	{
		$users = User::find($id);
		return view('backend.users.edit', compact('users'));
	}
	public function add_action( Request $request ) 
	{
		$user = User::where('email', $request->email)->first();
		if (isset($user->id)) {
			return back()->with('error', 'User already exist with this email');
		}
		$user = new User();
		$user->email = $request->email;
		$user->name = $request->name;

		$user->password =bcrypt($request->password) ;
		$user->save();
		$user->assignRole($request->role);
		
		if($request->role ==	1){
			return redirect('dashboard/admin/users')->with('message', 'add');
		}else{
			return redirect('dashboard/users')->with('message', 'add');
		}
		
	}
	public function update_action( Request $request ) 
	{
		$user = User::find($request->id);
		$user->name = $request->name;
		if ($request->password!='') {
		$user->password =bcrypt($request->password) ;
		}
		$user->save();
		return redirect('dashboard/users')->with('message', 'update');
	}
	public function delete( $id ) 
	{
		User::where('id', $id)->delete();
		// return redirect('dashboard/users')->with('message', 'deleted');
		return redirect()->back()->with('message', 'deleted');
	}
}