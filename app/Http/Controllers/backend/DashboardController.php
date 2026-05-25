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
 * The class DashboardController extends Controller class is responsible for managing the dashboard view 
 * Author : Syed Ali Raza

*/

class DashboardController extends Controller
{   
	protected $namespace = null;
	
	/**
	* Function to load the view of DashBoard 
	* @param \Illuminate\Http\Request $request
	* @return view of DashBoard
	*/
	public function dashboardData ()
	{
		
		return view('backend.dashboard.dashboard');
	}

	
	
}