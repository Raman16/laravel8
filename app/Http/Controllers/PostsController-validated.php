<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        return view('posts.index', ['posts' => BlogPost::all()]);
    }
    public function create()
    {
        return view('posts.create');
    }
    public function store(StorePost $request)
    {


        $validated = $request->validated();

        $post = new BlogPost();
        $post->title = $validated['title'];
        $post->content = $validated['content'];
        $post->save();
        
        //BlogPost::create();
        
        $request->session()->flash('status','The Blog Post is Created');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }
    public function show($id)
    {
        return view('posts.show', ['post' => BlogPost::findOrFail($id)]);
    }
}
