<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Strategique extends Model
{
    //

    protected $fillable = [  
		'libelle','pourcentage','res_dir','deadline'
    ];
    
    public function activites(){
        return $this->hasMany(Activite::class);  
    }
    
    public function modeles(){
        return $this->hasMany(Modele::class);  
    }
}
