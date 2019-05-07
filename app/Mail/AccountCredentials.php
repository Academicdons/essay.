<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AccountCredentials extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var User
     */
    private $user;
    private $message;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$message)
    {
        //
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email)
            ->subject('Account password')
            ->with(['user'=>$this->user,'message_to_user'=>$this->message])
            ->view('mails.account_credentials');
    }
}
