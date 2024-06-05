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
use App\Mail\NewDemande;

class Helpdesk extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "help:desk";
    
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
        
        //$gn = https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/7c6671e48121763a92c81c1a14071614/feed
        // Last lien helpdesk https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/653765b7e24b4eb38f59f4069f1fb55e/feed
        DB::table('helpdesks_checks')->delete();
        $helpdesks = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/653765b7e24b4eb38f59f4069f1fb55e/feed?limit=50000');
        $quizzes = json_decode($helpdesks->body());
        
        // dd($quizzes);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
       //dd($quizzes_ara[1]);
        //$i = 1;
       
        foreach($quizzes_ara[1] as $dataODATA){
           
            DB::table('helpdesks_checks')->insert(['caseid' => $dataODATA->caseid, 'closed' => $dataODATA->closed, 'code_zone' => $dataODATA->code_zone, 
            'date_requete' => $dataODATA->date_requete, 'expliquer_en_dtails_le_problme_rencontr__fra' => $dataODATA->expliquer_en_dtails_le_problme_rencontr__fra, 
            'formulaire_concerne' => $dataODATA->formulaire_concerne, 'last_modified_by_user_username' => $dataODATA->last_modified_by_user_username,
            'last_modified_date' => $dataODATA->last_modified_date, 'module_concern__fra' => $dataODATA->module_concern__fra, 'name' => $dataODATA->name, 'number' => $dataODATA->number,
            'opened_by_username' => $dataODATA->opened_by_username, 'opened_date' => $dataODATA->opened_date, 'owner_name' => $dataODATA->owner_name,
             'periode_probleme' => $dataODATA->periode_probleme, 'statut_de_la_requte__fra' => $dataODATA->statut_de_la_requte__fra, 'statut_label' => $dataODATA->statut_label,
             'statut_requete' => $dataODATA->statut_requete, 'type_de_bug' => $dataODATA->type_de_bug, 'user_first_name' => $dataODATA->user_first_name,
             'user_last_name' => $dataODATA->user_last_name, 'user_phone_number' => $dataODATA->user_phone_number, 'utilisateur_concerne' => $dataODATA->utilisateur_concerne]);
                   
                    
            
        }
        
        $check1 = DB::table('helpdesks_checks')->pluck('caseid')->toArray();
        
        $check2 = DB::table('helpdesks')->pluck('caseid')->toArray(); 
        
        $results = array_diff($check1, $check2);
        
        $show_result1s = array();
        foreach($results as $result)
        {
            
            $checkA1s = DB::table('helpdesks_checks')->where('caseid', $result)->get();
            
            foreach($checkA1s as $checkA1)
            {  
                
                array_push($show_result1s, $checkA1);
            }
        }
        
        
         foreach($show_result1s as $show_result1){
           
            DB::table('helpdesks')->insert(['caseid' => $show_result1->caseid, 'closed' => $show_result1->closed, 'code_zone' => $show_result1->code_zone, 
            'date_requete' => $show_result1->date_requete, 'expliquer_en_dtails_le_problme_rencontr__fra' => $show_result1->expliquer_en_dtails_le_problme_rencontr__fra, 
            'formulaire_concerne' => $show_result1->formulaire_concerne, 'last_modified_by_user_username' => $show_result1->last_modified_by_user_username,
            'last_modified_date' => $show_result1->last_modified_date, 'module_concern__fra' => $show_result1->module_concern__fra, 'name' => $show_result1->name, 'number' => $show_result1->number,
            'opened_by_username' => $show_result1->opened_by_username, 'opened_date' => $show_result1->opened_date, 'owner_name' => $show_result1->owner_name,
             'periode_probleme' => $show_result1->periode_probleme, 'statut_de_la_requte__fra' => $show_result1->statut_de_la_requte__fra, 'statut_label' => $show_result1->statut_label,
             'statut_requete' => $show_result1->statut_requete, 'type_de_bug' => $show_result1->type_de_bug, 'user_first_name' => $show_result1->user_first_name,
             'user_last_name' => $show_result1->user_last_name, 'user_phone_number' => $show_result1->user_phone_number, 'utilisateur_concerne' => $show_result1->utilisateur_concerne]);
                   
            Mail::to('fallou.g@illimitis.com')->send(new NewDemande()); 
            Mail::to('anthyme.k@illimitis.com')->send(new NewDemande()); 
            Mail::to('josue.t@illimitis.com')->send(new NewDemande()); 
            Mail::to('axel.n@illimitis.com')->send(new NewDemande()); 
        }
          
        // dd($show_result1s);
       
        $this->info('Le Code a été executé');
    }
    
}
