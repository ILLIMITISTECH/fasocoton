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
use App\Parcelles_check;

use Illuminate\Support\Facades\Http;

use App\Notifications\EscalationAction;
use App\Notifications\EscalationActionResponsable;
use App\Notifications\AlerteEscalation;
use Notification;
use GuzzleHttp\Client;

class ExecuteCodeParcelle extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "execute:parcelle";
    
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
        
        DB::table('parcellesv')->where('closed', '0')->update(['closed' => 'false']);
        DB::table('parcellesv')->where('closed', '1')->update(['closed' => 'true']);
       // DB::table('parcellesv')->where('campagne_coton', '2021-2022')->delete();
       // DB::table('parcellesv')->where('campagne_coton', '2022-2023')->delete();
       // DB::table('parcellesv')->where('campagne_coton', '22-23')->delete();
       // DB::table('parcellesv')->where('campagne_coton', '---')->delete();
        //$gn =  https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/624f599e7c7ca6ace77ece7d18d88ecc/feed
        //https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/7549b11e2ca6ab584783eeccbfa32c0e/feed last
        //$parcelles = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/264bc7ac535c0c3eace6f26e7627c3ae/feed'); ancien
        // Last lien odata parcelle https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/3279d1b046eb77715da3bae0c589e893/feed
        
        
         $url = "https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/3279d1b046eb77715da3bae0c589e893/feed";

        $client = new Client();

        do {
           $response = $client->request('GET', $url, [
               'auth' => ['fallou.g@illimitis.com', '12Sonatel']
            ]);

            $body = json_decode($response->getBody(), true);
            $data = $body['value'];
            
            foreach ($data as $item) {
             
                                DB::table('parcellesv')->insert($item);
                     
            }


            $url = $body['@odata.nextLink'] ?? null;
        } while ($url);
        
        
        
        
         
         DB::table('parcelles_checks')->delete();  
            // Définir la taille de pagination
            
      /*  $parcelles = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/3279d1b046eb77715da3bae0c589e893/feed?limit=50000');
        $quizzes = json_decode($parcelles->body());
        
        
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
       dd($quizzes_ara);
        foreach($quizzes_ara[2] as $dataODATA){
           
            DB::table('parcelles_checkss')->insert(['number' => $dataODATA->number, 'caseid' => $dataODATA->caseid, 'code_scoop' => $dataODATA->code_scoop, 'closed' => $dataODATA->closed, 'mesure_saisie' => $dataODATA->mesure_saisie, 
            'nom_prenom_producteur' => $dataODATA->nom_prenom_producteur, 'compteur_parcelle' => $dataODATA->compteur_parcelle, 'nature_sol' => $dataODATA->nature_sol, 'campagne' => $dataODATA->campagne, 'campagne_coton' => $dataODATA->campagne_coton,
            'precedent_cultural' => $dataODATA->precedent_cultural, 'supercifie_declaree' => $dataODATA->supercifie_declaree, 'superficie_mesuree_ha' => $dataODATA->superficie_mesuree_ha, 'position_gps_champ' => $dataODATA->position_gps_champ, 'owner_name' => $dataODATA->owner_name]);  
         
        }
        dd($quizzes_ara); 
            
        DB::beginTransaction();

        try {
            $pageSize = 100;
            $offset = 0;
        
            do {
                $response = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/3279d1b046eb77715da3bae0c589e893/feed', [
                    '$top' => $pageSize,
                    '$skip' => $offset,
                ]);
        
                $data = json_decode($response->body());
        
                $data_ara = array();
                foreach ($data as $quizz_data) {
                    array_push($data_ara, $quizz_data);
                }
        
                foreach ($data_ara[2] as $item) {
                    $existingParcelle = Parcelles_check::where('number', $item->number)->first();
        
                    if (!$existingParcelle) {
                        $parcelle = new Parcelles_check;
                        $parcelle->number = $item->number;
                        $parcelle->caseid = $item->caseid;
                        $parcelle->code_scoop = $item->code_scoop;
                        $parcelle->closed = $item->closed;
                        $parcelle->mesure_saisie = $item->mesure_saisie;
                        $parcelle->nom_prenom_producteur = $item->nom_prenom_producteur;
                        $parcelle->compteur_parcelle = $item->compteur_parcelle;
                        $parcelle->nature_sol = $item->nature_sol;
                        $parcelle->campagne = $item->campagne;
                        $parcelle->campagne_coton = $item->campagne_coton;
                        $parcelle->precedent_cultural = $item->precedent_cultural;
                        $parcelle->supercifie_declaree = $item->supercifie_declaree;
                        $parcelle->superficie_mesuree_ha = $item->superficie_mesuree_ha;
                        $parcelle->position_gps_champ = $item->position_gps_champ;
                        $parcelle->owner_name = $item->owner_name;
                        $parcelle->save();
                    }
                }
        
                $offset += $pageSize;
        
            } while (count($data_ara[2]) === $pageSize);
        
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

           
            echo 'okay';  */

        $parcelles = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/3279d1b046eb77715da3bae0c589e893/feed?limit=50000');
        $quizzes = json_decode($parcelles->body());
        
        
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
       
        //dd($quizzes_ara);
        foreach($quizzes_ara[2] as $dataODATA){
          // if($dataODATA->campagne_coton !== "22-23"){
            DB::table('parcelles_checks')->insert(['number' => $dataODATA->number, 'caseid' => $dataODATA->caseid, 'code_scoop' => $dataODATA->code_scoop, 'closed' => $dataODATA->closed, 'mesure_saisie' => $dataODATA->mesure_saisie, 'section' => $dataODATA->section, 'zone' => $dataODATA->zone, 
            'nom_prenom_producteur' => $dataODATA->nom_prenom_producteur, 'compteur_parcelle' => $dataODATA->compteur_parcelle, 'nature_sol' => $dataODATA->nature_sol, 'campagne' => $dataODATA->campagne, 'campagne_coton' => $dataODATA->campagne_coton,
            'precedent_cultural' => $dataODATA->precedent_cultural, 'supercifie_declaree' => $dataODATA->supercifie_declaree, 'superficie_mesuree_ha' => $dataODATA->superficie_mesuree_ha, 'position_gps_champ' => $dataODATA->position_gps_champ, 'owner_name' => $dataODATA->owner_name]);  
           //}
        }
        
        $parcellesafters = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/3279d1b046eb77715da3bae0c589e893/feed?after_id=10000&limit=50000&offset=10000');
        $quizzesafters = json_decode($parcellesafters->body());
        
       
        $quizzes_araafters = array();
         foreach($quizzesafters as $quizzeafter){
             array_push($quizzes_araafters, $quizzeafter);
         }
        
        foreach($quizzes_araafters[1] as $dataODATAafter){
          // if($dataODATAafter->campagne_coton !== "22-23"){
            DB::table('parcelles_checks')->insert(['number' => $dataODATAafter->number, 'caseid' => $dataODATAafter->caseid, 'code_scoop' => $dataODATAafter->code_scoop, 'closed' => $dataODATAafter->closed, 'mesure_saisie' => $dataODATAafter->mesure_saisie, 'section' => $dataODATAafter->section, 'zone' => $dataODATAafter->zone,
            'nom_prenom_producteur' => $dataODATAafter->nom_prenom_producteur, 'compteur_parcelle' => $dataODATAafter->compteur_parcelle, 'nature_sol' => $dataODATAafter->nature_sol, 'campagne' => $dataODATAafter->campagne, 'campagne_coton' => $dataODATAafter->campagne_coton,
            'precedent_cultural' => $dataODATAafter->precedent_cultural, 'supercifie_declaree' => $dataODATAafter->supercifie_declaree, 'superficie_mesuree_ha' => $dataODATAafter->superficie_mesuree_ha, 'position_gps_champ' => $dataODATAafter->position_gps_champ, 'owner_name' => $dataODATAafter->owner_name]);  
          // }
        } 
        
        $check1 = DB::table('parcelles_checks')->pluck('caseid')->toArray();
        
        $check2 = DB::table('parcelles')->pluck('caseid')->toArray(); 
        
        $results = array_diff($check1, $check2);
        
        $show_result1s = array();
        foreach($results as $result)
        {
            
            $checkA1s = DB::table('parcelles_checks')->where('caseid', $result)->get();
            
            foreach($checkA1s as $checkA1)
            {  
                
                array_push($show_result1s, $checkA1);
            }
        }
        
        
         foreach($show_result1s as $show_result1){
           
             DB::table('parcelles_checks')->insert(['number' => $show_result1->number,
             'caseid' => $show_result1->caseid, 'closed' => $show_result1->closed, 
             'mesure_saisie' => $show_result1->mesure_saisie, 'section' => $show_result1->section, 'zone' => $show_result1->zone,
            'nom_prenom_producteur' => $show_result1->nom_prenom_producteur, 
            'compteur_parcelle' => $show_result1->compteur_parcelle, 'nature_sol' => $show_result1->nature_sol,
            'campagne' => $show_result1->campagne, 'campagne_coton' => $show_result1->campagne_coton, 'code_scoop' => $show_result1->code_scoop,
            'precedent_cultural' => $show_result1->precedent_cultural, 'supercifie_declaree' => $show_result1->supercifie_declaree, 
            'superficie_mesuree_ha' => $show_result1->superficie_mesuree_ha, 'position_gps_champ' => $show_result1->position_gps_champ,
            'owner_name' => $show_result1->owner_name]);  
   
            
        }
        DB::table('parcelles')->where('campagne_coton', '22-23')->delete();
        $this->info('Le Code a été executé');
    }
    
}
