<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    //
    protected $guarded =[];

    public $incrementing = false;


    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class,'conversation_id');
    }
}
