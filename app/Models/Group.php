<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //

    public function disciplines()
    {
        return $this->hasMany(Discipline::class,'group_id','id');
    }
}
