<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SuccessRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;
        protected $user;
        protected $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$message)
    {
        $this->user=$user;
        $this->message=$message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->to($this->user->email)
            ->with(['user'=>$this->user,'message_to_user'=>$this->message])
            ->view('mails.assignment_mail'); //this page has been reused
    }
}
