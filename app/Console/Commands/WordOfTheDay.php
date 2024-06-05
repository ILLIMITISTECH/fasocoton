<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notifications\Messages\MailMessage;

use App\Notifications\BonDebutDeSemaine;
use App\Notifications\DebutDeSemaine;

use Notification;

use App\User;
use DB;
use Auth;


class WordOfTheDay extends Command
{

    use Queueable;  
    /**
     * The name and signature of the console command.
     *
     * @var string  
     */
    //protected $signature = 'command:name';
    protected $signature = 'word:day';

    /**
     * The console command description.  
     *
     * @var string
     */
    //protected $description = 'Command description';
    protected $description = 'Envoyer un e-mail quotidien à tous les utilisateurs pour un rappel de leurs modeles en instance';

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
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];  
    }  

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    

    public function handle()
    {
        
        $users = User::all();
        $nowme = now();
         foreach($users as $user){
            Auth::login($user);
            //$user->notify(new BonDebutDeSemaine());
                $person = Auth::user();
                $action_semaineM7 = (date('d') -7);
                $action_semaineP7 = (date('d') +7);
                $action_mois = date('m');
                $action_responss = array();
               
               $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.agent_id', 'actions.libelle',
                  'actions.bakup', 'actions.pourcentage','actions.created_at',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $person->id)
                    //->orWhere('actions.backup','=', $person->id)
                    ->get();
                $action_responsf = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable',
                                'actions.libelle', 'actions.note',
                                'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',
                                'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                                'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id','directions.nom_direction'
                                )
                                ->join('agents', 'agents.id', 'actions.agent_id')
                                ->leftjoin('directions', 'directions.id', 'agents.direction_id')
                                ->where('actions.agent_id','=', $user->id)
                               // ->where('actions.bakup','=', $users->full_name)
                                 ->orderBy('actions.deadline', 'ASC')
                                ->get();
                                foreach($action_responsf as $action_respf)
                                {
                                    if(($action_semaineP7 >= date('d', strtotime($action_respf->deadline))) && ($action_semaineM7 <= date('d', strtotime($action_respf->deadline))) && ($action_mois == date('m', strtotime($action_respf->deadline))) && ($action_respf->pourcentage < 100) )
                                    {
                                        array_push($action_responss, $action_respf);
                                    }
                                }

                //$taches = DB::table('tache_actions')->select('tache_actions.id', 'tache_actions.deadline', 'tache_actions.res_dir', 'tache_actions.libelle',
                // 'tache_actions.created_at','tache_actions.statut'
                   // )
                    //->join('agents', 'agents.id', 'tache_actions.res_dir')
                    //->where('tache_actions.res_dir','=', $person->id)
                    //->orWhere('actions.backup','=', $person->id)
                    //->get();
                    //$params = ["user" => $person, "indicateurs" => $indicateurs];
                 //foreach($indicateurs as $indicateur){   
                         
                   //$libelle = $indicateur->libelle;
                   //$cible = $indicateur->cible;
                   //$valeur = $indicateur->valeur_prec;
                   
                // }
                session(['user' => $user, 'action_responss' => $action_responss ]);
                $user->notify(new DebutDeSemaine ());
               
              
                     //}       
        }
         
        $this->info('Mail de rappel hebdomadaire envoyé');
    }

}