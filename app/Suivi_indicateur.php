<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Suivi_indicateur extends Model
{
    //
    protected $fillable = [  
		'date','pourcentage','note','indicateur','indicateur_id'
    ];
    public function indicateur(){
        return $this->belongsTo(Indicateur::class);
    }
}
