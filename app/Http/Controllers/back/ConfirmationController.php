<?php

namespace App\Http\Controllers\back;

use App\frontmodels\Product;
use App\frontmodels\User;
use App\Http\Controllers\Controller;
use App\Models\Confirmation;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConfirmationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $confirmations = Confirmation::with('product')->where('confirm','yes')->orderBy('created_at','desc')->paginate(30);
        return view('back.confirmations.confirmations',compact('confirmations'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Confirmation $confirmation)
    {
        return view('back.confirmations.show',compact('confirmation'));
    }

    public function edit(Confirmation $confirmation)
    {
        //
    }

    public function update(Request $request, Confirmation $confirmation)
    {

    }

    public function confirmPrint(Confirmation $confirmation)
    {
        return view('back.confirmations.confirmationprint',compact('confirmation'));
    }
    public function confirmPdf(Confirmation $confirmation)
    {
        return view('back.confirmations.pdf',compact('confirmation'));
    }
}
