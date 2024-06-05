<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\User;
use DB;

use Auth;

class DebutDeSemaine extends Notification
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
        $action = session('action_responss');
        $params = ["user" => $user, "action" => $action];
        
        if($params['action'])
        {
        
        return (new MailMessage)->subject("Bon début de semaine")->view('mail.bondebutdesemaine', ['params' => $params]);
        }
        else
         {
        return (new MailMessage)->subject("Bon début de semaine")->view('mail.bondebutdesemaineNon', ['params' => $params, 'action' => $action]);
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