<?php

namespace App\Http\Controllers\Customer;

use App\Models\Attachment;
use App\Models\Conversation;
use App\Models\Discipline;
use App\Models\EducationLevel;
use App\Models\Group;
use App\Models\Message;
use App\Models\Order;
use App\Models\OrderReview;
use App\Models\PaperType;
use App\Models\Revision;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
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


    public function getOrders(Request $request)
    {
        $orders = Order::where('created_by',Auth::id())->with(['Discipline','Education','Paper'])->withCount('attachments')->orderBy('created_at','desc')->get();
        return response()->json([
            'orders'=>$orders
        ]);
    }

    public function fetchOrder($order)
    {
        $orders = Order::where('id',$order)->with(['Discipline','Education','Paper'])->withCount('attachments')->orderBy('created_at','desc')->first();

        return response()->json([
            'order'=>$orders,
            'files'=>Order::find($order)->attachments
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

        ;


        $order->notes = $request->instructions;
        $order->cpp = $cpp;
        $order->title = $request->topic;
        $order->order_no = mt_rand(100000, 999999);
        $order->no_pages = $request->number_of_pages;
        $order->no_words = $request->number_of_pages*275;
        $order->amount = $request->$cpp*$request->number_of_pages;
        $order->order_assign_type = 1;
        $order->deadline = $date;
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

        if (Auth::check()){

            return redirect()->route('customer.orders.list');

        }else{
            //redirect to login
            return redirect()->route('login');
        }

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
        return \response()->json([
            'conversation'=>$conversation,
            'messages'=>$conversation->messages()->with('user')->get(),
            'conversation_user'=>$conversation->user
        ]);

    }


    public function saveMessage(Request $request)
    {
        $msg = $request->all();
        $msg['user_id'] = Auth::id();
        $msg['id'] = Uuid::generate()->string;
        Message::create($msg);

        return \response()->json([
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
        $data=$request->only(['review','rating']);
        $data['id']=Uuid::generate()->string;
        $data['order_id']=$order->id;
        $data['user_id']=Auth::id();

        OrderReview::create($data);

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
}
