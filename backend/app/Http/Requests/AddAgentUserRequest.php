<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAgentUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'                          => 'required|string|max:255',
            'email'                         => 'required|email|unique:users',
            'password'                      => 'required|min:8',
            'phone_number'                  => 'required|numeric|unique:users',
            'agency_name'                   => 'required|string|max:255',
            'tax_identification_number'     => 'required|string|max:50',
            'rccm'                          => 'required|string|max:50',
            'rccm_copy'                     => 'required|array',  
            'rccm_copy.*'                   => 'file|mimes:pdf,jpg,png|max:2048', 
            
            'exercise_authorization_copy'   => 'required|array',  
            'exercise_authorization_copy.*' => 'file|mimes:pdf,jpg,png|max:2048', 
            
            'address_proof'                 => 'required|array',  
            'address_proof.*'               => 'file|mimes:pdf,jpg,png|max:2048', 
        ];
    }
}
