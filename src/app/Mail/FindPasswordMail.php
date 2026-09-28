<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FindPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct($email, $tmpPassword)
    {
        $this->email = $email;
        $this->tmpPassword = $tmpPassword;
    }

    public function build()
    {
        return $this->subject('임시비밀번호 발급 안내')
            ->view('email.find_pw', ['email' => $this->email, 'password' => $this->tmpPassword]);
    }
}
