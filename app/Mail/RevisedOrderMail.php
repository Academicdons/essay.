<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RevisedOrderMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $msg;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$msg)
    {
        //
        $this->user=$user;
        $this->msg=$msg;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email)
            ->subject('Revised Order Mail')
            ->view('mails.revised_order_mail')
            ->with(['user'=>$this->user,'msg'=>$this->msg]);
    }
}
