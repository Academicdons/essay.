<?php

namespace App\Http\Controllers\Backend;

use App\Mail\AssignMail;
use App\Mail\EssyMail;
use App\Models\Conversation;
use App\Models\Discipline;
use App\Models\EducationLevel;
use App\Models\Message;
use App\Models\Order;
use App\Models\PaperType;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Webpatser\Uuid\Uuid;
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
        if($as == null){

            /*
             * update all other assignments to invalid
             */
            Assignment::where('order_id', '=', request('par1'))
                ->update(['status' => 1]);


            $as = new Assignment();
            $as->id = Uuid::generate();
            $as->order_id = request('par1');
            $as->user_id = request('par2');
            $as->Save();

            $order->active_assignment = $as->id;
            $order->save();
        }else{

            Assignment::where('order_id', '=', request('par1'))
                ->update(['status' => 1]);
            $as->status = 0;
            $order->active_assignment = $as->id;
            $order->save();

        }
            //send the user an email
//        Mail::to($request->user())->send(new OrderShipped($order));

        $userToSendEmail=User::find(request('par2'));
        Mail::to($userToSendEmail)->send(new AssignMail($userToSendEmail,$userToSendEmail->email));
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
                    'messages'=>$conversation->messages()->with('user')->get(),
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
                    'messages'=>$conversation->messages()->with('user')->get(),
                    'conversation_user'=>$conversation->user
                ]);

            }

        }else if($request->has('user')){

            $conversation = Conversation::firstOrCreate(['user_id' => $request->input('user'),'order_id'=>$order->id], ['id'=>Uuid::generate()->string,'user_id' => $request->input('user'),'order_id'=>$order->id]);
            return \response()->json([
                'conversation'=>$conversation,
                'messages'=>$conversation->messages()->with('user')->get(),
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
        Mail::to(Auth::user())->send(new EssyMail(Auth::user(),$email));
    }
}

