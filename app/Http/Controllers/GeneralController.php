<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Blog;
use App\Models\EducationLevel;
use App\Models\Group;
use App\Models\Order;
use App\Plugins\Thunderpush;
use Dilab\Network\SimpleRequest;
use Dilab\Network\SimpleResponse;
use Dilab\Resumable;
use Exception;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Webpatser\Uuid\Uuid;
use GuzzleHttp\Client;

class GeneralController extends Controller
{
    //

    public function accountPending()
    {
        return View::make('auth.account_pending');

    }

    public function index()
    {
        $latest = Order::orderBy('created_at','desc')->has('Education')->limit(5)->get();

        /*
         * check subdomain
         */
        $domain = explode('.', \Request::getHost())[0];

        Log::warning($domain);
        if($domain == "writers"){
            return View::make('welcome_writer')->withOrders($latest);
        }

        return View::make('welcome')->withOrders($latest);
    }

    public function registerWriter()
    {
        return View::make('auth.register_writer');

    }

    public function paypalTest()
    {

        $thunder=new Thunderpush();
        $response = $thunder->notifyChannel("some chanel",$event = ["event"=>"order_file",
            "data"=>null
        ]);
        print_r($response);

//        dispatch(new ThunderPushAsync("some chanel",$event = ["event"=>"order_file",
//            "data"=>null
//        ]));


    }

    public function articles()
    {
        $order = Blog::orderBy('id','desc')->get();
        return View::make('customer.articles.all')->withArticles($order);

    }


    public function readArticle($title)
    {
        $article = Blog::where('title',$title)->first();
        return View::make('customer.articles.read')->withArticle($article);

    }

    public function sessionFiles(Request $request)
    {
        $docs = Session::get('upload_files');
        $documents = Attachment::whereIn('id',$docs)->get();
        return response()->json($documents);
    }

    public function getDisciplines(Group $group)
    {
        return response()->json(
            [   'disciplines'=>$group->disciplines,
                'group'=>$group
            ]);
    }

    public function getEdFactor(EducationLevel $level)
    {
        return $level->price_factor;
    }

    public function uploadOrderFiles(Request $lrequest)
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
            //save the file object
            $document = new Attachment();
            $document->id = Uuid::generate();
            $document->file_name = $filename;
            $document->display_name = $originalName;

            if($lrequest->has('order')){

                $document->order_id = $lrequest->input('order');
                $document->save();

            }else{
                $document->save();


                if (Session::get('upload_files') == null) {
                    $docs = collect([$document->id]);
                    Session::put('upload_files', $docs);
                } else {
                    Session::push('upload_files', $document->id);
                }
            }
        }
    }



    public function deleteSessionFile(Attachment $file)
    {

        $docs = Session::get('upload_files');
        $key = $docs->search(function($item) use ($file) {
            return $item == $file->id;
        });

        $docs->pull($key);
        $path =  public_path('uploads/order_files/');
        try{
            File::Delete($path . $file->file);
        }catch (Exception $h){
        }
        $file->delete();

        return back();
    }
    //TODO sms controller for Africa's talking
    public function sendSms()
        {
           Log::warning((new \App\Plugins\AfricasTalking)->safeSend('0705850774',"Hello,David"));

        }

    public function testThunder($key,$secretkey)
    {
        
        }
}
