<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    //

    protected $fillable = [  
		'libelle','res_dir','deadline'
    ];

    public function activite(){
        return $this->belongsTo(Activite::class);
    }
}
