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

class ExecuteCodeProducteurIndividuel extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "execute:producteur_individuel";
    
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
        //$gn =  https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/624f599e7c7ca6ace77ece7d18d88ecc/feed
        // last lien odata producteur_individuels https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/28ced5c7712c373ff3f135ff35147388/feed

          DB::table('producteur_individuels_checks')->delete();  
        $producteur_individuels = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/28ced5c7712c373ff3f135ff35147388/feed?limit=50000');
        $quizzes = json_decode($producteur_individuels->body());
        
        //  dd($quizzes);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
       //dd($quizzes_ara[1]);
        //$i = 1;
        foreach($quizzes_ara[1] as $dataODATA){
           
            DB::table('producteur_individuels_checks')->insert(['caseid' => $dataODATA->caseid, 'actif' => $dataODATA->actif, 'age_producteur' => $dataODATA->age_producteur, 'closed' => $dataODATA->closed, 'genre' => $dataODATA->genre,
            'nom_producteur' => $dataODATA->nom_producteur, 'niveau_alphabetisation' => $dataODATA->niveau_alphabetisation,
            'date_de_naissance' => $dataODATA->date_de_naissance, 'type_exploitation' => $dataODATA->type_exploitation,
            'prenom_producteur' => $dataODATA->prenom_producteur,
            'case_id_scoop_selectionne' => $dataODATA->case_id_scoop_selectionne, 'case_link' => $dataODATA->case_link, 'closed_by_username' => $dataODATA->closed_by_username,
            'closed_date' => $dataODATA->closed_date,  'cnib_passport' => $dataODATA->cnib_passport,  'departement_origine' => $dataODATA->departement_origine,
            'desactiver_producteur' => $dataODATA->desactiver_producteur, 'last_modified_by_user_username' => $dataODATA->last_modified_by_user_username,
            'last_modified_date' => $dataODATA->last_modified_date, 'motif' => $dataODATA->motif, 'name' => $dataODATA->name, 'niveau_etude' => $dataODATA->niveau_etude,
             'nom_prenom_producteur' => $dataODATA->nom_prenom_producteur, 'num_whatsapp_oui_non' => $dataODATA->num_whatsapp_oui_non, 'number' => $dataODATA->number,
             'numero_whatsapp' => $dataODATA->numero_whatsapp, 'opened_by_username' => $dataODATA->opened_by_username, 'opened_date' => $dataODATA->opened_date, 
             'owner_name' => $dataODATA->owner_name, 'tel_1' => $dataODATA->tel_1, 'tel_2' => $dataODATA->tel_2, 'type_exploitant' => $dataODATA->type_exploitant,
             'username' => $dataODATA->username, 'village_origine' => $dataODATA->village_origine
            
            ]);

                    
            
        }
        
        if(count($quizzes_ara[1]) >= 10000){
        $producteur_individuelsafters = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/28ced5c7712c373ff3f135ff35147388/feed?after_id=10000&limit=10000&offset=10000');
        $quizzesafters = json_decode($producteur_individuelsafters->body());
        
        // dd($quizzes);
        $quizzes_araafters = array();
         foreach($quizzesafters as $quizzeafter){
             array_push($quizzes_araafters, $quizzeafter);
         }
       //dd($quizzes_ara[1]);
        //$i = 1;
        foreach($quizzes_araafters[1] as $dataODATAafter){
           
          DB::table('producteur_individuels_checks')->insert(['caseid' => $dataODATAafter->caseid, 'actif' => $dataODATAafter->actif, 'age_producteur' => $dataODATAafter->age_producteur, 'closed' => $dataODATAafter->closed, 'genre' => $dataODATAafter->genre,
            'nom_producteur' => $dataODATAafter->nom_producteur, 'niveau_alphabetisation' => $dataODATAafter->niveau_alphabetisation,
            'date_de_naissance' => $dataODATAafter->date_de_naissance, 'type_exploitation' => $dataODATAafter->type_exploitation,
            'prenom_producteur' => $dataODATAafter->prenom_producteur,
            'case_id_scoop_selectionne' => $dataODATAafter->case_id_scoop_selectionne, 'case_link' => $dataODATAafter->case_link, 'closed_by_username' => $dataODATAafter->closed_by_username,
            'closed_date' => $dataODATAafter->closed_date,  'cnib_passport' => $dataODATAafter->cnib_passport,  'departement_origine' => $dataODATAafter->departement_origine,
            'desactiver_producteur' => $dataODATAafter->desactiver_producteur, 'last_modified_by_user_username' => $dataODATAafter->last_modified_by_user_username,
            'last_modified_date' => $dataODATAafter->last_modified_date, 'motif' => $dataODATAafter->motif, 'name' => $dataODATAafter->name, 'niveau_etude' => $dataODATAafter->niveau_etude,
             'nom_prenom_producteur' => $dataODATAafter->nom_prenom_producteur, 'num_whatsapp_oui_non' => $dataODATAafter->num_whatsapp_oui_non, 'number' => $dataODATAafter->number,
             'numero_whatsapp' => $dataODATAafter->numero_whatsapp, 'opened_by_username' => $dataODATAafter->opened_by_username, 'opened_date' => $dataODATAafter->opened_date, 
             'owner_name' => $dataODATAafter->owner_name, 'tel_1' => $dataODATAafter->tel_1, 'tel_2' => $dataODATAafter->tel_2, 'type_exploitant' => $dataODATAafter->type_exploitant,
             'username' => $dataODATAafter->username, 'village_origine' => $dataODATAafter->village_origine
            
            ]);
                    
            
        }
        }
        
        $check1 = DB::table('producteur_individuels_checks')->pluck('caseid')->toArray();
        
        $check2 = DB::table('producteur_individuels')->pluck('caseid')->toArray(); 
        
        $results = array_diff($check1, $check2);
        
        $show_result1s = array();
        foreach($results as $result)
        {
            
            $checkA1s = DB::table('producteur_individuels_checks')->where('caseid', $result)->get();
            
            foreach($checkA1s as $checkA1)
            {  
                
                array_push($show_result1s, $checkA1);
            }
        }
        
        
         foreach($show_result1s as $show_result1){
           
            DB::table('producteur_individuels')->insert(['caseid' => $show_result1->caseid,
            'actif' => $show_result1->actif, 'age_producteur' => $show_result1->age_producteur, 
            'closed' => $show_result1->closed, 'genre' => $show_result1->genre,
            'nom_producteur' => $show_result1->nom_producteur, 'niveau_alphabetisation' => $show_result1->niveau_alphabetisation,
            'date_de_naissance' => $show_result1->date_de_naissance, 'type_exploitation' => $show_result1->type_exploitation,
            'prenom_producteur' => $show_result1->prenom_producteur,
            'case_id_scoop_selectionne' => $show_result1->case_id_scoop_selectionne, 
            'case_link' => $show_result1->case_link, 'closed_by_username' => $show_result1->closed_by_username,
            'closed_date' => $show_result1->closed_date,  'cnib_passport' => $show_result1->cnib_passport, 
            'departement_origine' => $show_result1->departement_origine,
            'desactiver_producteur' => $show_result1->desactiver_producteur, 
            'last_modified_by_user_username' => $show_result1->last_modified_by_user_username,
            'last_modified_date' => $show_result1->last_modified_date, 'motif' => $show_result1->motif,
            'name' => $show_result1->name, 'niveau_etude' => $show_result1->niveau_etude,
             'nom_prenom_producteur' => $show_result1->nom_prenom_producteur, 
             'num_whatsapp_oui_non' => $show_result1->num_whatsapp_oui_non, 'number' => $show_result1->number,
             'numero_whatsapp' => $show_result1->numero_whatsapp, 'opened_by_username' => $show_result1->opened_by_username,
             'opened_date' => $show_result1->opened_date, 
             'owner_name' => $show_result1->owner_name, 'tel_1' => $show_result1->tel_1, 
             'tel_2' => $show_result1->tel_2, 'type_exploitant' => $show_result1->type_exploitant,
             'username' => $show_result1->username, 'village_origine' => $show_result1->village_origine
            
            ]); 
   
            
        }
        $this->info('Le Code a été executé');
    }
    
}
