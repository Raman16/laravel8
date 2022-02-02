<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Jobs\NotifyUsersBlogWasPosted;
use App\Mail\BlogPosted;
use App\Mail\BlogPostedMarkdown;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    public function index()
    {
        $posts = BlogPost::latest()->withCount('comments')
                                ->with('user')
                                ->with('tags')
                                ->get();
        return view('posts.index',['posts' => $posts]);
    }

    public function create()
    {
        return view('posts.create');
    }
    public function edit($id)
    {
        $post = BlogPost::findorFail($id);
        $this->authorize('update', $post);
        return view('posts.edit', ['post' => $post]);
    }
    public function store(StorePost $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->id;
        $post =  BlogPost::create($validated);
        //echo '<pre>';print_r($post->user->email);die;
        // Mail::to($post->user)->send(
        //     //new BlogPosted($post)
        //     new BlogPostedMarkdown($post)
        // );

        //send mail after some time
        //$when = now()->addMinutes(1);
        Mail::to($post->user)->queue(
            new BlogPostedMarkdown($post)
        );

        NotifyUsersBlogWasPosted::dispatch($post);
        // Mail::to($post->user)->later(
        //     $when,
        //     new BlogPostedMarkdown($post)
        // );

        $request->session()->flash('status', 'The Blog Post is Created');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }
    public function update(StorePost $request, $id)
    {

        $post = BlogPost::findOrFail($id);
        $this->authorize('update', $post);
        $validated = $request->validated();
        $post->fill($validated);
        $post->save();
        $request->session()->flash('status', 'Blog Post is updated');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }
    public function show($id)
    {
        $blogPost = Cache::remember("blog-post-{$id}", 60, function () use ($id) {
            return BlogPost::with(['comments','tags','user','comments.user'])
                ->findorFail($id);
        });
        //echo '<pre>';print_r($blogPost->toArray());die;

        return view('posts.show', ['post' => $blogPost]);
    }

    public function destroy($id)
    {

        $post = BlogPost::findOrFail($id);
        $this->authorize('delete', $post);
        $post->delete();

        session()->flash('status', 'Blog post was deleted!');

        return redirect()->route('posts.index');
    }
}
