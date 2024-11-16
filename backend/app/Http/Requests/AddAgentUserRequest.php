<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAgentUserRequest extends FormRequest
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
    }
}
