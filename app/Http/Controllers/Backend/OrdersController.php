<?php

namespace App\Http\Controllers\Backend;

use App\Jobs\AssignOrderMail;
use App\Jobs\SendSystemEmail;
use App\Jobs\ThunderPushAsync;
use App\Jobs\WriterAssignerJob;
use App\Mail\OrderAssignmentMail;
use App\Mail\MessageMail;
use App\Mail\WriterEssayTest;
use App\Models\Attachment;
use App\Models\Bargain;
use App\Models\Bid;
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
use App\Notifications\DisputedNotification;
use App\Notifications\OrderAssignment;
use App\Notifications\RevisedNotification;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\View;
use Webpatser\Uuid\Uuid;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use App\Models\Assignment;

class OrdersController extends Controller
{
    public function index()
    {
        return view('backend.orders.index');
    }

    public function getOrders(Request $request)
    {
        return \response()->json([
            'orders'=>Order::has('PaypalTransaction')->where('status',request('status'))->get()
        ]);
    }

    public function newOrder()
    {
        return view('backend.orders.new')->withDisciplines(Discipline::all())->withEducations(EducationLevel::all())->withPapers(PaperType::all());
    }

    public function manualAssign(Request $request)
    {
        $as = Assignment::where([['order_id',request('par1')],['user_id',request('par2')]])->first();
        $order = Order::find(request('par1'));

        /*
         * invalidate all assignments
         */
        Assignment::where('order_id', '=', request('par1'))->update(['status' => 0]);

        if($as == null){
            $as = new Assignment();
            $as->id = Uuid::generate();
            $as->order_id = request('par1');
            $as->user_id = request('par2');
            $as->status = 1;
            $as->Save();

        }else{
            $as->status =1;
            $as->save();
        }

        $order->active_assignment=$as->id;
        $order->status = 1;
        $order->save();


        $message='Order '.$order->order_no.  ' has been assigned to you. Please log in to your account as soon as possible. Regards Admin';
        $user = User::find(request('par2'));
        $user->notify(new OrderAssignment($message));

        //send sms and dispatch it
        //Log::warning((new \App\Plugins\AfricasTalking)->safeSend($user->phone_number,$message));

        return response()->json([
            'success'=>true
        ]);



    }

    public function store(Request $request)
    {

        $this->validate($request,[
            'title'=>'required',
            'no_pages'=>'required',
            'no_words'=>'required',
            'paper_type'=>'required',
            'discipline'=>'required',
            'education_level'=>'required',
            'spacing'=>'required',
            'no_of_sources'=>'required'
        ]);


        if ($request->has('id') && $request->id != null){
            $order = Order::find($request->id);
        }else{
            $order = new Order();
            $order->id = Uuid::generate()->string;
            $order->created_by=Auth::id();
        }

        $deadline = Carbon::createFromFormat("d/m/Y H:i:s", $request->deadline, request('tz'));
        $deadline->setTimezone('UTC');

        $bid_expiry = Carbon::createFromFormat("d/m/Y H:i:s", $request->bid_expiry, request('tz'));
        $bid_expiry->setTimezone('UTC');


        $discipline = Discipline::find($request->discipline);
        $base_salary = Group::find($discipline->group_id)->writer_price;


        $order->notes = $request->notes;
        $order->spacing = $request->spacing;
        $order->no_of_sources = $request->no_of_sources;
        $order->cpp = $request->cpp;
        $order->title = $request->title;
        $order->order_no = mt_rand(100000, 999999);
        $order->no_pages = $request->no_pages;
        $order->no_words = $request->no_words;
        $order->amount = $request->cpp*$request->no_pages;
        $order->salary = $base_salary*$request->no_pages;
        $order->order_assign_type = $request->order_assign_type;


        //make the writers deadline to be half of the client deadline
        $writer_hours=$deadline->diffInHours(Carbon::now())/2;
        $writer_deadline=Carbon::now()->addHours($writer_hours);

        $order->writer_deadline = $writer_deadline;
        $order->deadline = $deadline;
        $order->bid_expiry = $bid_expiry;
        $order->paper_type = $request->paper_type;
        $order->discipline = $request->discipline;
        $order->education_level = $request->education_level;
        $order->type_of_service = $request->type_of_service;
        $order->writer_quality = $request->writer_quality;
        $order->save();


        /*
         * create or update a paypal transaction with this order id
         */

        PaypalTransaction::updateOrCreate(
            ['order_id' => $order->id],
            ['id'=>Uuid::generate()->string,'amount' => $order->amount, 'pay_pal_name' => 'USD','pay_pal_ref'=>'System','status'=>1]
        );


        return Redirect::route('admin.orders.index');
    }

