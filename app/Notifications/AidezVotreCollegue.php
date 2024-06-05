<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use Auth;

class AidezVotreCollegue extends Notification
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
        $user =  Auth::user();
        $actions = session('actionsj');
        $params = ["user" =>  $user, "actions" => $actions];
       
        return (new MailMessage)->subject("Aidez votre collègue")->view('mail.notificationbackup', ['params' => $params]);
        /* return (new MailMessage)
                    ->subject('Bienvenue dans FNDGROUP')
                    ->line('Salut Mr {{$notifiable->nom}}, On est content que tu sois inscrit dans notre site.')
                    ->action('FNDGROUP', config('app.url'))
                    ->line('A Bient么t!'); */
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
