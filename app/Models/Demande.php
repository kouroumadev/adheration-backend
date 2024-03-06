<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'entreprise_id',
        'representant_id',
        'type_demande',
        'code_demande',
        'status_demande'
    ];

    public function entreprises(){

        return $this->belongsTo(Entreprise::class,'entreprise_id');
    }
    public function representants(){

        return $this->belongsTo(Representant::class,'representant_id','id');
    }
}
