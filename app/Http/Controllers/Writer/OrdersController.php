<?php

namespace App\Http\Controllers\Writer;

use App\Jobs\AssignOrderMail;
use App\Jobs\SendSystemEmail;
use App\Models\Assignment;
use App\Models\Attachment;
use App\Models\Bargain;
use App\Models\Bid;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderReview;
use App\Models\Revision;
use App\Notifications\ChatNotification;
use App\Notifications\RevisedNotification;
use App\User;
use Carbon\Carbon;
use Dilab\Network\SimpleRequest;
use Dilab\Network\SimpleResponse;
use Dilab\Resumable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
class OrdersController extends Controller
{
    //

    public function availableOrders()
    {
        return View::make('writer.orders.available');
    }

    public function getRecentOrders(Request $request)
    {
        $orders = Assignment::join('orders','assignments.order_id','orders.id')
            ->where('assignments.user_id',Auth::id())
            ->get();
        return response()->json($orders);
    }

    public function allOrders(Request $request)
    {
        return View::make('writer.orders.all')->withStatus($request->status);
    }

    public function getUsersOrders(Request $request)
    {

        $orders = Order::join('assignments', 'orders.active_assignment', '=', 'assignments.id');
        $orders->join('users', 'assignments.user_id', '=', 'users.id');
//        $orders->where('assignments.user_id',Auth::id());
//        $orders->where('assignments.status',1);
        $orders->where('orders.status',$request->input('status'));


        return response()->json([
            'orders'=>$orders->withCount('attachments')->get()
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

        if($conversation->messages()->count()<=0){
            $msg = ['id'=>Uuid::generate(),'conversation_id'=>$conversation->id,'message'=>'Hello there, start a conversation about this order here'];
            $msg['user_id'] = config('app.admin');
            $msg['id'] = Uuid::generate()->string;
            Message::create($msg);
        }


        return response()->json([
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
        $message = Message::create($msg);

        $user_ids = Message::select('user_id')->where('conversation_id',$msg['conversation_id'])->distinct('user_id')->get()->toArray();
        $conversation_users = User::whereIn('id',Arr::pluck($user_ids,'user_id'))->get();
        Notification::send($conversation_users, new ChatNotification($message));

        return \response()->json([
            'success'=>true
        ]);
    }

    public function saveFile(Order $order)
    {

        $request = new SimpleRequest();
        $response = new SimpleResponse();
        $temp_path=Config::get('app.folder') . '/temps';
        $file_path = Config::get('app.folder') . '/order_files';


        if (!File::exists($temp_path)) {
            File::makeDirectory($temp_path, 0777, true, true);
        }

        if (!File::exists($file_path)) {
            File::makeDirectory($file_path, 0777, true, true);
        }

        $resumable = new Resumable($request, $response);
        $resumable->tempFolder = $temp_path ;
        $resumable->uploadFolder = $file_path;

        $originalName = $resumable->getOriginalFilename(Resumable::WITHOUT_EXTENSION);
        $filename = uniqid() . '.' . $resumable->getExtension();
        $resumable->setFilename($filename);


        $resumable->process();

        if (true === $resumable->isUploadComplete()) {
            $document = new Attachment();
            $document->id = Uuid::generate();
            $document->file_name = $filename;
            $document->display_name = $originalName;
            $document->order_id = $order->id;
            $document->created_by=Auth::id();
            $document->save();

        }


    }

    public function availableOrdersJson()
    {

        $orders=Order::has('PaypalTransaction')->where('status',0)->with(['Discipline','Education','Paper'])->withCount('attachments')->orderBy('created_at','desc')->get();
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
        $review=new OrderReview();
        $review->id= Uuid::generate();
        $review->order_id=$request->order_id;
        $review->rating=$request->rating;
        $review->review=$request->review_data;
        $review->user_id=Auth::id();
        $review->save();

        //mark the order as now completed
        $order=Order::find($request->order_id);
        $order->status=3;
        $order->save();

        return redirect()->back();

    }

    public function placeBid(Order $order_id)
    {
        $bid=Bid::where('order_id',$order_id->id)->where('user_id',Auth::id())->first();

        if($order_id->bid_expiry->isPast()){
            return back()->withErrors(new MessageBag(["bid"=>"Bidding time for this order has expired"]));
        }


        if ($bid==null){
            $bid=new Bid();
            $bid->order_id=$order_id->id;
            $bid->user_id=Auth::id();
            $bid->save();
        }

        return redirect()->back();
    }

    public function markAsComplete(Order $order)
    {
        //first determine if the order has an existing attachment from the writer
        $attachment=Attachment::where('created_by',Auth::id())->where('order_id',$order->id)->first();
        if ($attachment==null){

            return redirect()->back()->withErrors([ 'First Upload the file before marking the order as complete']);
        }

        $order->status=3;
        $order->save();

        $client=User::find($order->created_by);
        $message='The order' . $order->order_no. ' has been completed';
        //dispatch the job
        $this->dispatch(new SendSystemEmail($client->email,$message));

        return redirect()->back();
    }

    public function finished(Request $request)
    {
        return View::make('writer.orders.finished')->withPaid($request->paid);

    }

    public function finishedOrders(Request $request)
    {
        $orders = Order::join('assignments', 'orders.active_assignment', '=', 'assignments.id');
        $orders->join('users', 'assignments.user_id', '=', 'users.id');
        $orders->leftJoin('bargains', 'bargains.order_id', '=', 'orders.id');

        //TODO revert this comments
        /*
         * Consider complete orders which are paid or unpaid
         */
//        if(request('pay_state')==0 || !$request->has('pay_state')){
//            $orders->doesntHave('payment');
//        }else{
//            $orders->has('payment');
//        }
//        $orders->with('payment');


//        $orders->where('orders.status',4);
        $orders->where('assignments.user_id',Auth::id());
        $orders->select(['orders.id','orders.title','orders.deadline','orders.no_pages','orders.no_words','orders.order_no','orders.salary',DB::raw('SUM(bargains.amount) As bargains_sum')]);
        $orders->groupBy('orders.id');

        $result = $orders->get();

        return response()->json($result);
    }

    public function revisions(Request $request)
    {
        $order = Order::find($request->input('order_id'));
        return response()->json($order->revision);
    }

    public function bargains(Request $request)
    {
        $b = Bargain::where('order_id',$request->input('order'))->get();
        return response()->json($b);
    }

    public function getRevisionDeadline($order_id)
    {
       $revision=Revision::where('order_id',$order_id)->first();

       return response()->json(['revision'=>$revision]);
    }

    public function markCompletedOrder(Order $order)
    {
        $order->status=3;
        $order->save();

        //get the active assignment for the order
        $active_assignment=$order->currentAssignment();
        if ($active_assignment!=null){
            $user=User::find($active_assignment->user_id);
            $user->notify(new RevisedNotification('The order '. $order->order_no.' has now been marked as complete from revision'));
        }


        return \redirect()->back();
    }
}
