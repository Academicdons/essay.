<?php

namespace App\Jobs;

use App\Models\Assignment;
use App\Models\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class WriterAssignerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $allWriters=User::where('user_type',1)->where('status',true)->orderBy('ratings','DESC')->withCount('')->get();

        //loop through the users determining the ones with orders less than 3
        foreach ($allWriters as $writer){
            $writerActiveOrders=Assignment::where('user_id',$writer->id)->where('status',1)->get();
            if (count($writerActiveOrders)<3){
                //get one order and assign the user
                $unAssignedOrders=Order::where('status',0)->where('bid_deadline','<',Carbon::now()->toDateTimeString())->first();

                $assignment=new Assignment();
                $assignment->order_id=$unAssignedOrders->id;
                $assignment->user_id=$writer->id;
                $assignment->status=true;
                $assignment->save();
            }else{
                //user not viable for assignment
            }

        }
    }

}
