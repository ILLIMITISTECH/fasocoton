<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Indicateur extends Model
{
    //

    protected $fillable = [  
		'libelle','cible'
    ];

    public function suivi_indicateurs(){
        return $this->hasMany(Suivi_indicateur::class);  
    }
}
