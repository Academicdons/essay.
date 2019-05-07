<?php

namespace App\Http\Controllers\Backend;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    //
    public function __invoke()
    {
        return view('backend.blogs.index')->withBlogs(Blog::orderBy('id','desc')->get());

    }

    public function newBlogView()
    {
        return view('backend.blogs.new');
    }

    public function newBlog(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|unique:blogs',
            'description'=>'required'
        ]);

        $blog=new Blog();
        $blog->title=$request->title;
        $blog->description=$request->description;
        $blog->save();


        return redirect()->route('admin.blog.all_blogs');
    }
}
