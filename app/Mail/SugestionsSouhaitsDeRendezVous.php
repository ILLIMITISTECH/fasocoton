<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SugestionsSouhaitsDeRendezVous extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$event)
    {
        //
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
        return $this->subject("Phase de suggestion :  Vos Rendez-vous B2B sont prêt  | Your B2B Meetings are waiting you! 📅")->view('mail.lancementPhaseSuggestions', ['user'=> $this->user, 'event'=> $this->event ]);
    }
}
