<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password, $event)
    {
        $this->user = $user;
        $this->password = $password;
        $this->event = $event;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("🎉 Bienvenue à la troisième édition du Salon International du Coton et du Textile (SICOT) ! ! Let's Get Started! 🚀")->view('mail.welcomeOptievent', ['user'=> $this->user, 'password'=> $this->password , 'event'=> $this->event ]);
    }
}
