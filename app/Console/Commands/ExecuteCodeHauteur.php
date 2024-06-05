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

class ExecuteCodeHauteur extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "execute:hauteur";
    
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
        
        // last lien hauteur https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/3279d1b046eb77715da3bae0c5964231/feed


         DB::table('hauteurs_checks')->delete();  
        $scoops = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/3279d1b046eb77715da3bae0c5964231/feed?limit=50000');
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
            DB::table('hauteurs_checks')->insert(['caseid' => $dataODATA->caseid, 'case_link' => $dataODATA->case_link, 'closed' => $dataODATA->closed, 'closed_by_username' => $dataODATA->closed_by_username, 
            'closed_date' => $dataODATA->closed_date, 'decade' => $dataODATA->decade, 'hauteur_deau' => $dataODATA->hauteur_deau, 'last_modified_by_user_username' => $dataODATA->last_modified_by_user_username,
            'last_modified_date' => $dataODATA->last_modified_date, 'mois' => $dataODATA->mois, 'name' => $dataODATA->name, 'number' => $dataODATA->number,
            'opened_by_username' => $dataODATA->opened_by_username, 'opened_date' => $dataODATA->opened_date, 'owner_name' => $dataODATA->owner_name, 'campagne_coton' => $dataODATA->campagne_coton]);
                    
            }
        }
        
        if(count($quizzes_ara[1]) >= 10000){
        $scoopsafters = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/3279d1b046eb77715da3bae0c5964231/feed?after_id=10000&limit=10000&offset=10000');
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
             DB::table('hauteurs_checks')->insert(['caseid' => $dataODATAafter->caseid, 'case_link' => $dataODATAafter->case_link, 'closed' => $dataODATAafter->closed, 'closed_by_username' => $dataODATAafter->closed_by_username, 
            'closed_date' => $dataODATAafter->closed_date, 'decade' => $dataODATAafter->decade, 'hauteur_deau' => $dataODATAafter->hauteur_deau, 'last_modified_by_user_username' => $dataODATAafter->last_modified_by_user_username,
            'last_modified_date' => $dataODATAafter->last_modified_date, 'mois' => $dataODATAafter->mois, 'name' => $dataODATAafter->name, 'number' => $dataODATAafter->number,
            'opened_by_username' => $dataODATAafter->opened_by_username, 'opened_date' => $dataODATAafter->opened_date, 'owner_name' => $dataODATAafter->owner_name, 'campagne_coton' => $dataODATAafter->campagne_coton]);
                     
             } 
        }
        }
        
        $check1 = DB::table('hauteurs_checks')->pluck('caseid')->toArray();
        
        $check2 = DB::table('hauteurs')->pluck('caseid')->toArray(); 
        
        $results = array_diff($check1, $check2);
        
        $show_result1s = array();
        foreach($results as $result)
        {
            
            $checkA1s = DB::table('hauteurs_checks')->where('caseid', $result)->get();
            
            foreach($checkA1s as $checkA1)
            {  
                
                array_push($show_result1s, $checkA1);
            }
        }
        
        
         foreach($show_result1s as $show_result1){
           
             DB::table('hauteurs')->insert(['caseid' => $show_result1->caseid, 'case_link' => $show_result1->case_link, 
             'closed' => $show_result1->closed, 'closed_by_username' => $show_result1->closed_by_username, 
            'closed_date' => $show_result1->closed_date, 'decade' => $show_result1->decade,
            'hauteur_deau' => $show_result1->hauteur_deau, 'last_modified_by_user_username' => $show_result1->last_modified_by_user_username,
            'last_modified_date' => $show_result1->last_modified_date, 'mois' => $show_result1->mois, 
            'name' => $show_result1->name, 'number' => $show_result1->number,
            'opened_by_username' => $show_result1->opened_by_username, 'opened_date' => $show_result1->opened_date,
            'owner_name' => $show_result1->owner_name, 'campagne_coton' => $show_result1->campagne_coton]);
    
            
        }
        $this->info('Le Code a été executé');
    }
    
}
