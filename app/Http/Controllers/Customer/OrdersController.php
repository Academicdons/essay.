<?php

namespace App\Http\Controllers\Customer;

use App\Models\Attachment;
use App\Models\Discipline;
use App\Models\EducationLevel;
use App\Models\Group;
use App\Models\Order;
use App\Models\PaperType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
        $order->created_by = Auth::id();
        $order->Save();

        Session::put('order_id',$order->id);

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

        return redirect()->route('customer.orders.list');

    }

    function getAmountInTime($hours) {

        if ($hours<20)
            return 1.25;
            else if ($hours<72)
                return 1;
            else
                return 0.75;
        }
}
