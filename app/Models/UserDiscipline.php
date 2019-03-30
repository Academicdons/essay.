<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserDiscipline extends Model
{
    //
    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Discipline()
    {
        return $this->belongsTo(Discipline::class);
    }
}
