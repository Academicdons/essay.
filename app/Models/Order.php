<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    public $incrementing = false;


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

}
