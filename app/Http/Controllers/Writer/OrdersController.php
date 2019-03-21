<?php

namespace App\Http\Controllers\Writer;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Webpatser\Uuid\Uuid;

class OrdersController extends Controller
{
    //

    public function availableOrders()
    {
        return View::make('writer.orders.available');
    }

    public function allOrders()
    {
        return View::make('writer.orders.all');
    }

    public function getUsersOrders()
    {


        return response()->json([
            'orders'=>Order::with(['client'])->get()
        ]);
    }

    public function viewOrder(Order $order)
    {
        return View::make('writer.orders.view')->withOrder($order);

    }


    public function orderReviews(Order $order)
    {
        return response()->json(['reviews'=>$order->reviews()->with('user')->get()]);
    }

    public function getMessages(Order $order)
    {
        $conversation = Conversation::firstOrCreate(['user_id' => Auth::id(),'order_id'=>$order->id], ['id'=>Uuid::generate()->string,'user_id' => Auth::id(),'order_id'=>$order->id]);
        return \response()->json([
            'conversation'=>$conversation,
            'messages'=>$conversation->messages()->with('user')->get(),
            'conversation_user'=>$conversation->user
        ]);
    }

    public function saveMessage(Request $request,Order $order)
    {
        $msg = $request->all();
        $msg['user_id'] = Auth::id();
        $msg['id'] = Uuid::generate()->string;
        Message::create($msg);

        return \response()->json([
            'success'=>true
        ]);
    }

    public function saveFile(Request $request,Order $order)
    {

    }

    public function availableOrdersJson()
    {


        $orders=Order::where('status',0)->with(['Discipline','Education','Paper'])->withCount('attachments')->orderBy('created_at','desc')->get();
        return response()->json([
            'orders'=>$orders,
        ]);
    }

    public function view(Order $order)
    {
        return View::make('writer.orders.view')->withOrder($order);
    }

}
