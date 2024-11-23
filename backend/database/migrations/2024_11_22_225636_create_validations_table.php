<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('validations', function (Blueprint $table) {
            $table->id(); // Clé primaire
            $table->unsignedBigInteger('user_id'); // Référence à l'utilisateur (agent ou propriétaire)
            $table->enum('status', ['pending', 'validated', 'rejected'])->default('pending'); // Statut de validation
            $table->text('admin_notes')->nullable(); // Remarques de l'administrateur
            $table->text('submitted_documents')->nullable(); // Documents soumis pour validation

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Relation clé étrangère
            $table->timestamps(); // created_at et updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('validations');
    }
};
