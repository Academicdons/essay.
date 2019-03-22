<?php

namespace App\Http\Controllers\Backend;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\MessageBag;
use Intervention\Image\Facades\Image;
use PHPUnit\Exception;

class UsersController extends Controller
{
    //

    public function users($type)
    {
        $users = User::where('user_type',$type)->get();
        return View::make('backend.users.index')->withUsers($users);
    }

    public function toggleStatus($status, User $user)
    {
        $user->account_status=$status;
        $user->save();
        return back();
    }

    public function editUser(User $user)
    {
        Session::flash('_old_input',$user);
        return View::make('backend.users.edit');
    }

    public function create()
    {
        return View::make('backend.users.edit');

    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required'
        ]);

        if($validator->fails()){
            return back()->withInput()->withErrors($validator);
        }

        if($request->has('id') && $request->input('id')!=null){
            $user = User::find(request('id'));
        }else{
            $user = new User();


        }

        //upload picture
        if($request->hasFile('avatar')) {
            if (!$request->file('avatar')->isValid()) {
                return back()->withErrors(new MessageBag(['avatar'=>'The file uploaded is invalid']));
            } else {

//                $user=Auth::User();
                $image=Input::file('avatar');
                $filename=time() . '.' . $image->getClientOriginalExtension();
                $path = public_path('uploads/user_pictures/');
                if(!File::exists($path)) {File::makeDirectory($path, $mode = 0777, true, true);}
                Image::make($image->getRealPath())->fit(500,500)->save($path . $filename);
                try{
                    File::Delete($path . $user->avatar);
                }catch (Exception $h){
                }

                $user->avatar=$filename;
//                $user->Save();

//                return back();

                $user->name = request('name');
                $user->email = request('email');
                $user->user_type = request('user_type');
                $user->phone_number = request('phone_number');

                if ($request->has('password')){
                    $user->password = request('password');

                }
                $user->save();

                return redirect()->route('admin.users.all',$user->user_type);
            }


        }else{

            $user->name = request('name');
            $user->email = request('email');
            $user->user_type = request('user_type');
            $user->phone_number = request('phone_number');

            if ($request->has('password')){
                $user->password = bcrypt(request('password'));

            }
            $user->save();
            return redirect()->back();

        }


    }
}
