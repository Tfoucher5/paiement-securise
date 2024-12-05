<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    public function up()
    {
        Schema::create('cartes_credit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('numero')->unique(); // Chiffré
            $table->date('date_expiration');
            $table->string('type')->nullable(); // Visa, MasterCard, etc.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cartes_credit');
    }
};
