<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\Mail;
use Session;

use App\Action;

use Auth;

use App\User;
use App\Agent;
use DB;
use App\Producteur;
use Illuminate\Support\Facades\Http;

use App\Notifications\EscalationAction;
use App\Notifications\EscalationActionResponsable;
use App\Notifications\AlerteEscalation;
use Notification;

class ExecuteProducteurTest extends Command
{   
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "execute:producteurTest";
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mise a jour de  l activitée';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    { 
         //$new_token = $exoclick_token;
            
         
            
        //$gn =  https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/624f599e7c7ca6ace77ece7d18d88ecc/feed
     DB::table('producteurs_test')->delete();  
     //https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/eb3a560916b8aa068ee1f945653c8359/feed
    //$producteurs = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/624f599e7c7ca6ace77ece7d18d88ecc/feed');
    $producteurs = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/eb3a560916b8aa068ee1f945653c8359/feed?after_id=10000');
    
        $quizzes = json_decode($producteurs->body());
        //  dd($quizzes);
        // https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/f9eef4d068b9d1c9ac0c5b2f1ecdbd2c/feed$metadata#feed
        //dd($quizzes);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
       dd(($quizzes_ara));
        //$i = 1;
        foreach($quizzes_ara[2] as $dataODATA){
           //dd($dataODATA->prenom_producteur);
           
            DB::table('producteurs_test')->insert(['caseid' => $dataODATA->caseid, 'actif' => $dataODATA->actif, 'closed' => $dataODATA->closed, 'genre' => $dataODATA->genre,
            'nom_producteur' => $dataODATA->nom_producteur, 'code_producteur' => $dataODATA->code_producteur,
            'code_scoop_producteur' => $dataODATA->code_scoop_producteur, 'date_de_naissance' => $dataODATA->date_de_naissance,
            'zone' => $dataODATA->zone, 'section' => $dataODATA->section, 'prenom_producteur' => $dataODATA->prenom_producteur, 'zone_cotoniere' => $dataODATA->zone_cotoniere, 'campagne_coton' => $dataODATA->campagne_coton, 'niveau_dalphabetisation' => $dataODATA->niveau_alphabetisation, 'owner_name' => $dataODATA->owner_name]);
        }
        
        if($quizzes_ara[1] >= 10000)
        {
        $producteursafter = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/0b97ec20144124e9c88d5b7cb7170dff/feed?after_id=10000&limit=50000&offset=10000');
       
        $quizzesafters = json_decode($producteursafter->body());

        // https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/f9eef4d068b9d1c9ac0c5b2f1ecdbd2c/feed$metadata#feed
        //dd($quizzes);
        $quizzes_araafters = array();
         foreach($quizzesafters as $quizzesafter){
             array_push($quizzes_araafters, $quizzesafter);
         }
       //dd(($quizzes_araafters[2]));
        //$i = 1;
        foreach($quizzes_araafters[2] as $dataODATAaf){
           //dd($dataODATA->prenom_producteur);
           
            DB::table('producteurs_test')->insert(['caseid' => $dataODATAaf->caseid, 'actif' => $dataODATAaf->actif, 'closed' => $dataODATAaf->closed, 'genre' => $dataODATAaf->genre,
            'nom_producteur' => $dataODATAaf->nom_producteur, 'code_producteur' => $dataODATAaf->code_producteur,
            'code_scoop_producteur' => $dataODATAaf->code_scoop_producteur, 'date_de_naissance' => $dataODATAaf->date_de_naissance,
            'zone' => $dataODATAaf->zone, 'section' => $dataODATAaf->section, 'prenom_producteur' => $dataODATAaf->prenom_producteur, 'zone_cotoniere' => $dataODATAaf->zone_cotoniere, 'campagne_coton' => $dataODATAaf->campagne_coton, 'niveau_dalphabetisation' => $dataODATAaf->niveau_alphabetisation, 'owner_name' => $dataODATAaf->owner_name]);
        }
        }
        
        
        if($quizzes_ara[2] >= 20000)
        {
        $producteursafter = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/0b97ec20144124e9c88d5b7cb7170dff/feed?after_id=10000&limit=50000&offset=20000');
       
        $quizzesafters = json_decode($producteursafter->body());
    //  dd($quizzesafters);
        // https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/f9eef4d068b9d1c9ac0c5b2f1ecdbd2c/feed$metadata#feed
        //dd($quizzes);
        $quizzes_araafters = array();
         foreach($quizzesafters as $quizzesafter){
             array_push($quizzes_araafters, $quizzesafter);
         }
       //dd(($quizzes_ara));
        //$i = 1;
        foreach($quizzes_araafters[1] as $dataODATAaf){
           //dd($dataODATA->prenom_producteur);
           
            DB::table('producteurs_test')->insert(['caseid' => $dataODATAaf->caseid, 'actif' => $dataODATAaf->actif, 'closed' => $dataODATAaf->closed, 'genre' => $dataODATAaf->genre,
            'nom_producteur' => $dataODATAaf->nom_producteur, 'code_producteur' => $dataODATAaf->code_producteur,
            'code_scoop_producteur' => $dataODATAaf->code_scoop_producteur, 'date_de_naissance' => $dataODATAaf->date_de_naissance,
            'zone' => $dataODATAaf->zone, 'section' => $dataODATAaf->section, 'prenom_producteur' => $dataODATAaf->prenom_producteur, 'zone_cotoniere' => $dataODATAaf->zone_cotoniere, 'campagne_coton' => $dataODATAaf->campagne_coton, 'niveau_dalphabetisation' => $dataODATAaf->niveau_alphabetisation, 'owner_name' => $dataODATAaf->owner_name]);
        }
        }
    
        $this->info('Le Code a été executé');
    }
    
}
