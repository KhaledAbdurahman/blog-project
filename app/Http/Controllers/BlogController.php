<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use App\Http\Requests\UpdateBlogRequest;
use App\Models\Blog;
use App\Models\Category;
//use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\alert;

class BlogController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth')->only(['create']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check()) {
            $categories = Category::get();
            return view('theme.blogs.create', compact('categories'));
        }
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBlogRequest $request)
    {
        $data = $request->validated();

        // 1- get image
        $image = $request->image;

        // 2- change it's current name
        $newImageName = time() . '-' . $image->getClientOriginalName();

        // 3- move image to my project
        $image->storeAs('blogs', $newImageName, 'public');

        // 4- save new name to database record
        $data['image'] = $newImageName;
        $data['user_id'] = Auth::user()->id;

        // create new blog record
        Blog::create($data);

        return back()->with('blogCreateStatus', 'Your blog created successfuly');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('theme.single-Blog', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        if ($blog->user_id == Auth::user()->id) {
            $categories = Category::get();
            return view('theme.blogs.edit', compact('categories', 'blog'));
        }
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        if ($blog->user_id == Auth::user()->id) {
            $data = $request->validated();

            if ($request->hasFile('image')) {

                // 0- delete the old image.
                Storage::delete("public/blogs/$blog->image");

                // 1- get image
                $image = $request->image;

                // 2- change it's current name
                $newImageName = time() . '-' . $image->getClientOriginalName();

                // 3- move image to my project
                $image->storeAs('blogs', $newImageName, 'public');

                // 4- save new name to database record
                $data['image'] = $newImageName;
            }

            // update blog record
            $blog->update($data);

            return back()->with('blogUpdateStatus', 'Your blog updated successfuly');
        }
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        if ($blog->user_id == Auth::user()->id) {
            Storage::delete("public/blogs/$blog->image");
            $blog->delete();
            return back()->with('blogDeleteStatus', 'Your blog updated successfuly');
        }
        alert(403);
    }

    /**
     * Display all user's blogs.
     */
    public function myBlogs()
    {
        if (Auth::check()) {
            $blogs = Blog::where('user_id', Auth::user()->id)->paginate(8);
            return view('theme.blogs.my-blogs', compact('blogs'));
        }
        abort(403);
    }
}
