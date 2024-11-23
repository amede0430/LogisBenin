<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('property_title')->nullable(); // Ajout de la colonne pour le titre de propriété
            $table->string('identity_document')->nullable(); // Ajout de la colonne pour le document d'identité
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('property_title');
            $table->dropColumn('identity_document');
        });
    }

};
