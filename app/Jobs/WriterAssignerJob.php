<?php

namespace App\Jobs;

use App\Models\Assignment;
use App\Models\Order;
use App\Models\SystemSettings;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

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

        /*
         * check if settings allow the auto assign job
         */

        $settings = SystemSettings::firstOrCreate(['auto_assign' => true]);
        if($settings->auto_assign){
            /*
             * get all unassigned orders
             * loop through the orders
             * For every order find the most suitable writer
             * Assign the most suitable writer the order
             */

            $orders = Order::where('status',0)->where('bid_expiry','<',Carbon::now()->toDateTimeString())->get();
            foreach ($orders as $order){

                /*
                 * Query for users who have less than 3 orders in progress
                 */
                $users = User::join('assignments','users.id','assignments.user_id')
                    ->join('orders','assignments.order_id','orders.id')
                    ->select(['users.*', DB::raw("count(users.id) as orders_count")])
                    ->where('orders.status',1)
                    ->having('orders_count', '<' , 3)
                    ->groupBy(['users.id'])
                    ->orderBy('users.ratings','desc')
                    ->get();

                $users->shuffle();
                $user = $users[0];

                $assignment=new Assignment();
                $assignment->id=Uuid::generate()->string;
                $assignment->order_id=$order->id;
                $assignment->user_id=$user->id;
                $assignment->status=true;
                $assignment->save();

                $order->status = 1;
                $order->save();
            }
        }

    }

}
