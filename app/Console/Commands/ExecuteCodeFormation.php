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

class ExecuteCodeFormation extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "execute:formation";
    
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
        // last lien odata scoops https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/28ced5c7712c373ff3f135ff352f8687/feed
        
        // last lien Formation https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/543bd9d4e923eeef9bdba469c0ae5d1b/feed



         DB::table('formations_checks')->delete();  
        $scoops = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/543bd9d4e923eeef9bdba469c0ae5d1b/feed?limit=50000');
        $quizzes = json_decode($scoops->body());
        
    //   dd($quizzes);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
       //dd($quizzes_ara[1]);
        //$i = 1;
        foreach($quizzes_ara[1] as $dataODATA){
           if($dataODATA->campagne_coton !== "22-23"){
            DB::table('formations_checks')->insert(['annee_Y' => $dataODATA->annee_Y, 'annee_Y_moins_1' => $dataODATA->annee_Y_moins_1, 
            'annee_Y_plus_1' => $dataODATA->annee_Y_plus_1, 'annee_Y_plus_2' => $dataODATA->annee_Y_plus_2, 
            'appreciation_formation' => $dataODATA->appreciation_formation, 'campagne_coton' => $dataODATA->campagne_coton,
            'campagne_courante_id' => $dataODATA->campagne_courante_id, 'campagne_precedante_id' => $dataODATA->campagne_precedante_id,
            'campagne_suivante_id' => $dataODATA->campagne_suivante_id, 'case_id_scoop_selectionne' => $dataODATA->case_id_scoop_selectionne, 
            'case_link' => $dataODATA->case_link, 'caseid' => $dataODATA->caseid,
            'choix_campagne' => $dataODATA->choix_campagne, 'closed' => $dataODATA->closed,
            'closed_by_username' => $dataODATA->closed_by_username, 'date_enreg' => $dataODATA->date_enreg,
            'date_formation' => $dataODATA->date_formation,
            'last_modified_by_user_username' => $dataODATA->last_modified_by_user_username,
            'last_modified_date' => $dataODATA->last_modified_date, 'liste_formation' => $dataODATA->liste_formation,
            'name' => $dataODATA->name, 'nom_prenom_formation' => $dataODATA->nom_prenom_formation,
            'number' => $dataODATA->number, 'opened_by_username' => $dataODATA->opened_by_username,
            'opened_date' => $dataODATA->opened_date, 'owner_name' => $dataODATA->owner_name,
            'producteurs_formes' => $dataODATA->producteurs_formes
            ]);
           }        
            
        }
        
        if(count($quizzes_ara[1]) >= 10000){
        $scoopsafters = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/543bd9d4e923eeef9bdba469c0ae5d1b/feed?after_id=10000&limit=10000&offset=10000');
        $quizzesafters = json_decode($scoopsafters->body());
        
        // dd($quizzes);
        $quizzes_araafters = array();
         foreach($quizzesafters as $quizzeafter){
             array_push($quizzes_araafters, $quizzeafter);
         }
       //dd($quizzes_ara[1]);
        //$i = 1;
        foreach($quizzes_araafters[1] as $dataODATAafter){
           if($dataODATAafter->campagne_coton !== "22-23"){
            DB::table('formations_checks')->insert(['annee_Y' => $dataODATAafter->annee_Y, 'annee_Y_moins_1' => $dataODATAafter->annee_Y_moins_1, 
            'annee_Y_plus_1' => $dataODATAafter->annee_Y_plus_1, 'annee_Y_plus_2' => $dataODATAafter->annee_Y_plus_2, 
            'appreciation_formation' => $dataODATAafter->appreciation_formation, 'campagne_coton' => $dataODATAafter->campagne_coton,
            'campagne_courante_id' => $dataODATAafter->campagne_courante_id, 'campagne_precedante_id' => $dataODATAafter->campagne_precedante_id,
            'campagne_suivante_id' => $dataODATAafter->campagne_suivante_id, 'case_id_scoop_selectionne' => $dataODATAafter->case_id_scoop_selectionne, 
            'case_link' => $dataODATAafter->case_link, 'caseid' => $dataODATAafter->caseid,
            'choix_campagne' => $dataODATAafter->choix_campagne, 'closed' => $dataODATAafter->closed,
            'closed_by_username' => $dataODATAafter->closed_by_username, 'date_enreg' => $dataODATAafter->date_enreg,
            'date_formation' => $dataODATAafter->date_formation,
            'last_modified_by_user_username' => $dataODATAafter->last_modified_by_user_username,
            'last_modified_date' => $dataODATAafter->last_modified_date, 'liste_formation' => $dataODATAafter->liste_formation,
            'name' => $dataODATAafter->name, 'nom_prenom_formation' => $dataODATAafter->nom_prenom_formation,
            'number' => $dataODATAafter->number, 'opened_by_username' => $dataODATAafter->opened_by_username,
            'opened_date' => $dataODATAafter->opened_date, 'owner_name' => $dataODATAafter->owner_name,
            'producteurs_formes' => $dataODATAafter->producteurs_formes
            ]);                     
           }
        }
        }
        
         $check1 = DB::table('formations_checks')->pluck('caseid')->toArray();
        
        $check2 = DB::table('formations')->pluck('caseid')->toArray(); 
        
        $results = array_diff($check1, $check2);
        
        $show_result1s = array();
        foreach($results as $result)
        {
            
            $checkA1s = DB::table('formations_checks')->where('caseid', $result)->get();
            
            foreach($checkA1s as $checkA1)
            {  
                
                array_push($show_result1s, $checkA1);
            }
        }
        
        
         foreach($show_result1s as $show_result1){
           
             DB::table('formations')->insert(['annee_Y' => $show_result1->annee_Y, 'annee_Y_moins_1' => $show_result1->annee_Y_moins_1, 
            'annee_Y_plus_1' => $show_result1->annee_Y_plus_1, 'annee_Y_plus_2' => $show_result1->annee_Y_plus_2, 
            'appreciation_formation' => $show_result1->appreciation_formation, 'campagne_coton' => $show_result1->campagne_coton,
            'campagne_courante_id' => $show_result1->campagne_courante_id, 'campagne_precedante_id' => $show_result1->campagne_precedante_id,
            'campagne_suivante_id' => $show_result1->campagne_suivante_id, 'case_id_scoop_selectionne' => $show_result1->case_id_scoop_selectionne, 
            'case_link' => $show_result1->case_link, 'caseid' => $show_result1->caseid,
            'choix_campagne' => $show_result1->choix_campagne, 'closed' => $show_result1->closed,
            'closed_by_username' => $show_result1->closed_by_username, 'date_enreg' => $show_result1->date_enreg,
            'date_formation' => $show_result1->date_formation,
            'last_modified_by_user_username' => $show_result1->last_modified_by_user_username,
            'last_modified_date' => $show_result1->last_modified_date, 'liste_formation' => $show_result1->liste_formation,
            'name' => $show_result1->name, 'nom_prenom_formation' => $show_result1->nom_prenom_formation,
            'number' => $show_result1->number, 'opened_by_username' => $show_result1->opened_by_username,
            'opened_date' => $show_result1->opened_date, 'owner_name' => $show_result1->owner_name,
            'producteurs_formes' => $show_result1->producteurs_formes
            ]);         
            
        }
        $this->info('Le Code a été executé');
    }
    
}
