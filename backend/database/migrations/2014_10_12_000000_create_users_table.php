<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('users', function (Blueprint $table) {
        $table->id(); // Clé primaire
        $table->string('name')->nullable(); // Nom de l'utilisateur
        $table->string('email')->unique()->nullable(); // Email unique
        $table->string('password')->nullable(); // Mot de passe
        $table->enum('role', ['client', 'agent', 'admin'])->nullable(); // Rôle
        $table->string('phone_number')->nullable(); // Téléphone

        // Informations sur l'agence
        $table->string('agency_name')->nullable(); // Nom de l'agence
        $table->string('tax_identification_number')->nullable(); // Numéro d'identification fiscale (NIF)
        $table->string('rccm')->nullable(); // RCCM
        $table->string('exercise_authorization')->nullable(); // Autorisation d'exercice
        $table->date('agency_creation_date')->nullable(); // Date de création de l'agence
        $table->string('legal_status')->nullable(); // Statut juridique (SARL, SAS, etc.)

        // Adresse de l'agence
        $table->string('street')->nullable(); // Rue
        $table->string('neighborhood')->nullable(); // Quartier
        $table->string('city')->nullable(); // Ville
        $table->string('department')->nullable(); // Département
        $table->string('gps_coordinates')->nullable(); // Coordonnées GPS
        $table->string('intervention_zone')->nullable(); // Zone d'intervention

        // Coordonnées de contact
        $table->string('agency_phone')->nullable(); // Numéro de téléphone principal
        $table->string('agency_email')->nullable(); // Adresse email professionnelle
        $table->string('website')->nullable(); // Site web
        $table->text('social_media_pages')->nullable(); // Pages sur les réseaux sociaux

        // Responsable légal
        $table->string('legal_representative_name')->nullable(); // Nom et prénom
        $table->string('legal_representative_phone')->nullable(); // Numéro de téléphone
        $table->string('legal_representative_email')->nullable(); // Adresse email
        $table->string('legal_representative_id')->nullable(); // Pièce d’identité (CNI ou passeport)

        // Informations sur les services proposés
        $table->text('service_types')->nullable(); // Types de services offerts
        $table->text('service_description')->nullable(); // Description des services
        $table->text('property_types')->nullable(); // Types de biens immobiliers traités

        // Documents à fournir
        $table->string('rccm_copy')->nullable(); // Copie du RCCM
        $table->string('exercise_authorization_copy')->nullable(); // Copie de l'autorisation d'exercice
        $table->string('address_proof')->nullable(); // Preuve d'adresse
        $table->text('registered_agents')->nullable(); // Liste des agents immobiliers

        // Vérification de conformité
        $table->string('tax_attestation')->nullable(); // Attestation fiscale
        $table->string('apiex_certificate')->nullable(); // Certification ou reconnaissance APIEx
        $table->string('compliance_commitment')->nullable(); // Engagement à respecter la législation

        // Autres informations
        $table->text('customer_reviews')->nullable(); // Avis clients
        $table->text('office_photos')->nullable(); // Photos du siège et des bureaux

        $table->timestamps(); // created_at et updated_at
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
