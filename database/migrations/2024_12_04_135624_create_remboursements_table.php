<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('remboursements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paiement_id');
            $table->unsignedBigInteger('carte_id');
            $table->foreign('paiement_id')->references('id')->on('paiements')->onDelete('cascade');
            $table->foreign('carte_id')->references('id')->on('carte_credits')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('remboursements');
    }
};
