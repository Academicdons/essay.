<?php

namespace App\Http\Controllers\Backend;

use App\Jobs\AssignOrderMail;
use App\Jobs\SendSystemEmail;
use App\Jobs\ThunderPushAsync;
use App\Mail\OrderAssignmentMail;
use App\Mail\MessageMail;
use App\Mail\WriterEssayTest;
use App\Models\Attachment;
use App\Models\Bargain;
use App\Models\Bid;
use App\Models\Conversation;
use App\Models\Discipline;
use App\Models\EducationLevel;
use App\Models\Message;
use App\Models\Order;
use App\Models\PaperType;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
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
            'orders'=>Order::where('status',request('status'))->get()
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
        $email = new OrderAssignmentMail($user,$message);
        $this->dispatch(new SendSystemEmail($user->email,$email));

        //send sms and dispatch it
        //Log::warning((new \App\Plugins\AfricasTalking)->safeSend($user->phone_number,$message));

        return response()->json([
            'success'=>true
        ]);



    }

    public function store(Request $request)
    {


        if ($request->has('id') && $request->id != null){
            $order = Order::find($request->id);
        }else{
            $order = new Order();
            $order->id = Uuid::generate();
        }

        $deadline = Carbon::createFromFormat("d/m/Y H:i:s", $request->deadline, request('tz'));
        $deadline->setTimezone('UTC');

        $bid_expiry = Carbon::createFromFormat("d/m/Y H:i:s", $request->bid_expiry, request('tz'));
        $bid_expiry->setTimezone('UTC');



        $order->notes = $request->notes;
        $order->spacing = $request->spacing;
        $order->cpp = $request->cpp;
        $order->title = $request->title;
        $order->order_no = mt_rand(100000, 999999);
        $order->no_pages = $request->no_pages;
        $order->no_words = $request->no_words;
        $order->amount = $request->cpp*$request->no_pages;
        $order->salary = $request->spp*$request->no_pages;
        $order->order_assign_type = $request->order_assign_type;
        $order->deadline = $deadline;
        $order->bid_expiry = $bid_expiry;
        $order->paper_type = $request->paper_type;
        $order->discipline = $request->discipline;
        $order->education_level = $request->education_level;
        $order->type_of_service = $request->type_of_service;
        $order->writer_quality = $request->writer_quality;
        $order->save();

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
        return view('backend.orders.new');
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
                 * get the current assignment user in the order and thats the relevant conversation
                 */
                $assignment = $order->currentAssignment();
                $conversation = Conversation::firstOrCreate(['user_id' => $assignment->user_id,'order_id'=>$order->id], ['id'=>Uuid::generate()->string,'user_id' => $assignment->user_id,'order_id'=>$order->id]);
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
                return \response()->json([
                    'conversation'=>$conversation,
                    'messages'=>$conversation->messages()->orderBy('created_at','asc')->with('user')->get(),
                    'conversation_user'=>$conversation->user
                ]);

            }

        }else if($request->has('user')){

            $conversation = Conversation::firstOrCreate(['user_id' => $request->input('user'),'order_id'=>$order->id], ['id'=>Uuid::generate()->string,'user_id' => $request->input('user'),'order_id'=>$order->id]);
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
        Message::create($msg);

        dispatch(new ThunderPushAsync($msg['conversation_id'],$event = ["event"=>"conversation",
            "data"=>null
        ]));

        $message = $msg['message'];
        $user = User::find($msg['user_id']);
        $email = new MessageMail($user,$message);
        $this->dispatch(new SendSystemEmail($user->email,$email));

        return \response()->json([
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
        $email = new OrderAssignmentMail($user,$message);
        $this->dispatch(new SendSystemEmail($user->email,$email));

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
                $attachment->save();

                return redirect()->back();
            }
        }else{
            return redirect()->back()->withErrors(['error'=>'The picture is absent']);

        }


    }

}

