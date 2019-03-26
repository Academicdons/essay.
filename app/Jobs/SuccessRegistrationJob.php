<?php

namespace App\Jobs;

use App\Mail\SuccessRegistrationMail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SuccessRegistrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,$message)
    {
        $this->user=$user;
        $this->message=$message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->user)->send(new SuccessRegistrationMail($this->user,$this->message));
    }
}
