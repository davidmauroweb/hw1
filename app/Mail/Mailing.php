<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailing extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
   
    public function __construct($email)
    {
        $this->email = $email;
    }

    public function build()
    {
        return $this->from($this->email->sender)
                    ->view($this->email->template)
                    ->text($this->email->template)
                    ->subject($this->email->subject)
                    ->with(
                      [
                            'IP' => '190.190.232.246',
                            'Port' => '80'
                      ]);
                     
    }
    
}