<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public $incrementing = false;
    protected $dates = ['deadline','bid_expiry'];


    public function conversations()
    {

    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class,'order_id','id');
    }


    public function currentAssignment()
    {
        return $this->assignments()->where('id',$this->active_assignment)->first();
    }

    public function assignedWriters()
    {
        return $this->hasManyThrough(User::class,Assignment::class,'order_id','id','id','user_id');
    }

    public function reviews()
    {
        return $this->hasMany(OrderReview::class,'order_id','id');
    }

    public function client()
    {
        return $this->hasOne(User::class,'id','created_by');
    }

    public function Discipline()
    {
        return $this->hasOne(Discipline::class,'id','discipline');
    }

    public function Education()
    {
        return $this->hasOne(EducationLevel::class,'id','education_level');
    }

    public function Paper()
    {
        return $this->hasOne(PaperType::class,'id','paper_type');

    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class,'order_id','id');

    }



    public function revision()
    {
        return $this->hasMany(Revision::class,'order_id','id');
    }

    public function Bid()
    {
        return $this->hasMany(Bid::class,'order_id','id');
    }

    public function bargains()
    {
        return $this->hasMany(Bargain::class,'order_id','id');
    }

    public function payment()
    {
        return $this->hasOne(PaymentTransaction::class,'order_id','id');
    }
}
