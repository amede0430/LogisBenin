<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ROLES = [
        'client' => 'client',
        'agent' => 'agent',
        'owner' => 'owner',
        'admin' => 'admin',  
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "name",
        "email",
        "password",
        "phone_number",
        "role",
        "agency_name",
        "tax_identification_number",
        "rccm",
        "exercise_authorization",
        "intervention_zone",
        "agency_phone",
        "agency_email",
        "rccm_copy",
        "exercise_authorization_copy",
        "address_proof",
        "property_title",
        "identity_document",
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canAddProperty(): bool
    {
        return in_array($this->role, [self::ROLES['agent'], self::ROLES['owner']]);
    }
}
