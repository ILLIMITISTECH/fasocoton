<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailRefuser extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.   
     *
     * @return void
     */  
    public $sub;
    public $mes;
    public function __construct($subject, $message)
    {
        //
        $this->sub = $subject;
        $this->mes = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $e_subject = $this->sub;
        $e_message = $this->mes;
        return $this->subject("$e_subject")->view('mail.SendMailRefuser', compact("e_message"));
    }
}
