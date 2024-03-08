<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'n_immatriculation',
        'raison_sociale',
        'num_agrement',
        'num_impot',
        'activite_principale',
        'quartier_entreprise',
        'commune_entreprise',
        'ville_entreprise',
        'date_creation',
        'nombre_emp',
        'efectif_homme',
        'efectif_femme',
        'efectif_apprentis',
        'categorie',
        'sigle',
        'rccm_file',
        'num_impot_file',
    ];

    public function representants(){
        return $this->hasMany(Representant::class,'entreprise_id','id');
    }
}
