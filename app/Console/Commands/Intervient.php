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

use App\Notifications\EscalationAction;
use App\Notifications\EscalationActionResponsable;
use App\Notifications\AlerteEscalation;
use Notification;

class Intervient extends Command
    {
    /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = "intervient:update";
    
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
    
            //$modeles = DB::table('modeles')->get();
            
            //{
               //$count = DB::table('tache_modeles')->where('modele_id', $modele->id)->count() ;
               //$sum = DB::table('tache_modeles')->where('modele_id', $modele->id)->where('statut','=',1)->count();
               //$total = $count == 0 ? 0 : $sum / $count ;
               
               //$pourcentage = intval($total * 100);
            $tache_modelesints = DB::table('tache_modeles')->get();
            foreach($tache_modelesints as $tache_modelesint)
            {
               
            
               DB::table('modeles')->where('id', $tache_modelesint->modele_id)->update(['intervient' => 1]);
               
         
            
            }
            
    
        $this->info('L\'escalation a été faite');
    }
    
}
