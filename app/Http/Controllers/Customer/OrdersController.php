<?php

namespace App\Http\Controllers\Customer;

use App\Jobs\ThunderPushAsync;
use App\Models\Attachment;
use App\Models\Conversation;
use App\Models\Discipline;
use App\Models\DisputedOrder;
use App\Models\EducationLevel;
use App\Models\Group;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderReview;
use App\Models\PaperType;
use App\Models\PaypalTransaction;
use App\Models\Revision;
use App\Notifications\ChatNotification;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use PayPal\Exception\PayPalConnectionException;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use Webpatser\Uuid\Uuid;

class OrdersController extends Controller
{
    //

    public function create()
    {

        return View::make('customer.orders.create')->withGroups(Group::all())->withDisciplines(Discipline::all())->withEducation(EducationLevel::all())->withPapers(PaperType::all());
    }

    public function list()
    {
          return View::make('customer.orders.list');
    }

    public function pay(Order $order)
    {
        return View::make('customer.orders.pay')->withOrder($order);

    }

    public function processPay(Request $request)
    {

        $clientId = "ASjp_tVTIhR9EWEq-OMNcBYV-6blTi1WW--qertlTExyaTZO8S8g9xfUFH2d5ZzUfeKPC6kM9CID6ovd";
        $clientSecret = "EN7AZ7nRbqiKFbKB98i0nwT-gC5fjr8eOZ4wuoDZscFoFLmMpkCeLclZzEiEW5pQE1sxFDxsdeuN0ODC";

//        $environment = new SandboxEnvironment($clientId, $clientSecret);
        $environment = new ProductionEnvironment($clientId, $clientSecret);
        $client = new PayPalHttpClient($environment);
        $result=[];


        $paypal_transaction = new PaypalTransaction();
        $paypal_transaction->id=Uuid::generate();
        $paypal_transaction->order_id = $request->input('orderRef');
        $paypal_transaction->pay_pal_ref = $request->input('orderID');

        try{
            $response = $client->execute(new OrdersGetRequest($request->input('orderID')));

            $paypal_transaction->amount = $response->result->purchase_units[0]->amount->value;
            $paypal_transaction->pay_pal_name=$response->result->purchase_units[0]->amount->currency_code;
            $paypal_transaction->status = 1;

            $result = [
                'success'=>true,
            ];

        }catch (Exception $exception){

            $paypal_transaction->amount = 0;
            $result = [
                'success'=>false,
            ];
        }

        $paypal_transaction->save();

        return response()->json($result);

    }


    public function getOrders(Request $request)
    {
        $orders = Order::where('created_by',Auth::id())->with(['Discipline','Education','Paper','PaypalTransaction'])->withCount(['attachments'=>function($hehe){
            $hehe->where('is_verified',true);
        }])->orderBy('created_at','desc')->get();
        return response()->json([
            'orders'=>$orders
        ]);
    }

    public function fetchOrder($order)
    {
        $orders = Order::where('id',$order)->with(['Discipline','Education','Paper','PaypalTransaction'])->withCount('attachments')->orderBy('created_at','desc')->first();

        return response()->json([
            'order'=>$orders,
            'files'=>Order::where('id',$order)->with(['attachments'=>function($query){
                    $query->where('is_verified',true);
            }])->first(),
        ]);

    }

    public function store(Request $request)
    {


        $order = new Order();
        $order->id = Uuid::generate()->string;

        /*
         * calculate cost per page by first basing the timezone
         */
        $discipline = Discipline::find(request('discipline'));
        $base_price = Group::find($discipline->group_id)->base_price;

        $timestamp = request('date_input') . " " . request('time_input');
        $date = Carbon::createFromFormat("m/d/Y g:i A", $timestamp, request('tz'));
        $date->setTimezone('UTC');

        $ed_factor = EducationLevel::find(request('education_level'))->price_factor;
        $cpp = $base_price*$ed_factor*$this->getAmountInTime($date->diffInHours(Carbon::now()));

        $base_salary = Group::find($discipline->group_id)->writer_price;



        $order->notes = $request->instructions;
        $order->cpp = $cpp;
        $order->spacing = $request->spacing;
        $order->title = $request->topic;
        $order->order_no = mt_rand(100000, 999999);

        //determine the number of pages
        if($order->spacing==0){
            $no_of_pages=(round($request->number_of_words/550));
        }else{
            $no_of_pages=(round($request->number_of_words/275));
        }
        if ($no_of_pages==0){
            $no_of_pages=1;
        }


        $order->no_pages =$no_of_pages;
        $order->salary = $base_salary *$no_of_pages;
        $order->amount = $cpp*$no_of_pages;



        $order->no_pages =$no_of_pages;
        $order->salary = $base_salary *$no_of_pages;
        $order->amount = $cpp*$no_of_pages;

        $order->no_words = $request->number_of_words;
        $order->no_of_sources = $request->no_of_sources;
        $order->order_assign_type = 1;
        $order->deadline = $date;

        //make the writes deadline to be half of the client deadline
        $writer_hours=$date->diffInHours(Carbon::now())/2;
        $writer_deadline=Carbon::now()->addHours($writer_hours);


        $order->writer_deadline = $writer_deadline;
        $order->bid_expiry = Carbon::now()->addMinute(5);
        $order->paper_type = $request->paper_type;
        $order->discipline = $request->discipline;
        $order->education_level = $request->education_level;
        $order->type_of_service = $request->type_of_service;
        $order->writer_quality = $request->writer_quality;
        if (Auth::check()){
            $order->created_by = Auth::id();


        }else{
            Session::put('order_id',$order->id);

        }
        $order->Save();


        //send a notification of the new order that has been created if the user is authed
        if (Auth::check()){
            dispatch(new ThunderPushAsync($order->id,$event = ["event"=>"order",
                "data"=>null
            ]));
        }

        /*
         * collect the files
         */

        $docs = Session::get('upload_files');
        if($docs!=null){
            $documents = Attachment::whereIn('id',$docs)->get();
            if(count($documents)>0){
                foreach ($documents as $document){
                    $document->order_id = $order->id;
                    $document->save();
                }
            }
        }

        Session::put('upload_files',null);

        return redirect()->route('customer.orders.pay',$order->id);


    }

