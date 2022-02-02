<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }
    public function rules(){
        return [
            'avatar' => 'image|mimes:jpg,jpeg,png,gif,svg|max:1024|dimensions:width=128,height=128'
        ];
    }
}
