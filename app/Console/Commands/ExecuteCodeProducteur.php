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

class ExecuteCodeProducteur extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "execute:producteur";

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
        DB::table('producteurs_backsv')->where('closed', '0')->update(['closed' => 'false']);
        DB::table('producteurs_backsv')->where('closed', '1')->update(['closed' => 'true']);
        DB::table('producteurs_new')->where('closed', '0')->update(['closed' => 'false']);
        DB::table('producteurs_new')->where('closed', '1')->update(['closed' => 'true']);
        DB::table('producteurs_new')->where('campagne_coton', '22-23')->delete();
        DB::table('producteurs_new')->where('campagne_coton', '2022-2023')->delete();
        DB::table('producteurs_new')->where('campagne_coton', '2021-2022')->delete();
        DB::table('producteurs_new')->where('campagne_coton', '---')->delete();
        //DB::table('producteurs_checks')->delete();
      // DB::table('producteurs_backss')->delete();
       // https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/eb3a560916b8aa068ee1f945653c8359/feed
          $url = "https://www.commcarehq.org/a/faso-coton/api/v0.5/odata/cases/eb3a560916b8aa068ee1f945653c8359/feed";

        $client = new Client();

        do {
           $response = $client->request('GET', $url, [
               'auth' => ['fallou.g@illimitis.com', '12Sonatel']
            ]);

            $body = json_decode($response->getBody(), true);
            $data = $body['value'];
            
            foreach ($data as $item) {
             
                                DB::table('producteurs_backsv')->insert($item);
                     
            }
            
           /* foreach ($data as $item) {
             
                                DB::table('producteurs_new')->insert($item);
                     
            } */

            $url = $body['@odata.nextLink'] ?? null;
        } while ($url);
        
        
        
           
           
           
        /*$check1 = DB::table('producteurs_backsv')->pluck('caseid')->toArray();
        
        $check2 = DB::table('producteurs_new')->pluck('caseid')->toArray(); 
        
        $results = array_diff($check1, $check2);
        
        $show_result1s = array();
        foreach($results as $result)
        {
            
            $checkA1s = DB::table('producteurs_backsv')->where('caseid', $result)->get();
            
            foreach($checkA1s as $checkA1)
            {  
                
                array_push($show_result1s, $checkA1);
            }
        }
        
        
         foreach($show_result1s as $show_result1){
             if ($show_result1->campagne_coton == '23-24') {
                    DB::table('producteurs_new')->insert($show_result1);
             }
            
        }
        
        foreach($show_result1s as $show_result1){
             if ($show_result1->campagne_coton == '24-25') {
                    DB::table('producteurs_new')->insert($show_result1);
             }
            
        }  */

        $this->info('Le Code a été executé');
    }
}
