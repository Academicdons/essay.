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
use Webpatser\Uuid\Uuid;

class AssignWriterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public function __construct()
    {

//        $revisionOrders=Order::where('')


        //

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        //order users according to their ratings
        $writers=User::where('user_type',1)->orderBy('ratings','desc')->get();
        //loop through the writers assigning them the orders
        foreach($writers as $writer){
            //get the unassigned orders

            $unAssignedOrders=Order::whereNull('active_assignment')->first();

            if ($unAssignedOrders==null){
                $lateOrders=Order::WhereDate('bid_expiry','>',Carbon::today())->orderBy('bid_expiry','desc')->first();
                $order=$lateOrders;
            }else{
                $order=$unAssignedOrders;
            }

            if ($order==null){
                return;
            }else{

//      //create the assignment
                $assignment=new Assignment();
                $assignment->id=Uuid::generate()->string;
                $assignment->order_id=$order->id;
                $assignment->user_id=$writer->id;
                $assignment->save();

                //        //assign the order the assignment id
                $order=Order::find($order->id);
                $order->active_assignment=$assignment->id;
                $order->save();
            }




        }

    }
}
