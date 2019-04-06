<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('backend.dashboard');
    }

    public function discipline()
    {
        return view('backend.discipline.index');
    }

    public function educationLevel()
    {
        return view('backend.education_level.index');
    }

    public function paperType()
    {
        return view('backend.paper_type.index');
    }

    public function getClientsJson(Request $request)
    {
        if($request->input('start')==0){
            $start=Carbon::now();
            $stop=Carbon::now()->subMonth(2);
        }else{
            $start=Carbon::createFromFormat('Y-m-d H',$request->input('stop'));
            $stop=Carbon::createFromFormat('Y-m-d H',$request->input('start'));
        }

        $data=[];
        for($stop;$stop<$start;$stop->addDay()){
            $x=clone $stop;
            $xx=clone $stop;
            $data[]=array('date'=>$xx->format('Y-m-d'),'clients'=>User::where('user_type','2')->where([['created_at','<',$x->addDay()->toDateTimeString()]])->count());
        }

        return json_encode($data);
    }

    public function getWritersJson(Request $request)
    {

        if($request->input('start')==0){
            $start=Carbon::now();
            $stop=Carbon::now()->subMonth(1);
        }else{
            $start=Carbon::createFromFormat('Y-m-d H',$request->input('stop'));
            $stop=Carbon::createFromFormat('Y-m-d H',$request->input('start'));
        }

        $data=[];
        for($stop;$stop<$start;$stop->addDay()){
            $x=clone $stop;
            $xx=clone $stop;
            $data[]=array('date'=>$xx->format('Y-m-d'),'writers'=>User::where('user_type','1')->where([['created_at','<',$x->addDay()->toDateTimeString()]])->count());

        }

        return json_encode($data);
    }



    public function getOrdersSum(Request $request)
    {

        if($request->input('start')==0){
            $start=Carbon::now();
            $stop=Carbon::now()->subMonth(1);
        }else{
            $start=Carbon::createFromFormat('Y-m-d H',$request->input('stop'));
            $stop=Carbon::createFromFormat('Y-m-d H',$request->input('start'));
        }

        $data=[];
        for($stop;$stop<$start;$stop->addDay()){
            $x=clone $stop;
            $xx=clone $stop;
            $data[]=array('date'=>$xx->format('Y-m-d'),'orders'=>Order::where([['created_at','<',$x->addDay()->toDateTimeString()]])->sum('amount'));

        }

        return json_encode($data);
    }

    public function markNotAsRead()
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);

        return redirect()->back();
    }
}
