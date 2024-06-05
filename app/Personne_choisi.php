<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personne_choisi extends Model
{
    protected $fillable = [
       'nom', 'prenom','email','feedback_id', 'prospect_id','agents_id'
    ];
}
