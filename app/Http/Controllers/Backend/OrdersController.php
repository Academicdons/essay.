<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class OrdersController extends Controller
{
    public function index()
    {
        return view('backend.orders.index');
    }

    public function newOrder()
    {
        return view('backend.orders.new');
    }

    public function store(Request $request)
    {
        if ($request->has('id') && $request->id != null){
            $order = Order::find($request->id);
        }else{
            $order = new Order();
        }

        $order->notes = $request->notes;
        $order->cpp = $request->cpp;
        $order->title = $request->title;
        $order->order_no = mt_rand(100000, 999999);
        $order->no_pages = $request->no_pages;
        $order->no_words = $request->no_words;
        $order->amount = $request->amount;
        $order->order_assign_type = $request->order_assign_type;
        $order->deadline = $request->deadline;
        $order->bid_expiry = $request->bid_expiry;
        $order->save();

        return Redirect::route('admin.orders.index');
    }
}
