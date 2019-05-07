<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DisputedOrder extends Model
{
    //
    public function Order()
    {
        return $this->belongsTo(Order::class);
    }
}
