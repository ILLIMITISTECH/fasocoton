<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\User;
use DB;

use Auth;

class BonDebutDeSemaine extends Notification
{
    use Queueable;  
    public $user; 

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];  
    }  

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $person = Auth::user();
        $actions = DB::table('actions')->select('actions.id', 'actions.deadline', 'actions.responsable', 'actions.libelle', 'actions.note',
                    'actions.agent_id','actions.reunion_id','actions.raison',  'actions.visibilite','actions.bakup',  'actions.risque', 'actions.delais','actions.pourcentage', 'actions.note','actions.created_at',
                    'agents.prenom', 'agents.nom', 'agents.photo', 'agents.id as Id'
                    )
                    ->join('agents', 'agents.id', 'actions.agent_id')
                    ->where('actions.agent_id','=', $person->id)
                    ->orWhere('actions.bakup','=', $person->prenom)
                    ->get();
        $params = ["user" => $person, "actions" => $actions];
        return (new MailMessage)->subject("Bon début de semaine")->view('mail.weekly', ['params' => $params]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}