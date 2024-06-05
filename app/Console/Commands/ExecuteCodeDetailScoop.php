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

class ExecuteCodeDetailScoop extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "execute:detail_scoop";
    
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
        
        // last lien Details scoops https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/597c47f36530e0130d0f0952adb94231/feed

         DB::table('detail_scoops_checks')->delete();  
        $scoops = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/597c47f36530e0130d0f0952adb94231/feed?limit=50000');
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
            DB::table('detail_scoops_checks')->insert(['campagne_coton' => $dataODATA->campagne_coton, 'case_link' => $dataODATA->case_link, 
            'caseid' => $dataODATA->caseid, 'closed' => $dataODATA->closed, 
            'closed_by_username' => $dataODATA->closed_by_username, 'closed_date' => $dataODATA->closed_date,
            'code_scoop' => $dataODATA->code_scoop, 'code_section' => $dataODATA->code_section,
            'code_zone' => $dataODATA->code_zone,
            'last_modified_by_user_username' => $dataODATA->last_modified_by_user_username, 'last_modified_date' => $dataODATA->last_modified_date,
            'name' => $dataODATA->name, 'nom_scoop' => $dataODATA->nom_scoop,
            'nombre_bascules_privees' => $dataODATA->nombre_bascules_privees, 'nombre_de_parcelles_infestes_par_des_alises' => $dataODATA->nombre_de_parcelles_infestes_par_des_alises,
            'nombre_de_parcelles_infestes_par_des_anomis_flava' => $dataODATA->nombre_de_parcelles_infestes_par_des_anomis_flava,
            'nombre_de_parcelles_infestes_par_des_bemisia' => $dataODATA->nombre_de_parcelles_infestes_par_des_bemisia,
            'nombre_de_parcelles_infestes_par_des_bemisia_nymphes' => $dataODATA->nombre_de_parcelles_infestes_par_des_bemisia_nymphes, 'nombre_de_parcelles_infestes_par_des_dysdercus' => $dataODATA->nombre_de_parcelles_infestes_par_des_dysdercus,
            'nombre_de_parcelles_infestes_par_des_haritalodes' => $dataODATA->nombre_de_parcelles_infestes_par_des_haritalodes, 'nombre_de_parcelles_infestes_par_des_jassides' => $dataODATA->nombre_de_parcelles_infestes_par_des_jassides,
            'nombre_de_parcelles_infestes_par_des_larves_diparopsis' => $dataODATA->nombre_de_parcelles_infestes_par_des_larves_diparopsis, 'nombre_de_parcelles_infestes_par_des_larves_earias' => $dataODATA->nombre_de_parcelles_infestes_par_des_larves_earias,
            'nombre_de_parcelles_infestes_par_des_larves_helicoverpa' => $dataODATA->nombre_de_parcelles_infestes_par_des_larves_helicoverpa, 'nombre_de_parcelles_infestes_par_des_oeufs_de_carpophages' => $dataODATA->nombre_de_parcelles_infestes_par_des_oeufs_de_carpophages,
            'nombre_de_parcelles_infestes_par_des_pucerons' => $dataODATA->nombre_de_parcelles_infestes_par_des_pucerons, 
            'nombre_de_parcelles_infestes_par_des_pucerons_adultes' => $dataODATA->nombre_de_parcelles_infestes_par_des_pucerons_adultes, 'nombre_de_parcelles_normales_suivies' => $dataODATA->nombre_de_parcelles_normales_suivies,
            'nombre_de_parcelles_prcoces_suivies' => $dataODATA->nombre_de_parcelles_prcoces_suivies, 'nombre_de_parcelles_tardives_suivies' => $dataODATA->nombre_de_parcelles_tardives_suivies,
            'nombre_magasins_disponibles' => $dataODATA->nombre_magasins_disponibles, 'nombre_total_de_parcelles_suivies' => $dataODATA->nombre_total_de_parcelles_suivies, 
            'number' => $dataODATA->number, 'opened_by_username' => $dataODATA->opened_by_username,
            'opened_date' => $dataODATA->opened_date, 'owner_name' => $dataODATA->owner_name,
            'pourcentage_1er_sarclage' => $dataODATA->pourcentage_1er_sarclage, 'pourcentage_1er_traitement' => $dataODATA->pourcentage_1er_traitement,
            'pourcentage_2e_sarclage' => $dataODATA->pourcentage_2e_sarclage, 'pourcentage_2e_traitement' => $dataODATA->pourcentage_2e_traitement,
            'pourcentage_3e_sarclage' => $dataODATA->pourcentage_3e_sarclage, 'pourcentage_3e_traitement' => $dataODATA->pourcentage_3e_traitement, 
            'pourcentage_4e_traitement' => $dataODATA->pourcentage_4e_traitement, 'pourcentage_5e_traitement' => $dataODATA->pourcentage_5e_traitement,
            'pourcentage_6e_traitement' => $dataODATA->pourcentage_6e_traitement, 'pourcentage_7e_traitement' => $dataODATA->pourcentage_7e_traitement,
            'pourcentage_9e_traitement' => $dataODATA->pourcentage_9e_traitement, 'pourcentage_buttage' => $dataODATA->pourcentage_buttage,
            'pourcentage_herbicidage_fra' => $dataODATA->pourcentage_herbicidage_fra, 'pourcentage_npk' => $dataODATA->pourcentage_npk,
            'pourcentage_npk_uree' => $dataODATA->pourcentage_npk_uree, 'pourcentage_semis_fra' => $dataODATA->pourcentage_semis_fra, 
            'pourcentage_stade_capsulaire' => $dataODATA->pourcentage_stade_capsulaire, 'pourcentage_stade_deshiscence' => $dataODATA->pourcentage_stade_deshiscence,
            'pourcentage_stade_floraison' => $dataODATA->pourcentage_stade_floraison, 'pourcentage_stade_levee' => $dataODATA->pourcentage_stade_levee,
            'pourcentage_stade_maturation' => $dataODATA->pourcentage_stade_maturation, 'pourcentage_stade_plantule' => $dataODATA->pourcentage_stade_plantule,
            'pourcentage_stade_prefloraison' => $dataODATA->pourcentage_stade_prefloraison, 'pourcentage_uree' => $dataODATA->pourcentage_uree
            ]);
           }        
            
        }
        
        if(count($quizzes_ara[1]) >= 10000){
        $scoopsafters = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/597c47f36530e0130d0f0952adb94231/feed?after_id=10000&limit=10000&offset=10000');
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
           DB::table('detail_scoops_checks')->insert(['campagne_coton' => $dataODATAafter->campagne_coton, 'case_link' => $dataODATAafter->case_link, 
            'caseid' => $dataODATAafter->caseid, 'closed' => $dataODATAafter->closed, 
            'closed_by_username' => $dataODATAafter->closed_by_username, 'closed_date' => $dataODATAafter->closed_date,
            'code_scoop' => $dataODATAafter->code_scoop, 'code_section' => $dataODATAafter->code_section,
            'code_zone' => $dataODATAafter->code_zone, 
            'last_modified_by_user_username' => $dataODATAafter->last_modified_by_user_username, 'last_modified_date' => $dataODATAafter->last_modified_date,
            'name' => $dataODATAafter->name, 'nom_scoop' => $dataODATAafter->nom_scoop,
            'nombre_bascules_privees' => $dataODATAafter->nombre_bascules_privees, 'nombre_de_parcelles_infestes_par_des_alises' => $dataODATAafter->nombre_de_parcelles_infestes_par_des_alises,
            'nombre_de_parcelles_infestes_par_des_anomis_flava' => $dataODATAafter->nombre_de_parcelles_infestes_par_des_anomis_flava,
            'nombre_de_parcelles_infestes_par_des_bemisia' => $dataODATAafter->nombre_de_parcelles_infestes_par_des_bemisia,
            'nombre_de_parcelles_infestes_par_des_bemisia_nymphes' => $dataODATAafter->nombre_de_parcelles_infestes_par_des_bemisia_nymphes,
            'nombre_de_parcelles_infestes_par_des_dysdercus' => $dataODATAafter->nombre_de_parcelles_infestes_par_des_dysdercus,
            'nombre_de_parcelles_infestes_par_des_haritalodes' => $dataODATAafter->nombre_de_parcelles_infestes_par_des_haritalodes,
            'nombre_de_parcelles_infestes_par_des_jassides' => $dataODATAafter->nombre_de_parcelles_infestes_par_des_jassides,
            'nombre_de_parcelles_infestes_par_des_larves_diparopsis' => $dataODATAafter->nombre_de_parcelles_infestes_par_des_larves_diparopsis, 
            'nombre_de_parcelles_infestes_par_des_larves_earias' => $dataODATAafter->nombre_de_parcelles_infestes_par_des_larves_earias,
            'nombre_de_parcelles_infestes_par_des_larves_helicoverpa' => $dataODATAafter->nombre_de_parcelles_infestes_par_des_larves_helicoverpa, 
            'nombre_de_parcelles_infestes_par_des_oeufs_de_carpophages' => $dataODATAafter->nombre_de_parcelles_infestes_par_des_oeufs_de_carpophages,
            'nombre_de_parcelles_infestes_par_des_pucerons' => $dataODATAafter->nombre_de_parcelles_infestes_par_des_pucerons, 
            'nombre_de_parcelles_infestes_par_des_pucerons_adultes' => $dataODATAafter->nombre_de_parcelles_infestes_par_des_pucerons_adultes, 
            'nombre_de_parcelles_normales_suivies' => $dataODATAafter->nombre_de_parcelles_normales_suivies,
            'nombre_de_parcelles_prcoces_suivies' => $dataODATAafter->nombre_de_parcelles_prcoces_suivies, 
            'nombre_de_parcelles_tardives_suivies' => $dataODATAafter->nombre_de_parcelles_tardives_suivies,
            'nombre_magasins_disponibles' => $dataODATAafter->nombre_magasins_disponibles,
            'nombre_total_de_parcelles_suivies' => $dataODATAafter->nombre_total_de_parcelles_suivies, 
            'number' => $dataODATAafter->number, 'opened_by_username' => $dataODATAafter->opened_by_username,
            'opened_date' => $dataODATAafter->opened_date, 'owner_name' => $dataODATAafter->owner_name,
            'pourcentage_1er_sarclage' => $dataODATAafter->pourcentage_1er_sarclage, 'pourcentage_1er_traitement' => $dataODATAafter->pourcentage_1er_traitement,
            'pourcentage_2e_sarclage' => $dataODATAafter->pourcentage_2e_sarclage, 'pourcentage_2e_traitement' => $dataODATAafter->pourcentage_2e_traitement,
            'pourcentage_3e_sarclage' => $dataODATAafter->pourcentage_3e_sarclage, 'pourcentage_3e_traitement' => $dataODATAafter->pourcentage_3e_traitement, 
            'pourcentage_4e_traitement' => $dataODATAafter->pourcentage_4e_traitement, 'pourcentage_5e_traitement' => $dataODATAafter->pourcentage_5e_traitement,
            'pourcentage_6e_traitement' => $dataODATAafter->pourcentage_6e_traitement, 'pourcentage_7e_traitement' => $dataODATAafter->pourcentage_7e_traitement,
            'pourcentage_9e_traitement' => $dataODATAafter->pourcentage_9e_traitement, 'pourcentage_buttage' => $dataODATAafter->pourcentage_buttage,
            'pourcentage_herbicidage_fra' => $dataODATAafter->pourcentage_herbicidage_fra, 'pourcentage_npk' => $dataODATAafter->pourcentage_npk,
            'pourcentage_npk_uree' => $dataODATAafter->pourcentage_npk_uree, 'pourcentage_semis_fra' => $dataODATAafter->pourcentage_semis_fra, 
            'pourcentage_stade_capsulaire' => $dataODATAafter->pourcentage_stade_capsulaire, 'pourcentage_stade_deshiscence' => $dataODATAafter->pourcentage_stade_deshiscence,
            'pourcentage_stade_floraison' => $dataODATAafter->pourcentage_stade_floraison, 'pourcentage_stade_levee' => $dataODATAafter->pourcentage_stade_levee,
            'pourcentage_stade_maturation' => $dataODATAafter->pourcentage_stade_maturation, 'pourcentage_stade_plantule' => $dataODATAafter->pourcentage_stade_plantule,
            'pourcentage_stade_prefloraison' => $dataODATAafter->pourcentage_stade_prefloraison, 'pourcentage_uree' => $dataODATAafter->pourcentage_uree
            ]);    
           }
        }
        }
        
        $check1 = DB::table('detail_scoops_checks')->pluck('caseid')->toArray();
        
        $check2 = DB::table('detail_scoops')->pluck('caseid')->toArray(); 
        
        $results = array_diff($check1, $check2);
        
        $show_result1s = array();
        foreach($results as $result)
        {
            
            $checkA1s = DB::table('detail_scoops_checks')->where('caseid', $result)->get();
            
            foreach($checkA1s as $checkA1)
            {  
                
                array_push($show_result1s, $checkA1);
            }
        }
        
        
         foreach($show_result1s as $show_result1){
           
             DB::table('detail_scoops')->insert(['campagne_coton' => $show_result1->campagne_coton, 'case_link' => $show_result1->case_link, 
            'caseid' => $show_result1->caseid, 'closed' => $show_result1->closed, 
            'closed_by_username' => $show_result1->closed_by_username, 'closed_date' => $show_result1->closed_date,
            'code_scoop' => $show_result1->code_scoop, 'code_section' => $show_result1->code_section,
            'code_zone' => $show_result1->code_zone, 
            'last_modified_by_user_username' => $show_result1->last_modified_by_user_username, 'last_modified_date' => $show_result1->last_modified_date,
            'name' => $show_result1->name, 'nom_scoop' => $show_result1->nom_scoop,
            'nombre_bascules_privees' => $show_result1->nombre_bascules_privees, 'nombre_de_parcelles_infestes_par_des_alises' => $show_result1->nombre_de_parcelles_infestes_par_des_alises,
            'nombre_de_parcelles_infestes_par_des_anomis_flava' => $show_result1->nombre_de_parcelles_infestes_par_des_anomis_flava,
            'nombre_de_parcelles_infestes_par_des_bemisia' => $show_result1->nombre_de_parcelles_infestes_par_des_bemisia,
            'nombre_de_parcelles_infestes_par_des_bemisia_nymphes' => $show_result1->nombre_de_parcelles_infestes_par_des_bemisia_nymphes,
            'nombre_de_parcelles_infestes_par_des_dysdercus' => $show_result1->nombre_de_parcelles_infestes_par_des_dysdercus,
            'nombre_de_parcelles_infestes_par_des_haritalodes' => $show_result1->nombre_de_parcelles_infestes_par_des_haritalodes,
            'nombre_de_parcelles_infestes_par_des_jassides' => $show_result1->nombre_de_parcelles_infestes_par_des_jassides,
            'nombre_de_parcelles_infestes_par_des_larves_diparopsis' => $show_result1->nombre_de_parcelles_infestes_par_des_larves_diparopsis, 
            'nombre_de_parcelles_infestes_par_des_larves_earias' => $show_result1->nombre_de_parcelles_infestes_par_des_larves_earias,
            'nombre_de_parcelles_infestes_par_des_larves_helicoverpa' => $show_result1->nombre_de_parcelles_infestes_par_des_larves_helicoverpa, 
            'nombre_de_parcelles_infestes_par_des_oeufs_de_carpophages' => $show_result1->nombre_de_parcelles_infestes_par_des_oeufs_de_carpophages,
            'nombre_de_parcelles_infestes_par_des_pucerons' => $show_result1->nombre_de_parcelles_infestes_par_des_pucerons, 
            'nombre_de_parcelles_infestes_par_des_pucerons_adultes' => $show_result1->nombre_de_parcelles_infestes_par_des_pucerons_adultes, 
            'nombre_de_parcelles_normales_suivies' => $show_result1->nombre_de_parcelles_normales_suivies,
            'nombre_de_parcelles_prcoces_suivies' => $show_result1->nombre_de_parcelles_prcoces_suivies, 
            'nombre_de_parcelles_tardives_suivies' => $show_result1->nombre_de_parcelles_tardives_suivies,
            'nombre_magasins_disponibles' => $show_result1->nombre_magasins_disponibles,
            'nombre_total_de_parcelles_suivies' => $show_result1->nombre_total_de_parcelles_suivies, 
            'number' => $show_result1->number, 'opened_by_username' => $show_result1->opened_by_username,
            'opened_date' => $show_result1->opened_date, 'owner_name' => $show_result1->owner_name,
            'pourcentage_1er_sarclage' => $show_result1->pourcentage_1er_sarclage, 'pourcentage_1er_traitement' => $show_result1->pourcentage_1er_traitement,
            'pourcentage_2e_sarclage' => $show_result1->pourcentage_2e_sarclage, 'pourcentage_2e_traitement' => $show_result1->pourcentage_2e_traitement,
            'pourcentage_3e_sarclage' => $show_result1->pourcentage_3e_sarclage, 'pourcentage_3e_traitement' => $show_result1->pourcentage_3e_traitement, 
            'pourcentage_4e_traitement' => $show_result1->pourcentage_4e_traitement, 'pourcentage_5e_traitement' => $show_result1->pourcentage_5e_traitement,
            'pourcentage_6e_traitement' => $show_result1->pourcentage_6e_traitement, 'pourcentage_7e_traitement' => $show_result1->pourcentage_7e_traitement,
            'pourcentage_9e_traitement' => $show_result1->pourcentage_9e_traitement, 'pourcentage_buttage' => $show_result1->pourcentage_buttage,
            'pourcentage_herbicidage_fra' => $show_result1->pourcentage_herbicidage_fra, 'pourcentage_npk' => $show_result1->pourcentage_npk,
            'pourcentage_npk_uree' => $show_result1->pourcentage_npk_uree, 'pourcentage_semis_fra' => $show_result1->pourcentage_semis_fra, 
            'pourcentage_stade_capsulaire' => $show_result1->pourcentage_stade_capsulaire, 'pourcentage_stade_deshiscence' => $show_result1->pourcentage_stade_deshiscence,
            'pourcentage_stade_floraison' => $show_result1->pourcentage_stade_floraison, 'pourcentage_stade_levee' => $show_result1->pourcentage_stade_levee,
            'pourcentage_stade_maturation' => $show_result1->pourcentage_stade_maturation, 'pourcentage_stade_plantule' => $show_result1->pourcentage_stade_plantule,
            'pourcentage_stade_prefloraison' => $show_result1->pourcentage_stade_prefloraison, 'pourcentage_uree' => $show_result1->pourcentage_uree
            ]);    
            
        }
        $this->info('Le Code a été executé');
    }
    
}
