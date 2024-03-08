<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representant extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'entreprise_id',
        'prenom',
        'nom',
        'date_naissance',
        'lieu_naissance',
        'prefecture_code',
        'email',
        'telephone',
        'type_document',
        'document',
        'photo',
    ];

    public function prefectures() {
        return $this->hasMany(Prefecture::class,'prefecture_code','code');
    }
}
