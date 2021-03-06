<?php

namespace App\Http\Controllers\Auth;

use App\Jobs\AssignOrderMail;
use App\Jobs\SendApproveEmailJob;
use App\Jobs\SendEssyMail;
use App\Jobs\SendSystemEmail;
use App\Mail\AccountCreatedMail;
use App\Mail\AccountCredentials;
use App\Mail\SuccessRegistrationMail;
use App\Mail\WriterEssayTest;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['required'],
            'user_type' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $account_status=1;
        if ($data['user_type']==1){
        $account_status=0;
        }

        /*
         * check the referring user
         */
        $referral = Session::get('referral');
        $refer_user = null;
        if($referral!=null){
            $refer_user = User::where('referral_value',$referral)->first();
        }

        /*
         * Generate a referral value for the new customer
         */
        $referral_code = $this->getUniqueReferalNo();



        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number' => $data['phone_number'],
            'user_type' => $data['user_type'],
            'account_status'=>$account_status,
            'referral_value'=>$referral_code,
            'referred_by'=>($refer_user!=null)?$refer_user->id:null
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        //send email notification here  to the writer only
        if($user->user_type==1){
            $email = new WriterEssayTest($user);
            $this->dispatch(new SendSystemEmail($user->email,$email));

        }elseif ($user->user_type==2){
            $message='Your account has successfully been created.';
            $email = new AccountCreatedMail($user,$message);
            $this->dispatch(new SendSystemEmail($user->email,$email));
        }

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    public function registerWriter(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone_number' => ['required'],
            'user_type' => ['required'],
            'education_level'=>'required',
            'course'=>'required',
            'date_of_birth'=>'required',
            'full_name'=>'required',
        ]);

        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }


         /*
         * check the referring user
         */
        $referral = Session::get('referral');
        $refer_user = null;
        if($referral!=null){
            $refer_user = User::where('referral_value',$referral)->first();
        }

        /*
         * Generate a referral value for the new customer
         */
        $referral_code = $this->getUniqueReferalNo();
        $data = $request->all();

        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone_number' => $data['phone_number'],
            'user_type' => $data['user_type'],
            'education_level' => $data['education_level'],
            'course' => $data['course'],
            'date_of_birth' => $data['date_of_birth'],
            'full_name' => $data['full_name'],
            'account_status'=>0,
            'referral_value'=>$referral_code,
            'referred_by'=>($refer_user!=null)?$refer_user->id:null
        ]);

        Auth::login($user);
        $email = new WriterEssayTest($user);
        $this->dispatch(new SendSystemEmail($user->email,$email));
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());

    }

    public function quickRegister(Request $request)
    {

        $validator= Validator::make($request->all(),[
            'customer_email'=>'required|unique:users,email|email',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        $parts = explode("@", $request->input('customer_email'));
        $username = $parts[0];
        $pin = $this->generatePIN();

        /*
         * check the referring user
         */
        $referral = Session::get('referral');
        $refer_user = null;
        if($referral!=null){
            $refer_user = User::where('referral_value',$referral)->first();
        }

        /*
         * Generate a referral value for the new customer
         */
        $referral_code = $this->getUniqueReferalNo();

        $user = new User();
        $user->name = $username;
        $user->email = $request->input('customer_email');
        $user->password= bcrypt($pin);
        $user->phone_number='';
        $user->user_type= 2;
        $user->account_status= 1;
        $user->referral_value = $referral_code;
        $user->referred_by = ($refer_user!=null)?$refer_user->id:null;
        $user->save();

        $message = "Your account password at homeworkprowriters is " . $pin;
        $email = new AccountCredentials($user,$message);
        $this->dispatch(new SendSystemEmail($user->email,$email));

        Auth::login($user);


        return redirect()->intended();


    }
    function generatePIN($digits = 4){
        $i = 0; //counter
        $pin = ""; //our default pin is blank.
        while($i < $digits){
            //generate a random number between 0 and 9.
            $pin .= mt_rand(0, 9);
            $i++;
        }
        return $pin;
    }


    public function getUniqueReferalNo()
    {
        $no = "HPR-" . $this->generatePIN();
        $validator = Validator::make(['referral_value'=>$no],['referral_value'=>'unique:users']);
        if($validator->fails()){
            return $this->getUniqueReferalNo();
        }else{
            return $no;
        }
    }


}