    public function deleteOrder(Order $order)
    {
        try {
            $order->delete();
        } catch (\Exception $e) {
        }

        return back();
    }

    public function editOrder(Order $order)
    {

        Session::flash('_old_input', $order);
        return View('backend.orders.new')->withDisciplines(Discipline::all())->withEducations(EducationLevel::all())->withPapers(PaperType::all());;
    }

    public function viewOrder(Order $order)
    {
        return view('backend.orders.view')->withOrder($order);
    }

    public function getChatData(Order $order)
    {
        return \response()->json([
            'assignments'=>$order->assignedWriters
        ]);
    }

    public function getChatMessages(Order $order,Request $request)
    {
        if($request->has('mode')){
            if($request->input('mode')==0){
                /*
                 * this is a writers conversation
                 * get the current assignment user in the order and thats the relevant conversation return null else
                 */
                $assignment = $order->currentAssignment();
                if($assignment==null){
                    return \response()->json([
                        'conversation'=>null,
                        'messages'=>[],
                        'conversation_user'=>null
                    ]);
                }
                $conversation = Conversation::firstOrCreate(['user_id' => $assignment->user_id,'order_id'=>$order->id], ['id'=>Uuid::generate()->string,'user_id' => $assignment->user_id,'order_id'=>$order->id]);

                if($conversation->messages()->count()<=0){
                    $msg = ['id'=>Uuid::generate(),'conversation_id'=>$conversation->id,'message'=>'Admin started a conversation about this order'];
                    $msg['user_id'] = $assignment->user_id;
                    $msg['id'] = Uuid::generate()->string;
                    Message::create($msg);
                }


                return \response()->json([
                    'conversation'=>$conversation,
                    'messages'=>$conversation->messages()->orderBy('created_at','asc')->with('user')->get(),
                    'conversation_user'=>$conversation->user
                ]);


            }else{

                /*
                 * this is a client conversation request
                 * get the person who created the order and do shit with it
                 */

                $conversation = Conversation::firstOrCreate(['user_id' => $order->created_by,'order_id'=>$order->id], ['id'=>Uuid::generate()->string,'user_id' => $order->created_by,'order_id'=>$order->id]);

                if($conversation->messages()->count()<=0){
                    $msg = ['id'=>Uuid::generate(),'conversation_id'=>$conversation->id,'message'=>'Admin started a conversation about this order'];
                    $msg['user_id'] = $order->created_by;
                    $msg['id'] = Uuid::generate()->string;
                    Message::create($msg);
                }

                return \response()->json([
                    'conversation'=>$conversation,
                    'messages'=>$conversation->messages()->orderBy('created_at','asc')->with('user')->get(),
                    'conversation_user'=>$conversation->user
                ]);

            }

        }else if($request->has('user')){

            $conversation = Conversation::firstOrCreate(['user_id' => $request->input('user'),'order_id'=>$order->id], ['id'=>Uuid::generate()->string,'user_id' => $request->input('user'),'order_id'=>$order->id]);

            if($conversation->messages()->count()<=0){
                $msg = ['id'=>Uuid::generate(),'conversation_id'=>$conversation->id,'message'=>'Admin started a conversation about this order'];
                $msg['user_id'] = $request->input('user');
                $msg['id'] = Uuid::generate()->string;
                Message::create($msg);
            }

            return \response()->json([
                'conversation'=>$conversation,
                'messages'=>$conversation->messages()->orderBy('created_at','asc')->with('user')->get(),
                'conversation_user'=>$conversation->user
            ]);

        }else{
            return \response()->json([
                'messages'=>[],
                'conversation_user'=>null,
            ]);
        }
    }

    public function saveChatMessage(Order $order,Request $request)
    {
        $msg = $request->all();
        $msg['user_id'] = Auth::id();
        $msg['id'] = Uuid::generate()->string;
        $message = Message::create($msg);

        dispatch(new ThunderPushAsync($msg['conversation_id'],$event = ["event"=>"conversation",
            "data"=>null
        ]));

        $user_ids = Message::select('user_id')->where('conversation_id',$msg['conversation_id'])->distinct('user_id')->get()->toArray();
        $conversation_users = User::whereIn('id',Arr::pluck($user_ids,'user_id'))->get();
        Notification::send($conversation_users, new ChatNotification($message));

        return response()->json([
            'success'=>true
        ]);



    }

    public function orderReviews(Order $order)
    {
        return \response()->json(['reviews'=>$order->reviews()->with('user')->get()]);
    }

    public function sendEmail()
    {
        $email='admin@admin.com.';
        Mail::to(Auth::user())->send(new WriterEssayTest(Auth::user(),$email));
    }



