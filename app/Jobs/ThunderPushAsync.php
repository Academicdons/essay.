<?php

namespace App\Jobs;

use App\Plugins\Thunderpush;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ThunderPushAsync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $channel;
    private $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($channel,$data)
    {
        //
        $this->channel = $channel;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $thunder = new Thunderpush();
        $thunder->notifyChannel($this->channel,$this->data);
    }
}
