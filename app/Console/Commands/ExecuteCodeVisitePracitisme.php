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

class ExecuteCodeVisitePracitisme extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "execute:pracitisme";
    
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
        // Last lien odata visite https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/5095f3dbc1e947bfaf1c49892ab36028/feed

         DB::table('visite_paracitismes_checks')->delete();  
        $visite_paracitismes = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/5095f3dbc1e947bfaf1c49892ab36028/feed?limit=50000');
        $quizzes = json_decode($visite_paracitismes->body());
        
        // dd($quizzes);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
        //dd($quizzes_ara[1]);
        //$i = 1;
        foreach($quizzes_ara[1] as $dataODATA){
           if($dataODATA->campagne_coton !== "22-23"){
            DB::table('visite_paracitismes_checks')->insert(['number' => $dataODATA->number, 'caseid' => $dataODATA->caseid, 'closed' => $dataODATA->closed, 
            'nom_prenom_producteur' => $dataODATA->nom_prenom_producteur, 'superficie_declaree' => $dataODATA->superficie_declaree, 'superficie_perdue' => $dataODATA->superficie_perdue, 'name' => $dataODATA->name , 'choix_campagne' => $dataODATA->choix_campagne,
            'date_dernier_traitement' => $dataODATA->date_dernier_traitement, 'num_parcelle' => $dataODATA->num_parcelle, 'owner_name' => $dataODATA->owner_name]);
           }        
           
        }
        if(count($quizzes_ara[1]) >= 10000){
        $visite_paracitismesafters = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/5095f3dbc1e947bfaf1c49892ab36028/feed?after_id=10000&limit=10000&offset=10000');
        $quizzesafters = json_decode($visite_paracitismesafters->body());
        
        // dd($quizzes);
        $quizzes_araafters = array();
         foreach($quizzesafters as $quizzeafter){
             array_push($quizzes_araafters, $quizzeafter);
         }
        //dd($quizzes_ara[1]);
        //$i = 1;
        foreach($quizzes_araafters[1] as $dataODATAafter){
           if($dataODATAafter->campagne_coton !== "22-23"){
            DB::table('visite_paracitismes_checks')->insert(['number' => $dataODATAafter->number, 'caseid' => $dataODATAafter->caseid, 'closed' => $dataODATAafter->closed, 
            'nom_prenom_producteur' => $dataODATAafter->nom_prenom_producteur, 'superficie_declaree' => $dataODATAafter->superficie_declaree, 'superficie_perdue' => $dataODATAafter->superficie_perdue, 'name' => $dataODATAafter->name , 'choix_campagne' => $dataODATAafter->choix_campagne,
            'date_dernier_traitement' => $dataODATAafter->date_dernier_traitement, 'num_parcelle' => $dataODATAafter->num_parcelle, 'owner_name' => $dataODATAafter->owner_name]);
           }        
           
        }
        }
        
        
          $check1 = DB::table('visite_paracitismes_checks')->pluck('caseid')->toArray();
        
        $check2 = DB::table('visite_paracitismes')->pluck('caseid')->toArray(); 
        
        $results = array_diff($check1, $check2);
        
        $show_result1s = array();
        foreach($results as $result)
        {
            
            $checkA1s = DB::table('visite_paracitismes_checks')->where('caseid', $result)->get();
            
            foreach($checkA1s as $checkA1)
            {  
                
                array_push($show_result1s, $checkA1);
            }
        }
        
        
         foreach($show_result1s as $show_result1){
             
            DB::table('visite_paracitismes')->insert(['number' => $show_result1->number, 
            'caseid' => $show_result1->caseid, 'closed' => $show_result1->closed, 
            'nom_prenom_producteur' => $show_result1->nom_prenom_producteur, 
            'superficie_declaree' => $show_result1->superficie_declaree, 'superficie_perdue' => $show_result1->superficie_perdue, 
            'name' => $show_result1->name , 'choix_campagne' => $show_result1->choix_campagne,
            'date_dernier_traitement' => $show_result1->date_dernier_traitement, 
            'num_parcelle' => $show_result1->num_parcelle, 'owner_name' => $show_result1->owner_name]);
                          
            
        }
        $this->info('Le Code a été executé');
    }
    
}
