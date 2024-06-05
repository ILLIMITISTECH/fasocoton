<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessagerieSicot2022 extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $event, $newsletter)
    {
        $this->user = $user;
        $this->newsletter = $newsletter;
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $objet = "NewsLetter - Optievent";
        if($this->newsletter)
            if($this->newsletter->objet)
                $objet = $this->newsletter->objet;
            
        return $this->subject($objet)->view('mail.newsletterOptievent', ['user'=> $this->user, 'newsletter'=> $this->newsletter, 'event'=> $this->event ]);
    }
}
