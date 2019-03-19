<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GeneralController extends Controller
{
    //

    public function sessionFiles(Request $request)
    {
        $docs = Session::get('upload_files');
        $documents = Attachment::whereIn('id',$docs)->get();
        return response()->json($documents);
    }

    public function uploadOrderFiles()
    {
        
    }

    public function uploadOrderFilesMain()
    {
        
    }
    //TODO sms controller for Africa's talking
    /*public function sendSms()
        {
           Log::warning((new \App\Plugins\AfricasTalking)->safeSend('0705850774',"Hello,David"));

        }*/
}
