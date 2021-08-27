<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required',
            'status'=>'required',
            'user_name'=>'nullable',
            'fname'=>'nullable',
            'lname'=>'nullable',
            'phone'=>'required',
            'role'=>'required',
            'birthday'=>'nullable',
            'address'=>'required',
            'photo'=>'nullable',
            'modules'=>'array|required',
            'modules.*'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
            'account_number'=>'required',
            'fees' => 'nullable',
            'tax' => 'nullable',
            'currency'=>'nullable',
            'takeaway'=>'nullable',
        ];
    }
}
