<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditPropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => "required|string",
            "description" => "required|string",
            "type" => "required|in:maison,appartement,terrain",
            "price" => "required|numeric",
            "location" => "required|string",
            "surface_area" => "required|numeric",
            "rooms" => "required|integer",
            "status" => "required|in:disponible,vendu,loué"
        ];
    }
}
