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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('n_immatriculation')->nullable();
            $table->string('raison_sociale');
            $table->string('num_agrement');
            $table->string('num_impot');
            $table->string('activite_principale');
            $table->string('quartier_entreprise');
            $table->string('commune_entreprise');
            $table->string('ville_entreprise');
            $table->string('nombre_emp');
            $table->string('effectif_homme')->nullable();
            $table->string('effectif_femme')->nullable();
            $table->string('boite_postale');
            $table->string('sigle')->nullable();
            $table->string('categorie');
            $table->string('rccm_file');
            $table->string('num_import_file');
            $table->string('adresse');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
