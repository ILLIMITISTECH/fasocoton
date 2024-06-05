<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tache_modele extends Model
{
    //

    protected $fillable = [  
		'libelle','res_dir','deadline'
    ];

    public function modele(){
        return $this->belongsTo(Modele::class);
    }
}
