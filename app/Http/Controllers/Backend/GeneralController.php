<?php

namespace App\Http\Controllers\Backend;

use App\Models\Assignment;
use App\Models\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GeneralController extends Controller
{
    //

    public function suggestWriters()
    {
        return response()->json(User::select(['id','name','email'])->get());
    }

}
