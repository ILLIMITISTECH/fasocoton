<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RappelSuggestion extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $event)
    {
       
        $this->user = $user;
        $this->event = $event;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Phase de Suggestion des Rendez-vous B2B - Plus que quelques jours pour vos suggestions")->view('mail.mail_rappel_suggestion', ['user'=> $this->user, 'event'=> $this->event]);
    }
}
