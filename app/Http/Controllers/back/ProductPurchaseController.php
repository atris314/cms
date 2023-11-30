<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ProductPurchaseController extends Controller
{

    public function index()
    {
        $transactions = Transaction::orderBy('created_at','DESC')->paginate(20);
        return view('back.productpurchases.productpurchases',compact('transactions'));
    }


    public function show(Transaction $transaction)
    {
        if ($transaction->transaction_result){
            $receipt = $transaction->transaction_result;
            $reference_id = $receipt->getReferenceId();
        }
        else {
            $receipt = null;
            $reference_id = null;
        }
        //dd($reference_id);
        return view('back.productpurchases.show',compact('transaction','receipt','reference_id'));
    }

    public function productPurchasesPrint(Transaction $transaction)
    {
        //dd($transaction);
        return view('back.productpurchases.productpurchasesprint',compact('transaction'));
    }
}
