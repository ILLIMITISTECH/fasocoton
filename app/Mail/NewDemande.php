<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewDemande extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $text = "Faso Coton : Une demande de helpdesk vient d'être envoyer";
        return $this->subject($text)->view('mail.newdemande');
    }
}
