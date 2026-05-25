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
use App\Models\Media;
/**
 * The class MediaController extends Controller class is responsible for managing the Media view 
 * Author : Syed Ali Raza
*/
class MediaController extends Controller
{  
	public function list() 
	{
		$media = Media::orderBy('id', 'DESC')->paginate(20);
		return view('backend.media.list', compact('media'));
	}

	public function add() 
	{
		return view('backend.media.add');
	}
	public function edit( $id ) 
	{
		$category = Category::find($id);
		return view('backend.categories.edit', compact('category'));
	}
	public function add_action( Request $request ) 
	{
		$name = $request->file('name');
		$nameSave = "";
		if (isset($name)) {
        	$nameSave = time() . '.' . $name->extension();
	        $path = public_path('uploads/images/');
	        $name->move($path, $nameSave);
		}
		$media = new Media();
		$media->name = $nameSave;
		
		$media->save();
		return redirect('dashboard/media')->with('message', 'add');
	}
	
	public function delete( $id ) 
	{
		Media::where('id', $id)->delete();
		return redirect('dashboard/media')->with('message', 'deleted');
	}
}