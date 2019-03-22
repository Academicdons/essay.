<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ThunderPushAsync;
use App\Models\Order;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    protected function authenticated(Request $request, $user)
    {
      $order_id=  $request->session()->get('order_id');

      if ($order_id!=null){
          $order=Order::find($order_id);
          $order->created_by=$user->id;
          $order->save();


          dispatch(new ThunderPushAsync($order->id,$event = ["event"=>"order",
              "data"=>null
          ]));

      }
     return redirect($this->redirectTo);

    }
}
