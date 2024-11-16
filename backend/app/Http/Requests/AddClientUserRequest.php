<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddClientUserRequest extends FormRequest
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
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|string",
            "phone_number" => "required|string|min:6",
        ];
    }
}
$table->string('name')->nullable(); // Nom de l'utilisateur
        $table->string('email')->unique()->nullable(); // Email unique
        $table->string('password')->nullable(); // Mot de passe
        $table->enum('role', ['client', 'agent', 'admin'])->nullable(); // Rôle
        $table->string('phone_number')->nullable(); // Téléphone