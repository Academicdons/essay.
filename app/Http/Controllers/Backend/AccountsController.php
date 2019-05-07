<?php

namespace App\Http\Controllers\Backend;

use App\Models\Bargain;
use App\Models\Order;
use App\Models\PaymentTransaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Webpatser\Uuid\Uuid;
use PDF;

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
        $orders->where('orders.status',4);
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


    public function users()
    {

        $orders = Order::join('assignments', 'orders.active_assignment', '=', 'assignments.id');
        $orders->join('users', 'assignments.user_id', '=', 'users.id');
        $orders->leftJoin('bargains', 'bargains.order_id', '=', 'orders.id');
        $orders->doesntHave('payment');
        $orders->where('orders.status',4);
        $orders->select(['orders.id','bargains.order_id','users.id as user_id','users.email','orders.order_no','orders.salary','users.name',DB::raw('SUM(bargains.amount) As bargains_sum, (IFNULL(SUM(bargains.amount),0)+orders.salary) as total')]);
        $orders->groupBy(['orders.id']);
        $result = $orders->get();

        /*
         * Group the accounts after lessening the DBMS work
         */
        $grouped = $result->groupBy('user_id')->map(function ($row) {
            $first=$row->first();
            return ['user_id'=>$first->user_id,'username'=>$first->name,'email'=>$first->email,'bargains'=>$row->sum('bargains_sum'),'salary'=>$row->sum('salary'),'amount'=>$row->sum('total')];
        });;


        return View::make('backend.accounts.users')->withAccounts($grouped);
    }

    public function invoice(User $user)
    {
        $orders = Order::join('assignments', 'orders.active_assignment', '=', 'assignments.id');
        $orders->join('users', 'assignments.user_id', '=', 'users.id');
        $orders->leftJoin('bargains', 'bargains.order_id', '=', 'orders.id');
        $orders->doesntHave('payment');
        $orders->where('orders.status',4);
        $orders->where('assignments.user_id',$user->id);
        $orders->select(['orders.id','orders.order_no','orders.title','bargains.order_id','users.id as user_id','users.email','orders.order_no','orders.salary','users.name',DB::raw('SUM(bargains.amount) As bargains_sum, (IFNULL(SUM(bargains.amount),0)+orders.salary) as total')]);
        $orders->groupBy(['orders.id']);
        $result = $orders->get();

        $pdf = PDF::loadView('layouts.invoice', ['orders'=>$result,'user'=>$user,'date'=>Carbon::now()]);
        return $pdf->download('invoice.pdf');
    }

    public function previewInvoice(Request $request)
    {

        $user = User::find($request->user);

        /*
         *get currently assigned orders ignoring other assignments fines
         */

//        $orders = Order::join('assignments', 'orders.active_assignment', '=', 'assignments.id');
//        $orders->join('users', 'assignments.user_id', '=', 'users.id');
//        $orders->leftJoin('bargains', 'bargains.order_id', '=', 'orders.id');
//        $orders->doesntHave('payment');
//        $orders->where('orders.status',4);
//        $orders->where('assignments.user_id',$user->id);
//        $orders->select(['orders.id','orders.order_no','orders.title','bargains.order_id','users.id as user_id','users.email','orders.order_no','orders.salary','users.name',DB::raw('SUM(bargains.amount) As bargains_sum, (IFNULL(SUM(bargains.amount),0)+orders.salary) as total')]);
//        $orders->groupBy(['orders.id']);
//        $result = $orders->get();

        /*
         *Get any other fines for this user that have the status unprocessed
         */

        $orders = Order::join('assignments', 'orders.active_assignment', '=', 'assignments.id');
        $orders->join('users', 'assignments.user_id', '=', 'users.id');
        $orders->doesntHave('payment');
        $orders->where('orders.status',4);
        $orders->where('assignments.user_id',$user->id);
        $orders->select(['orders.id']);
        $order_ids = $orders->get()->pluck('id');


        /*
         * get the current assigned orders particulars
         */

        $active_orders = Order::leftJoin('bargains', 'orders.id', '=', 'bargains.order_id');
        $active_orders->doesntHave('payment');
        $active_orders->where('orders.status',4);
        $active_orders->select(['orders.id','orders.order_no','orders.title','orders.order_no','orders.salary',DB::raw('SUM(bargains.amount) As bargains_sum, (IFNULL(SUM(bargains.amount),0)+orders.salary) as total')]);
        $active_orders->groupBy(['orders.id']);
        $active_orders->whereIn('orders.id',$order_ids);
        $active_result =$active_orders->get();

        /*
         * get all active bargains not in the above orders meaning a reassignment happened.
         */
        $bargains = Bargain::join('orders','bargains.order_id','=','orders.id');
        $bargains->select(['bargains.order_id','bargains.amount','orders.title','orders.order_no','bargains.reason']);
        $bargains->whereNotIn('orders.id',$order_ids);
        $bargains->where('bargains.status',0);
        $barg =$bargains->get();


        return view('backend.accounts.invoice')->withOrders($active_result)->withUser($user)->withBargains($barg)->withDate(Carbon::now());



    }

    public function bargains(Request $request)
    {
        $b = Bargain::where('order_id',$request->input('order'))->get();
        return response()->json($b);
    }
}
