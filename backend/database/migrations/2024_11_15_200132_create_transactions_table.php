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
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('property_id')->constrained()->onDelete('cascade');
        $table->decimal('amount', 10, 2)->nullable();
        $table->timestamp('transaction_date')->default(DB::raw('CURRENT_TIMESTAMP'))->nullable();
        $table->enum('status', ['en attente', 'payé', 'échoué'])->nullable();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
