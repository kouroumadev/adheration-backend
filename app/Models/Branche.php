<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branche extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'version',
        'code',
        'domain_activite_id',
        'libelle',
        'tagsup',

    ];

    protected $table = 'branche';

}
