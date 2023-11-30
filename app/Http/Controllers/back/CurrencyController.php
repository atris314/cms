<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currencies = Currency::orderBY('created_at','desc')->paginate(30);
        return view('back.currencies.currencies',compact('currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.currencies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
        ];
        $validateData = $request->validate([
        ],$messages);
        $currency = new Currency();

        $currency->dollarf = $request->input('dollarf');
        $currency->yorof = $request->input('yorof');
        $currency->yoan = $request->input('yoan');
//        dd($currency);

        try{
            $currency->save();
        }catch (Exception $exception){
            return redirect(route('back.currencies.create'))->with('warning',$exception->getCode());
        }
        $msg = 'قیمت ارز لحظه ای ثبت شد' ;
        return redirect(route('back.currencies'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        return view('back.currencies.edit',compact('currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        $messages = [
        ];
        $validateData = $request->validate([
        ],$messages);

        $currency->dollarf = $request->input('dollarf');
        $currency->yorof = $request->input('yorof');
        $currency->yoan = $request->input('yoan');
//        dd($currency);

        try{
            $currency->update();
        }catch (Exception $exception){
            return redirect(route('back.currencies.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'قیمت ارز لحظه ای ثبت شد' ;
        return redirect(route('back.currencies'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        try{
            $currency->delete();
        }catch (Exception $exception){
            return redirect(route('back.currencies'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.currencies'))->with('success',$msg);
    }
}
