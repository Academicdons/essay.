<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    //
    public $incrementing = false;

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
