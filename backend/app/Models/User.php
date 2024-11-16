<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        "agency_creation_date",
        "legal_status",
        "street",
        "neighborhood",
        "city",
        "department",
        "gps_coordinates",
        "intervention_zone",
        "agency_phone",
        "agency_email",
        "website",
        "social_media_pages",
        "legal_representative_name",
        "legal_representative_phone",
        "legal_representative_email",
        "legal_representative_id",
        "service_types",
        "service_description",
        "property_types",
        "rccm_copy",
        "exercise_authorization_copy",
        "address_proof",
        "registered_agents",
        "tax_attestation",
        "apiex_certificate",
        "compliance_commitment",
        "customer_reviews",
        "office_photos"
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
    public function canAddProperty(): bool {
        return $this->role === "agent";
    }
}