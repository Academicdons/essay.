<?php

namespace App\Http\Controllers\Backend;

use App\Models\FqdnConfiguration;
use App\Models\SystemSettings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class SettingsController extends Controller
{
    //
    public function getAllDomains()
    {
        return view('backend.settings.domains');

    }

    public function saveDomain(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required',
            'tag_line'=>'required'
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        if($request->has('id') && $request->input('id')!=null){
            $domain = FqdnConfiguration::find(request('id'));
        }else{
            $domain = new FqdnConfiguration();
        }

        $domain->name = request('name');
        $domain->email = request('email');
        $domain->domain_type = request('domain_type');
        $domain->phone_number = request('phone_number');
        $domain->tag_line = request('tag_line');
        $domain->save();

        return back();
    }

    public function editDomain(FqdnConfiguration $domain)
    {
        Session::flash('_old_input',$domain);
        return back();
    }

    public function systemSettings()
    {
        $settings = SystemSettings::firstOrCreate(['auto_assign' => true]);
        Session::flash('_old_input',$settings);
        return View::make('backend.settings.system');
    }

    public function storeSystemSettings(Request $request)
    {
        $settings = SystemSettings::firstOrCreate(['auto_assign' => true]);
        $settings->auto_assign = $request->has('auto_assign');
        $settings->send_sms = $request->has('send_sms');

        $settings->save();

        return back();
    }
}
