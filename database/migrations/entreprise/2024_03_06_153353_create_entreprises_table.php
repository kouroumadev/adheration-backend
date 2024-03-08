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
            $table->string('raison_sociale')->nullable();
            $table->string('num_agrement')->nullable();
            $table->string('num_impot')->nullable();
            $table->string('activite_principale')->nullable();
            $table->string('quartier_entreprise')->nullable();
            $table->string('commune_entreprise')->nullable();
            $table->string('ville_entreprise')->nullable();
            $table->string('date_creation')->nullable();
            $table->string('nombre_emp')->nullable();
            $table->string('efectif_homme')->nullable();
            $table->string('efectif_femme')->nullable();
            $table->string('efectif_apprentis')->nullable();
            $table->string('categorie')->nullable();
            $table->string('sigle')->nullable();
            $table->string('rccm_file')->nullable();
            $table->string('num_impot_file')->nullable();
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
