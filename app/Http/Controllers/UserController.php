<?php
namespace App\Http\Controllers;

use App\Http\Requests\UpdateUser;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
class UserController extends Controller {
    public function __construct() {
        $this->middleware('auth');
        $this->authorizeResource(User::class,'user');
    }
    public function index(){
    }
    public function create() {
    }
    public function store(Request $request) {
    }
    public function show(User $user){
        return view('users.show',['user'=>$user]);
    }
    public function edit(User $user){
        return view('users.edit',['user'=>$user]);
    }
    public function update(Request $request, User $user){
        if($request->hasFile('avatar')){
            $path = $request->file('avatar')->store('avatars');
            if($user->image){//Route Model Binding ($user obj)
               $user->image->path = $path;
               $user->image->save();
            }
            else{
                $user->image()->save(//Route Model Binding ($user obj)
                    Image::make(['path'=>$path])//fill attr->path
                );
            }
        }
        return redirect()->back()->withStatus('Profile image was updated');
    }
    public function destroy(User $user) {
    }
}
