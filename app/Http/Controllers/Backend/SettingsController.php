<?php

namespace App\Http\Controllers\Backend;

use App\Models\FqdnConfiguration;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
}
