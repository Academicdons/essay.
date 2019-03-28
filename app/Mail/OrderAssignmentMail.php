<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderAssignmentMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$msg)
    {
        //
        $this->user=$user;
        $this->message=$msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email)
            ->subject('Order assignment mail')
            ->view('mails.assignment_mail')
            ->with(['user'=>$this->user,'msg'=>$this->msg]);
    }
}
