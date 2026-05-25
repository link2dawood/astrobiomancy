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
use App\Models\Category;
/**
 * The class CategoryController extends Controller class is responsible for managing the Category view 
 * Author : Syed Ali Raza
*/
class CategoryController extends Controller
{  
	public function list() 
	{
		$categories = Category::orderBy('id', 'DESC')->paginate(20);
		
		return view('backend.categories.list', compact('categories'));
	}
	public function add() 
	{
		return view('backend.categories.add');
	}
	public function edit( $id ) 
	{
		$category = Category::find($id);
		return view('backend.categories.edit', compact('category'));
	}
	public function add_action( Request $request ) 
	{
		$category = new Category();
		$category->name = $request->name;
		
		$category->save();
		return redirect('dashboard/category')->with('message', 'add');
	}
	public function update_action( Request $request ) 
	{
		$category = Category::find( $request->id );
		$category->name = $request->name;
		$category->save();
		return redirect('dashboard/category')->with('message', 'update');
	}
	public function delete( $id ) 
	{
		Category::where('id', $id)->delete();
		return redirect('dashboard/category')->with('message', 'deleted');
	}
}