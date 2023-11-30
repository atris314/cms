<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Presentaction;
use Illuminate\Http\Request;

class PresentPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $protransactions = Presentaction::orderBy('created_at','DESC')->paginate(30);
        return view('back.presentpurchases.presentpurchases',compact('protransactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Presentaction $presentaction)
    {
        //dd($presentaction);
        if ($presentaction->transaction_result){
            $receipt = $presentaction->transaction_result;
            $reference_id = $receipt->getReferenceId();
        }
        else {
            $receipt = null;
            $reference_id = null;
        }
        //dd($presentaction);
        return view('back.presentpurchases.show',compact('presentaction','receipt','reference_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
