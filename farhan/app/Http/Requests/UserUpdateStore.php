<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateStore extends FormRequest
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
            'name'=>'nullable',
            'password'=>'nullable',
            'modules'=>'array|required',
            'modules.*'=>'required',
            'phone'=>'nullable',
            'address'=>'nullable',
            'photo'=>'nullable',
            'latitude'=>'nullable',
            'longitude'=>'nullable',
            'fees' => 'nullable',
            'tax' => 'nullable',
            'account_number' => 'nullable',
            'currency'=>'nullable',
            'takeaway'=>'nullable',
        ];
    }
}
