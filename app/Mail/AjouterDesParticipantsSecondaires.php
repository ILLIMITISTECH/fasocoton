<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AjouterDesParticipantsSecondaires extends Mailable
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
        return $this->subject('Votre inscription au Salon International du Coton et du Textile 2024 !')
                ->view('mail.AjoutParticipantSecondaire', ['user'=> $this->user, 'event'=> $this->event]);
    }
}
