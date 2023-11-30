<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Nextpayment;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function index()
    {
        $payments= Nextpayment::orderBy('created_at','DESC')->paginate(50);
//        dd($payments);
        return view('back.payments.payments',compact('payments'));
    }

    public function show(Payment $payment)
    {
//        dd($payment);
        return view('back.payments.show',compact('payment'));
    }
    public function paymentsprint(Payment $payment)
    {
        return view('back.payments.paymentprint',compact('payment'));
    }
}
