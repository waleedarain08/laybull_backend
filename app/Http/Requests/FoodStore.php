<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoodStore extends FormRequest
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
            'foodcategory'=>'required',
            'name'=>'required',
            'quantity'=>'required',
            'price'=>'required',
            'fileToUpload'=>'nullable',
            'status'=>'required'
        ];
    }
}
