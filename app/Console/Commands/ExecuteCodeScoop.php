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
use GuzzleHttp\Client;

class ExecuteCodeScoop extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "execute:scoop";
    
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
        
        //DB::table('scoops_s')->where('closed', '0')->update(['closed' => 'false']);
        //DB::table('scoops_s')->where('closed', '1')->update(['closed' => 'true']);
        //DB::table('scoops_s')->where('campagne_coton', '2021-2022')->delete();
        //DB::table('scoops_s')->where('campagne_coton', '2022-2023')->delete();
        //DB::table('scoops_s')->where('campagne_coton', '22-23')->delete();
        //DB::table('scoops_s')->where('campagne_coton', '---')->delete();
        DB::table('scoops_old')->where('closed', '0')->update(['closed' => 'false']);
        DB::table('scoops_old')->where('closed', '1')->update(['closed' => 'true']);
        
         $url = "https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/b6fb210348ef18e89bc9f779b00a24c4/feed";

        $client = new Client();

        do {
           $response = $client->request('GET', $url, [
               'auth' => ['fallou.g@illimitis.com', '12Sonatel']
            ]);

            $body = json_decode($response->getBody(), true);
            $data = $body['value'];
            
             foreach ($data as $item) {
             
                                DB::table('scoops_old')->insert($item);
                     
            }
            
           /* foreach ($data as $item) {
             
                                DB::table('scoops_s')->insert($item);
                     
            } */
            
            


            $url = $body['@odata.nextLink'] ?? null;
        } while ($url);
        
        
        
        //$gn =  https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/624f599e7c7ca6ace77ece7d18d88ecc/feed
        // last lien odata scoops https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/28ced5c7712c373ff3f135ff352f8687/feed
        //https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/749c9bfc2f0a52a7ee17825d5a3f173e/feed
    //  last  https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/b6fb210348ef18e89bc9f779b00a24c4/feed
         DB::table('scoops_checks')->delete();  
        $scoops = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/b6fb210348ef18e89bc9f779b00a24c4/feed?limit=50000');
        $quizzes = json_decode($scoops->body());
        
        //dd($quizzes);
       // $data = $quizzes['value'];
      //  dd($data);
        $quizzes_ara = array();
         foreach($quizzes as $quizze){
             array_push($quizzes_ara, $quizze);
         }
      // dd($quizzes['value']);
        //$i = 1;
        foreach($quizzes_ara[1] as $dataODATA){
            if($dataODATA->campagne_coton !== "22-23"){
            DB::table('scoops_checks')->insert(['caseid' => $dataODATA->caseid, 'closed' => $dataODATA->closed,'campagne_coton' => $dataODATA->campagne_coton,'annee_creation_scoop' => $dataODATA->annee_creation_scoop, 
            'nom_scoop' => $dataODATA->nom_scoop, 'code_scoop' => $dataODATA->code_scoop, 'zone' => $dataODATA->zone, 'region' => $dataODATA->region,
            'code_zone' => $dataODATA->code_zone, 'code_section' => $dataODATA->code_section, 'code_ca' => $dataODATA->code_ca, 'code_region' => $dataODATA->code_region,
            'section' => $dataODATA->section, 'province' => $dataODATA->province, 'village' => $dataODATA->village, 'owner_name' => $dataODATA->owner_name]);
                    
            } 
        }
        
        if(count($quizzes_ara[1]) >= 10000){
        $scoopsafters = Http::get('https://fallou.g@illimitis.com:12Sonatel@www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/b6fb210348ef18e89bc9f779b00a24c4/feed?after_id=10000&limit=10000&offset=10000');
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
            DB::table('scoops_checks')->insert(['caseid' => $dataODATAafter->caseid, 'closed' => $dataODATAafter->closed, 'campagne_coton' => $dataODATAafter->campagne_coton, 'annee_creation_scoop' => $dataODATAafter->annee_creation_scoop, 
            'nom_scoop' => $dataODATAafter->nom_scoop, 'code_scoop' => $dataODATAafter->code_scoop, 'zone' => $dataODATAafter->zone, 'region' => $dataODATAafter->region,
            'code_zone' => $dataODATAafter->code_zone, 'code_section' => $dataODATAafter->code_section, 'code_ca' => $dataODATAafter->code_ca, 'code_region' => $dataODATAafter->code_region,
            'section' => $dataODATAafter->section, 'province' => $dataODATAafter->province, 'village' => $dataODATAafter->village, 'owner_name' => $dataODATA->owner_name]);
           }        
            
        }
        }
        
          $check1 = DB::table('scoops_checks')->pluck('caseid')->toArray();
        
        $check2 = DB::table('scoops')->pluck('caseid')->toArray(); 
        
        $results = array_diff($check1, $check2);
        
        $show_result1s = array();
        foreach($results as $result)
        {
            
            $checkA1s = DB::table('scoops_checks')->where('caseid', $result)->get();
            
            foreach($checkA1s as $checkA1)
            {  
                
                array_push($show_result1s, $checkA1);
            }
        }
        
        
         foreach($show_result1s as $show_result1){
           
              DB::table('scoops_checks')->insert(['caseid' => $show_result1->caseid, 'closed' => $show_result1->closed, 'campagne_coton' => $show_result1->campagne_coton, 'annee_creation_scoop' => $show_result1->annee_creation_scoop, 
            'nom_scoop' => $show_result1->nom_scoop, 'code_scoop' => $show_result1->code_scoop, 'zone' => $show_result1->zone, 'region' => $show_result1->region,
            'code_zone' => $show_result1->code_zone, 'code_section' => $show_result1->code_section, 'code_ca' => $show_result1->code_ca, 'code_region' => $show_result1->code_region,
            'section' => $show_result1->section, 'province' => $show_result1->province, 'village' => $show_result1->village, 'owner_name' => $show_result1->owner_name]);
              
            
        }
        $this->info('Le Code a été executé');
    }
    
}
