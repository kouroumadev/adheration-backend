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
        Schema::create('representants', function (Blueprint $table) {
            $table->id();
            $table->string('document_identite');
            $table->string('prenom');
            $table->string('nom');
            $table->string('ville_reprsentant')->nullable();
            $table->string('telephone_representant');
            $table->string('email');
            $table->string('adresse_representant');
            $table->foreignId('entreprise_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representants');
    }
};
