<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddOwnerUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:8',
            'phone_number'          => 'required|numeric|unique:users',
            
            'property_title'        => 'required|array', 
            'property_title.*'      => 'file|mimes:pdf,jpg,png|max:2048', 
            
            'identity_document'     => 'required|array', 
            'identity_document.*'   => 'file|mimes:pdf,jpg,png|max:2048', 
        ];
    }
}
