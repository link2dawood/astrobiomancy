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
use App\Models\Blog;
use App\Models\Comments;
use App\Http\Middleware\SetLocale;
/**
 * The class BlogController extends Controller class is responsible for managing the blog view
 * Author : Syed Ali Raza
*/
class BlogController extends Controller
{
	public function list()
	{
		// Show all posts; the lang column lets editors see which language each row is in.
		$blogs = Blog::orderBy('id', 'DESC')->paginate(20);
		return view('backend.blogs.list', compact('blogs'));
	}

	public function comments( $id ) 
	{
		$comments = Comments::where('post_id', $id)->orderBy('id', 'DESC')->paginate(20);
		return view('backend.blogs.comments', compact('comments'));
	}

	public function add()
	{
		$users = User::all();
		$category = Category::all();
		$locales = SetLocale::SUPPORTED;
		$translation_parents = Blog::whereNull('translation_of')->orderBy('title')->get(['id', 'title', 'lang']);
		return view('backend.blogs.add', compact('users', 'category', 'locales', 'translation_parents'));
	}
	public function edit( $id )
	{
		$users = User::all();
		$category = Category::all();
		$blog = Blog::find($id);
		$locales = SetLocale::SUPPORTED;
		$translation_parents = Blog::whereNull('translation_of')->where('id', '!=', $id)->orderBy('title')->get(['id', 'title', 'lang']);
		return view('backend.blogs.edit', compact('users', 'category', 'blog', 'locales', 'translation_parents'));
	}
	public function add_action( Request $request ) 
	{
		$slug = $this->createSlug($request->title);

		$blogExist = Blog::where('slug', $slug)->count();
		if ($blogExist>0) {
			$slug.=rand(100,10000);
		}
		$image = $request->file('image');
		$imageName = "";
		if (isset($image)) {
        	$imageName = time() . '.' . $image->extension();
	        $path = public_path('uploads/images/');
	        $image->move($path, $imageName);
		}


		$blog = new Blog();
		$blog->title = $request->title;
		$blog->category_id = $request->category_id;
		$blog->description = $request->description;
		$blog->author_id = $request->author_id;
		$blog->status = $request->status;
		$blog->meta_keyword = $request->meta_keyword;
		$blog->meta_title = $request->meta_title;
		$blog->meta_description = $request->meta_description;
		$blog->lang = in_array($request->lang, SetLocale::SUPPORTED, true) ? $request->lang : SetLocale::DEFAULT;
		$blog->translation_of = $request->translation_of ?: null;
		$blog->slug = $slug;
		$blog->image = $imageName;
		$blog->save();
		return redirect('dashboard/blog/post')->with('message', 'add');
	}

	public function createSlug($title) {
	    // Convert to lowercase
	    $slug = strtolower($title);
	    
	    // Replace spaces with dashes
	    $slug = str_replace(' ', '-', $slug);
	    
	    // Remove special characters
	    $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
	    
	    return $slug;
	}

	public function update_action( Request $request ) 
	{
		$slug = $this->createSlug($request->title);

		$blogExist = Blog::where('slug', $slug)->where('id', '!=', $request->id)->count();
		if ($blogExist>0) {
			$slug.=rand(100,10000);
		}
		$image = $request->file('image');
		$imageName = "";
		if (isset($image)) {
        	$imageName = time() . '.' . $image->extension();
	        $path = public_path('uploads/images/');
	        $image->move($path, $imageName);
		}


		$blog =  Blog::find($request->id);
		$blog->title = $request->title;
		$blog->category_id = $request->category_id;
		$blog->description = $request->description;
		$blog->author_id = $request->author_id;
		$blog->status = $request->status;
		$blog->meta_keyword = $request->meta_keyword;
		$blog->meta_title = $request->meta_title;
		$blog->meta_description = $request->meta_description;
		if (in_array($request->lang, SetLocale::SUPPORTED, true)) {
			$blog->lang = $request->lang;
		}
		$blog->translation_of = $request->translation_of ?: null;
		$blog->slug = $slug;
		if ($imageName!='') {

			$blog->image = $imageName;
		}
		$blog->save();

		return redirect('dashboard/blog/post')->with('message', 'update');

	}
	public function delete( $id ) 
	{
		Blog::where('id', $id)->delete();
		return redirect('dashboard/blog/post')->with('message', 'deleted');
	}

	public function deletecomment( $id ) 
	{
		Comments::where('id', $id)->delete();
		return back()->with('message', 'deleted');
	}
}