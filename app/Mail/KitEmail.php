<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class KitEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $more, $password, $event, $principal, $participant)
    {
        $this->data = $user;
        $this->more = $more;
        $this->password = $password;
        $this->event = $event;
        $this->principal = $principal;
        $this->participant = $participant;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Confirmation de votre Intérêt')
                ->view('mail.kitOptievent', ['user'=> $this->data, 'more'=> $this->more, 'password'=> $this->password, 'event'=> $this->event, 'principal'=> $this->principal, 'participant'=> $this->participant ]);
    }
}
