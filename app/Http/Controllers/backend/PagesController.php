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
use App\Models\Disclaimer;
use App\Models\Privacypolicy;
use App\Models\Homepage;
use App\Models\Pages;

/**
 * The class PagesController extends Controller class is responsible for managing the blog view 
 * Author : Syed Ali Raza
*/
class PagesController extends Controller
{  
	public function page ( $slug ) 
	{
		$page =  Pages::where('slug', $slug)->first();
		return view('backend.pages.page', compact('page'));
	}

	

	public function update ( Request $request ) 
	{
		$pages =  Pages::findOrFail($request->id);
		$pages->main_heading = $request->main_heading;
		$pages->second_heading = $request->second_heading;
		$pages->description = $request->description;
		$pages->save();
		return back()->with('message', 'add');
	}

	public function about () 
	{
		$aboutus =  Aboutus::find(1);

		return view('backend.pages.aboutus', compact('aboutus'));
	}
	public function about_save ( Request $request ) 
	{
		$aboutus =  Aboutus::find(1);
		$aboutus->main_heading = $request->main_heading;
		$aboutus->second_heading = $request->second_heading;
		$aboutus->description = $request->description;
		$aboutus->save();
		return back()->with('message', 'add');
	}

	public function disclaimer () 
	{
		$disclaimer =  Disclaimer::find(1);

		return view('backend.pages.disclaimer', compact('disclaimer'));
	}

	public function disclaimer_save ( Request $request ) 
	{
		$disclaimer =  Disclaimer::find(1);
		$disclaimer->main_heading = $request->main_heading;
		$disclaimer->second_heading = $request->second_heading;
		$disclaimer->description = $request->description;
		$disclaimer->save();
		return back()->with('message', 'add');
	}

	public function home () 
	{
		$homepage =  Homepage::find(1);
		return view('backend.pages.homepage', compact('homepage'));
	}

	public function home_save (Request $request ) 
	{
		$image = $request->file('image');
		$imageName = "";
		if (isset($image)) {
        	$imageName = time() . '.' . $image->extension();
	        $path = public_path('uploads/images/');
	        $image->move($path, $imageName);
		}
		$homepage =  Homepage::find(1);
		$homepage->top_header_heading  = $request->top_header_heading;
		$homepage->get_started_label  = $request->get_started_label;
		$homepage->top_header_subheading  = $request->top_header_subheading;
		if ($imageName!='') {
			$homepage->banner_image  = $imageName;
		}
		$homepage->get_started_link  = $request->get_started_link;
		$homepage->welcome_lable  = $request->welcome_lable;
		$homepage->weclome_text  = $request->weclome_text;
		$qa_json = [];
		if (isset($request->question)) {
			foreach ($request->question as $key=>$value) {
				$qa_json[] = [
					'question' =>$value,
					'answer' =>$request->answer[$key],
				];
			}
		}
		$homepage->qa_json  = json_encode($qa_json);
		
		$offer_data_links = [];
		if (isset($request->offer_name[0])) {
			
			foreach($request->offer_name as $key=>$offer) {
				$offer_data_links[] = [
					'name'=>$offer,
					'offer_link'=>$request->offer_link[$key],
					'offer_icon'=>$request->offer_icon[$key],
				];
			}
		}
		$offer_data = [
			'offer_heading'=>$request->offer_heading,
			'offer_p1'=>$request->offer_p1,
			'offer_p2'=>$request->offer_p2,
			'offer_data_links'=>$offer_data_links,
		];
		$homepage->offer_json  = json_encode($offer_data);

		$homepage->save();
		return back()->with('message', 'add');

	}

	public function privacypolicy () 
	{
		$privacypolicy =  Privacypolicy::find(1);

		return view('backend.pages.privacypolicy', compact('privacypolicy'));
	}

	public function privacypolicy_save ( Request $request ) 
	{
		$privacypolicy =  Privacypolicy::find(1);
		$privacypolicy->main_heading = $request->main_heading;
		$privacypolicy->second_heading = $request->second_heading;
		$privacypolicy->description = $request->description;
		$privacypolicy->save();
		return back()->with('message', 'add');
	}
}