    public function getOrderBids($order)
    {
        $bids=Bid::where('order_id',$order)->with(['order','user'])->get();
//        $bids=Bid::all();

        return \response()->json([
            'bids'=>$bids
        ]);
    }

    public function assignUserBid($order_id,$user_id)
    {

        $assignment = Assignment::where([['order_id',$order_id],['user_id',$user_id]])->first();
        Assignment::where('order_id', '=', $order_id)->update(['status' => 0]);

        // if as create the assignment
        if($assignment==null){
            $assignment=new Assignment();
            $assignment->id=Uuid::generate()->string;
            $assignment->order_id=$order_id;
            $assignment->user_id=$user_id;
            $assignment->status = 1;
            $assignment->save();
        }else{
            $assignment->status = 1;
            $assignment->save();
        }

        //assign the order the assignment id
        $order=Order::find($order_id);
        $order->active_assignment=$assignment->id;
        $order->status = 1;
        $order->save();


        $message='Order '.$order->order_no.  ' has been assigned to you. Please log in to your account as soon as possible. Regards Admin';
        $user = User::find($user_id);
        $user->notify(new OrderAssignment($message));

        return \redirect()->back();
    }


    public function bargains(Order $order)
    {
        return \response()->json($order->bargains);
    }

    public function saveBargain(Request $request,Order $order)
    {
        $bargain = $request->all();
        $bargain['order_id']=$order->id;
        Bargain::create($bargain);

        return \response()->json([
            'success'=>true
        ]);
    }

    public function deleteBargains(Bargain $bargain)
    {
        $bargain->delete();
        return back();
    }


    public function saveFile(Request $request,Order $order)
    {

        if($request->hasFile('file')) {
            if (!$request->file('file')->isValid()) {
                return redirect()->back()->withErrors(['error'=>'The picture is invalid']);
            } else {

                //save picture
                $image=Input::file('file');
                $filename=time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('uploads/files/order_files/');
                if(!File::exists($path)) {File::makeDirectory($path, $mode = 0777, true, true);}
                $image->move($path,$filename);

                $attachment=new Attachment();
                $attachment->id=Uuid::generate()->string;
                $attachment->file_name=$filename;
                $attachment->display_name=$request->display_name;
                $attachment->order_id=$order->id;
                $attachment->created_by=Auth::id();
                $attachment->save();

                return redirect()->back();
            }
        }else{
            return redirect()->back()->withErrors(['error'=>'The picture is absent']);

        }


    }

    public function verifyFile(Attachment $attachment)
    {
        $attachment->is_verified=true;
        $attachment->save();

        return \redirect()->back();
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

    public function review(Request $request)
    {

        //mark the order as finished
        $order=Order::find($request->order_id);
        $order->status=4;
        $order->save();
        $assignment = $order->currentAssignment();


        /*
         * create a review for the intended user and order
         */
        $review=new OrderReview();
        $review->id= Uuid::generate();
        $review->order_id=$request->order_id;
        $review->rating=$request->rating;
        $review->review=$request->review_data;
        $review->user_id=Auth::id();
        $review->rated_user = ($assignment!=null)?$assignment->user_id:null;
        $review->save();


        /*
         * update the writers rating
         */
        if($assignment!=null){
            $user = User::find($assignment->user_id);
            $new_rating = OrderReview::where('rated_user',$assignment->user_id)->average('rating');
            $user->ratings = $new_rating;
            $user->save();
        }

        return redirect()->back();

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

        //get the active assignment for the order
        $active_assignment=$order->currentAssignment();
        if ($active_assignment!=null){
            $user=User::find($active_assignment->user_id);
            $user->notify(new DisputedNotification('The order '. $order->order_no.' has been disputed with the following reason: '. $request->dispute_reason));
        }

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

    public function toggleAutoAssign($status)
    {
        if ($status==1){
            //init the job

            $this->dispatch(new WriterAssignerJob());
        }else{
            //stop the job
        }
    }

    public function reviseOrder(Request $request)
    {


        $deadline = Carbon::createFromFormat("d/m/Y H:i:s", $request->deadline, request('tz'));


        $deadline->setTimezone('UTC');


        $revision=new Revision();
        $revision->id=Uuid::generate()->string;
        $revision->reason=$request->revise_data;
        $revision->order_id=$request->order_id;
        $revision->deadline=$deadline;
        $revision->save();

        //change status of th order
        $order=Order::find($revision->order_id);
        $order->status=2;
        $order->save();

        //notify the writer
        //get the active assignment for the order
        $active_assignment=$order->currentAssignment();
        if ($active_assignment!=null){
            $user=User::find($active_assignment->user_id);
            $user->notify(new RevisedNotification('The order '. $order->order_no.' has to be revised'));
        }

        return \redirect()->back();
    }
}

