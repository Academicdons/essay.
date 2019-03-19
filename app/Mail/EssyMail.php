<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EssyMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $user;
    protected $email;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,$email)
    {
        //
        $this->user=$user;
        $this->email=$email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email)
            ->with(['user'=>$this->user,'email'=>$this->email])
            ->view('mails.essay_mail');
    }
}
