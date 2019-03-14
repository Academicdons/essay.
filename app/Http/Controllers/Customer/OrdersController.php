<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class OrdersController extends Controller
{
    //

    public function create()
    {
        return View::make('customer.orders.create');
    }
}
