<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MessageMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var User
     */
    private $user;
    private $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$msg)
    {
        //
        $this->user = $user;
        $this->msg = $msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email)
            ->subject('Homeworkprowriters chat message')
            ->view('mails.message_mail')
            ->with(['user'=>$this->user,'msg'=>$this->msg]);
    }
}