    function getAmountInTime($hours) {

        if ($hours<20)
            return 1.25;
            else if ($hours<72)
                return 1;
            else
                return 0.75;
        }

    public function view(Order $order)
    {
        return View::make('customer.orders.view')->withOrder($order);
    }

    public function deleteFile()
    {

        $attachment = Attachment::find(\request('attachment'));

        $path =  public_path('uploads/order_files/');
        try{
            File::Delete($path . $attachment->file);
        }catch (Exception $h){

        }

        $attachment->delete();

    }


    public function messages(Order $order)
    {

        $conversation = Conversation::firstOrCreate(['user_id' => $order->created_by,'order_id'=>$order->id], ['id'=>Uuid::generate()->string,'user_id' => $order->created_by,'order_id'=>$order->id]);

        if($conversation->messages()->count()<=0){
            $msg = ['id'=>Uuid::generate(),'conversation_id'=>$conversation->id,'message'=>'Hello there, start a conversation about this order here'];
            $msg['user_id'] = config('app.admin');
            $msg['id'] = Uuid::generate()->string;
            Message::create($msg);
        }

        return \response()->json([
            'conversation'=>$conversation,
            'messages'=>$conversation->messages()->orderBy('created_at','asc')->with('user')->get(),
            'conversation_user'=>$conversation->user
        ]);

    }


    public function saveMessage(Request $request)
    {
        $msg = $request->all();
        $msg['user_id'] = Auth::id();
        $msg['id'] = Uuid::generate()->string;
        $message = Message::create($msg);

        /*
         * Dispatch a thunderpush event for all people listening
         */
        dispatch(new ThunderPushAsync($msg['conversation_id'],$event = ["event"=>"conversation",
            "data"=>null
        ]));

        /*
         * Dispatch a notification -To email, database and onesignal for emphasis.
         * 1. query all unique user ids in messages in this conversation
         * 2. Notify the participants                                                                                                                                                                                                                    ```notify them
         */

        $user_ids = Message::select('user_id')->where('conversation_id',$msg['conversation_id'])->distinct('user_id')->get()->toArray();
        $conversation_users = User::whereIn('id',Arr::pluck($user_ids,'user_id'))->get();
        Notification::send($conversation_users, new ChatNotification($message));

        return response()->json([
            'success'=>true
        ]);

    }

    public function revision(Order $order,Request $request)
    {
        $data = $request->only('reason');
        $data['id']=Uuid::generate()->string;
        $data['order_id']=$order->id;
        Revision::create($data);

        $order->status=2;
        $order->save();

        return response()->json([
            'success'=>true
        ]);
    }

    public function review(Order $order,Request $request)
    {
        /*
         * Update order status to finished
         */
        $order->status=4;
        $order->save();
        $assignment = $order->currentAssignment();

        /*
         * create a review for the intended user and order
         */

        $old_review = OrderReview::where([['order_id',$order->id],['user_id',Auth::id()]])->first();
        if($old_review!=null){
            return response()->json([
                'success'=>false
            ]);
        }


        $data=$request->only(['review','rating']);
        $data['id']=Uuid::generate()->string;
        $data['order_id']=$order->id;
        $data['rated_user']=($assignment!=null)?$assignment->user_id:null;
        $data['user_id']=Auth::id();
        OrderReview::create($data);

        /*
         * update the writers rating
         */
        if($assignment!=null){
            $user = User::find($assignment->user_id);
            $new_rating = OrderReview::where('rated_user',$assignment->user_id)->average('rating');
            $user->ratings = $new_rating;
            $user->save();
        }


        return response()->json([
            'success'=>true
        ]);
    }

    public function reviews(Order $order)
    {
        return response()->json([
            'client_review'=>$order->reviews()->orderBy('created_at','desc')->where('user_id',Auth::id())->first(),
            'other_review'=>$order->reviews()->orderBy('created_at','desc')->where('user_id','!=',Auth::id())->first()
        ]);
    }

    public function disputeOrder(Request $request)
    {
        $this->validate($request,[
            'dispute_reason'=>'required',
            'order_id'=>'required'
        ]);

        //create the dispute record
        $dispute=new DisputedOrder();
        $dispute->id=Uuid::generate()->string;
        $dispute->reason=$request->dispute_reason;
        $dispute->order_id=$request->order_id;
        $dispute->save();

        //change the status value of the order to disputed
        $order=Order::find($request->order_id);
        $order->status=5;
        $order->save();


        return response()->json([
            'dispute'=>$dispute
        ]);
    }

    public function fetchDisputes($order_id)
    {

       $disputes= DisputedOrder::where('order_id',$order_id)->get();

       return response()->json([
           'disputes'=>$disputes
       ]);
    }

    public function markRevisedOrderAsComplete(Order $order)
    {
        $order->status=3;
        $order->save();

        //TODO determine if an email should be sent to the writer to inform them whether the order is marked as complete form revision

        return redirect()->back();
    }
}
