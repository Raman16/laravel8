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
use Illuminate\Support\Facades\Storage;

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
        //$validated = $request->validated();
        //$validated['user_id'] = Auth::user()->id;
        //$post =  BlogPost::create($validated);
        $hasFile = $request->hasFile('thumbnail');
        if($hasFile){
            $file = $request->file('thumbnail');
        }
      
        $file->store('thumbnails');
        Storage::disk('public')->putFile('thumbnails',$file);

        $name1 = $file->storeAs('thumbnails',"test3.".$file->guessExtension());
        $name2 = Storage::disk('local')->putFileAs('thumbnails',$file,'test2.'.$file->guessExtension());
        
        var_dump(Storage::url($name1));//by default disk is public
        var_dump(Storage::url($name2));//by default disk is public
        ////Now Below code   will search in storage/app
        var_dump(Storage::disk('local')->url($name2));
   


        
        die;
        //$request->session()->flash('status', 'The Blog Post is Created');
        //return redirect()->route('posts.show', ['post' => $post->id]);
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
