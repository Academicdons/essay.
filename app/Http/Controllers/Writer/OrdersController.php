<?php

namespace App\Http\Controllers\Writer;

use App\Jobs\AssignOrderMail;
use App\Models\Bid;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Order;
use http\Client\Curl\User;
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

    public function getUsersOrders(Request $request)
    {

        $orders=Order::where('status',$request->status)->with(['client','revision'])->get();

        return response()->json([
            'orders'=>$orders
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

    public function review(Request $request)
    {
        //TODO add the review data here from the writer
    }

    public function placeBid($order_id)
    {
        $bid=Bid::where('order_id',$order_id)->where('user_id',Auth::id())->first();
        if ($bid==null){
            $bid=new Bid();
            $bid->order_id=$order_id;
            $bid->user_id=Auth::id();
            $bid->save();
        }

        return redirect()->back();
    }

    public function markAsComplete(Order $order)
    {
        $order->status=3;
        $order->save();

        $client=User::where('created_by',$order->created_by)->first();
        $message='The order' . $order->order_no. ' has been completed';
        //dispatch the job
        $this->dispatch(new AssignOrderMail($client,$message));

        return redirect()->back();
    }
}
