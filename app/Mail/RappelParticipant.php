<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RappelParticipant extends Mailable
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
        return $this->subject("Rappel - Fin de la Phase d'Inscription au SICOT 🚀")->view('mail.mail_rappel_participant', ['user'=> $this->user, 'event'=> $this->event]);
    }
}
