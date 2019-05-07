<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class MapBargains extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bargains:transfer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Temporary command to fix the fines issues';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //

        $orders = Order::has('bargains')->get();
        foreach ($orders as $order){
            $ass = $order->currentAssignment();
            if($ass!=null){
                echo "correcting order id " . $order->order_no . "\n";
                /*
                 *Loop through the orders bargains adding the user id
                 */
                foreach ($order->bargains as $bargain){
                    $bargain->user_id = $ass->user_id;
                    $bargain->save();
                }
            }
        }

        echo "Completed bargains corrections \n";
    }
}

