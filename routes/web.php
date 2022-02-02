<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\UserCommentController;
use App\Http\Controllers\UserController;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//HomeController::class ->Magic constant 'class' will give us 
//fully qualified class name -> App\Http\Controllers\HomeController

Route::get('/', [HomeController::class, 'home'])->name('home.index');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');

Route::get('secret', [HomeController::class, 'secret'])
    ->name('secret')
    ->middleware('can:home.secret'); //'can' uses Authorization system 
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/single', AboutController::class);
Route::resource('posts.comments', PostCommentController::class)->only(['store']);
Route::resource('users.comments', UserCommentController::class)->only(['store']);
Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

Auth::Routes();

// Route::view('/', 'home.index')->name('home.index');
// Route::view('/contact', 'home.contact')->name('home.contact');

$posts = [
    1 => [
        'title' => 'Intro to Laravel',
        'content' => 'This is a short intro to Laravel',
        'is_new' => true,
        'has_comments' => true
    ],
    2 => [
        'title' => 'Intro to PHP',
        'content' => 'This is a short intro to PHP',
        'is_new' => false,
        'has_comments' => false

    ]
];

// Route::resource('posts', PostsController::class)
// ->only(['index', 'show','create','store','edit','update']);


Route::resource('posts', PostsController::class);


// Route::get('/posts', function (Request $request) use ($posts) {
//     //dd($request->all());
//     dd($request->input('name'));
//     return view('posts.index', ['posts' => $posts]);
// });

// Route::get('/posts/{id}', function ($id) use ($posts) {

//     abort_if(!isset($posts[$id]), 404);

//     return view('posts.show', ['post' => $posts[$id]]);
// })
//     ->where(['id' => '[0-9]+'])
//     ->name('posts.show');



Route::get('/recent-post/{daysago?}', function ($daysAgo = 2) {
    return 'Posts from ' . $daysAgo . ' days ago';
})->name('posts.recent.index');
Route::get('/posts/tag/{tag}', [PostTagController::class, 'index'])->name('posts.tags.index');


Route::prefix('/fun')->name('fun.')->group(function ()  use ($posts) {

    Route::get('response', function () use ($posts) {
        return response($posts, 201)
            ->header('Content-Type', 'application/json')
            ->cookie('MY_COOKIE', 'Raman');
    })->name('response');
    Route::get('redirect', function () {
        return redirect('/contact');
    })->name('redirect');
    Route::get('back', function () {
        return back();
    })->name('back');
    Route::get('named-route', function () {
        return redirect()->route('posts.show', ['id' => 1]);
    })->name('named-route');
    Route::get('away', function () {
        return redirect()->away('https://google.com');
    })->name('away');
    Route::get('json', function () use ($posts) {
        return response()->json($posts);
    })->name('json');
    Route::get('download', function () use ($posts) {
        return response()->download(public_path('phpinterpreter.PNG', 'phpI.PNG'));
    })->name('download');
});

//Auth::routes();


Route::get('mailable', function () {
    $blogpost = BlogPost::findOrFail(1);
    return new App\Mail\BlogPostedMarkdown($blogpost);
});
