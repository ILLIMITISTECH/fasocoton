<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modele extends Model
{
    //

    protected $fillable = [  
		'libelle','res_dir','nbr_jour','deadline','pourcentage', 'strategique_id'
    ];

    public function strategique(){
        return $this->belongsTo(Strategique::class);
    }
    
    public function tache_modeles(){
        return $this->hasMany(Tache_Modele::class);  
    }
    
    public function res_dir(){
        return $this->belongsTo(Agent::class);
    }
}
