<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representant extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'prenom' ,
        'entreprise_id',
        'nom',
        'document_identite',
        'email',
        'telephone_representant',
        'adresse_representant',
        'ville_representant'
    ];
}
