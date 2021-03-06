<?php

namespace App;

use App\Models\Assignment;
use App\Models\Order;
use App\Models\PaymentInformation;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'user_type','account_status','referral_value','referred_by','education_level','course','date_of_birth','full_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function assignments()
    {
        return $this->hasMany(Assignment::class,'user_id','id');
    }

    public function clientOrders()
    {
        return $this->hasMany(Order::class,'created_by','id');
    }

    public function paymentInformation()
    {
        return $this->hasOne(PaymentInformation::class,'user_id','id');
    }


}
