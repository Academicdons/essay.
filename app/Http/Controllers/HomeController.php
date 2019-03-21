<?php

namespace App\Http\Controllers;

use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profileView()
    {
        Session::flash('_old_input',Auth::user());

        return view('profile');
    }

    public function saveProfile(Request $request)
    {
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            'phone_number'=>'required',
            'password'=>'required|confirmed'
        ]);
        $user=Auth::user();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->phone_number=$request->phone_number;
        $user->password=bcrypt($request->password);
        $user->save();

        Session::flash('success','The details are successfully saved!');
        return redirect()->back();
    }

    public function updatePicture(Request $request)
    {
        $user=Auth::user();
        if($request->hasFile('user_pic')) {
            if (!$request->file('user_pic')->isValid()) {
                return redirect()->back()->withErrors(['error'=>'The picture is invalid']);
            } else {
                //save picture
                $image=Input::file('user_pic');
                $filename=time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('uploads/user_pictures/');
                if(!File::exists($path)) {File::makeDirectory($path, $mode = 0777, true, true);}
                Image::make($image->getRealPath())->fit(500,500)->save($path . $filename);
                try{
                    if ($user->avatar!='user.jpg')
                        File::Delete($path . $user->avatar);
                }catch (Exception $h){
                }
                $user->avatar=$filename;
                $user->save();
                Session::flash('success','The picture was successfully saved!');

                return redirect()->back();
            }
        }else{
            Session::flash('failure','Error updating image');

            return redirect()->back();
        }
    }
}
