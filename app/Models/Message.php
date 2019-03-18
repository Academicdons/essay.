<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    public $incrementing = false;
    protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
