<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
class StorePost extends FormRequest {
    public function authorize() {
        return true;
    }
    public function rules(){
        return [
            'title'   =>'bail|required|min:5|max:100',
            'content' =>'required|min:10',
            'thumbnail'=>'image|mimes:jpg, jpeg,png,PNG | max:1024|dimensions:min_height=500'
        ];
    }
}
