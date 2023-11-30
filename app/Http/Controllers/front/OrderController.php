<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd('ok');
        $user =Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        $order = Order::all()->pluck('product_id');
        $product= Product::whereIn('id',$order)->first();
//        dd($product);
        return view('front.dashboard.productshow',compact('user','productcount','product'));
    }
    public function result()
    {
        $user =Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        $order = Order::all()->pluck('product_id');
        $product= Product::whereIn('id',$order)->first();
//        dd($product);
        return view('front.dashboard.purchase.result',compact('user','productcount','product'));
    }

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
    public function store(Request $request,Product $product)
    {

        $user =Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        $order = new Order();
        $order->user_id = $user->id;
        $order->product_id = $product->id;
        $order->amount = $product->totalamount;
        $order->status = '1';
//        dd($order);
        try{
            $order->save();
        }catch (Exception $exception){
            return back()->with('warning',$exception->getCode());
        }
        $msg = 'فاکتور با موفقیت صادر شد می توانید نسبت به پرداخت فاکتور اقدام نمایید.' ;
        return redirect()->route('product.orderPage',compact($product))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
