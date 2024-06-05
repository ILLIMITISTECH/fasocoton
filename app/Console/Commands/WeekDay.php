<?php

namespace App\Console\Commands;
use Illuminate\Console\Command;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notifications\Messages\MailMessage;

use App\Notifications\BonDebutDeSemaine;
use App\Notifications\FinDeSemaine;

use Notification;

use App\User;
use DB;
use Auth;


class WeekDay extends Command
{

    use Queueable;  
    /**
     * The name and signature of the console command.
     *
     * @var string  
     */
    //protected $signature = 'command:name';
    protected $signature = 'week:day';

    /**
     * The console command description.  
     *
     * @var string
     */
    //protected $description = 'Command description';
    protected $description = 'Envoyer un e-mail quotidien à tous les utilisateurs pour un rappel de leurs actions en instance';

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
                $semaineM = (date('d') - 7);
                 $semaineP = (date('d') + 7);
                 $action_mois = date('m');
                 $total_semaine = array();
                 $var = array();
                 $nowme = now();
                $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.agent_id', 'actions.libelle',
                  'actions.bakup', 'actions.pourcentage','actions.created_at',
                  'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $person->id)
                    ->where('actions.deadline', '<', $nowme)
                    ->where('actions.pourcentage', '!=', 100)
                    ->orderBy('actions.deadline', 'ASC')
                    //->orWhere('actions.backup','=', $person->id)
                    ->get();

                    $agent_mois = DB::table('agents')->where('user_id', $person->id)->get();
                    foreach($agent_mois as $agent_moi){
                    $actionss = DB::table('actions')->where('agent_id', $agent_moi->id)->get();
                    foreach($actionss as $action)
                             {
                                 
                                if((date('d', strtotime($action->deadline)) > $semaineM) && ( date('d', strtotime($action->deadline)) < $semaineP))
                                 {
                                      $somme_semaine = $action->pourcentage;
                                      //$var += $perfNow;
                                      array_push($var,$action);
                                      $semaine_count = count($actions);
                                      //dd($semaine_count);
                                     array_push($total_semaine, $somme_semaine);

                                 }
                             }
        }
                    $semaines = array_sum($total_semaine);
                    $perfoMe = count($var);
                    $ma_semaine_total = $perfoMe == 0 ? 0 : $semaines / $perfoMe;
                    
             
          session(['user' => $user, 'actions' => $actions, 'ma_semaine_total' => $ma_semaine_total ]);
                $user->notify(new FinDeSemaine ());
        }
        $this->info('Mail de rappel hebdomadaire envoyé');
    }

}