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
use App\Models\Aboutus;
use App\Models\Services;

/**
 * The class ServicesController extends Controller class is responsible for managing the blog view 
 * Author : Syed Ali Raza
*/
class ServicesController extends Controller
{  
	public function service ($slug) 
	{
		$services =  Services::where('slug', $slug)->first();

		return view('backend.pages.services', compact('services'));
	}

	public function save ( Request $request ) 
	{
		$packages_details = [];
		if (isset($request->package_details) && count($request->package_details)>0) {
			foreach ($request->package_details as $key=>$value) {
				$packages_details [] = [
					'package_details'=>$value,
					'number_of_question'=>$request->number_of_question[$key],
					'package_amount'=>$request->package_amount[$key],
					'package_name'=>$request->package_name[$key],
					'package_details_terms'=>$request->package_details_terms[$key],
					'customer_ask_question_page'=>$request->customer_ask_question_page[$key],
					'package_id'=>$request->package_id[$key],
				];	
			}
		}
		$services =  Services::find($request->id);
		$services->main_heading = $request->main_heading;
		$services->second_heading = $request->second_heading;
		$services->description = $request->description;
		$services->packages_details = json_encode($packages_details);
		$services->save();
		return back()->with('message', 'add');
	}

	
}