<?php

namespace App\Http\Controllers\Writer;

use App\Models\PaymentInformation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class PaymentsController extends Controller
{
    //

    public function info()
    {
        Session::flash('_old_input',Auth::user()->paymentInformation);

        return View::make('writer.payments.form');
    }

    public function store(Request $request)
    {

        PaymentInformation::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'mpesa_number' => request('mpesa_number'),
                'id_number' => request('id_number'),
                'mpesa_name' => request('mpesa_name'),
                'bank_name' => request('bank_name'),
                'account_number' => request('account_number'),
                ]
        );

        return back();

    }
}
