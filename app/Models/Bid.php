<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    //

    public function Order()
    {
        return $this->belongsTo(Order::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
