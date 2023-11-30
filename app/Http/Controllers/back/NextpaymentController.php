<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Nextpayment;
use App\Models\Order;
use App\Models\Ordernextpay;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Transaction;
use App\Repositories\OrderRepositoryInterface;
use Carbon\Carbon;
use Dflydev\DotAccessData\Data;
use Ghasedak\GhasedakApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Psr\Http\Message\ResponseInterface;
use Illuminate\Support\Facades\Http;

class NextpaymentController extends Controller
{
    public function index()
    {
        $nextpayments= Nextpayment::where('status',1)->orderBy('created_at','DESC')->paginate(50);
        return view('back.payments.payments',compact('nextpayments'));
    }
    public function show(Nextpayment $nextpayment)
    {
//        dd($nextpayment);
        return view('back.payments.show',compact('nextpayment'));
    }
    public function nextpaymentsprint(Nextpayment $nextpayment)
    {
//        dd($nextpayment);
        return view('back.payments.paymentprint',compact('nextpayment'));
    }
}
