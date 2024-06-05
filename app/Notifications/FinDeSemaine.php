<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\User;
use DB;

use Auth;

class FinDeSemaine extends Notification
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
       $user = session('user');
        $actions = session('actions');
        $ma_semaine_total = session('ma_semaine_total');
        $params = ["user" => $user, "actions" => $actions, "ma_semaine_total" => $ma_semaine_total];
        
        if(count($params['actions']) != 0)
        {
        
        return (new MailMessage)->subject("Votre performance de la semaine")->view('mail.findesemane', ['params' => $params]);
        }
        else
         {
        return (new MailMessage)->subject("Votre performance de la semaine")->view('mail.findesemaneNon', ['params' => $params]);
        }
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