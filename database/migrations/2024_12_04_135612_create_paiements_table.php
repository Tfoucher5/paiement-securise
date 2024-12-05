<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relie le paiement à un utilisateur
            $table->decimal('montant', 10, 2); // Montant du paiement
            $table->string('carte_4_premiers'); // 4 premiers numéros de la carte
            $table->string('carte_4_derniers'); // 4 derniers numéros de la carte
            $table->date('date_expiration'); // Date d'expiration de la carte
            $table->string('num_transaction')->unique(); // Numéro unique de la transaction
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }
};
