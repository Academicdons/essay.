<?php

namespace App\Http\Controllers\Writer;

use App\Models\Discipline;
use App\Models\PaymentInformation;
use App\Models\UserDiscipline;
use App\User;
use http\Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
class ProfileController extends Controller
{
    //

    public function index()
    {
        $userDisciplines=UserDiscipline::where('user_id',Auth::id())->get()->pluck('discipline_id');
        return view('writer.profile.info')->withUser(Auth::user())->withDisciplines(Discipline::all())->withDis($userDisciplines);
    }

    public function payments()
    {
        Session::flash('_old_input',Auth::user()->paymentInformation);
        return view('writer.profile.payments')->withUser(Auth::user());

    }

    public function storePayments(Request $request)
    {
        PaymentInformation::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'mpesa_number' => request('mpesa_number'),
                'id_number' => request('id_number'),
                'mpesa_name' => request('mpesa_name'),
                'bank_name' => request('bank_name'),
                'account_number' => request('account_number'),
            ]
        );
        return back();
    }


    public function updateUser(Request $request)
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

        return redirect()->back();
    }

    public function updateUserProfile(Request $request)
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
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
    }

    public function markNotAsRead()
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);

        return redirect()->back();
    }
}
