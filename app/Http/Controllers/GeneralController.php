<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\EducationLevel;
use App\Models\Group;
use Dilab\Network\SimpleRequest;
use Dilab\Network\SimpleResponse;
use Dilab\Resumable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Webpatser\Uuid\Uuid;

class GeneralController extends Controller
{
    //

    public function paypalTest()
    {

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
}
