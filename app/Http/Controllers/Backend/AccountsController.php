<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\Models\PaymentTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class AccountsController extends Controller
{
    //

    public function index()
    {
        return view('backend.accounts.index');
    }

    public function getData(Request $request)
    {

        $orders = Order::join('assignments', 'orders.active_assignment', '=', 'assignments.id');
        $orders->join('users', 'assignments.user_id', '=', 'users.id');
        $orders->leftJoin('bargains', 'bargains.order_id', '=', 'orders.id');

        /*
         * Consider complete orders which are paid or unpaid
         */
        if(request('status')==0 || !$request->has('status')){
            $orders->doesntHave('payment');
        }else{
            $orders->has('payment');
        }
        $orders->with('payment');
        /*
         * consider date ranges set
         */
        if($request->input('start')==0 || !$request->has('start')){
            $start=Carbon::now();
            $stop=Carbon::now()->subMonth(1);
        }else{
            $start=Carbon::createFromFormat('Y-m-d H',$request->input('stop'));
            $stop=Carbon::createFromFormat('Y-m-d H',$request->input('start'));
        }

        $orders->whereBetween('orders.created_at',[$stop,$start]);
//        $orders->where('orders.status',4);
        $orders->select(['orders.id','orders.order_no','orders.salary','users.name',DB::raw('SUM(bargains.amount) As bargains_sum')]);
        $orders->groupBy('orders.id');

        $result = $orders->get();

        return response()->json($result);

    }

    public function payOrder(Request $request)
    {

        $order = Order::where('id',$request->input('order'))->first();
        $bargains = $order->bargains->sum('amount');

        $payment = PaymentTransaction::updateOrCreate(
            ['order_id' => $order->id],
            ['amount' => $order->salary+$bargains,'id'=>Uuid::generate()->string]
        );

        return response()->json($payment);

    }
}
