<?php

namespace App\Http\Controllers\back;

use App\frontmodels\Product;
use App\Http\Controllers\Controller;
use App\Models\Producttracking;
use Exception;
use Illuminate\Http\Request;

class ProducttrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producttrackings = Producttracking::orderBy('created_at','desc')->paginate(120);
        return view('back.producttrackings.producttrackings',compact('producttrackings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::all();
        return view('back.producttrackings.create',compact('products'));
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
            'productcode.required' => ' لطفا کد پیگیری سفارش را وارد نمایید',
            'trackcode.required' => 'لطفا کد پیگیری مرسوله را وارد نمایید',
        ];
        $validateData = $request->validate([
            'productcode' => 'required',
            'trackcode' => 'required',
        ],$messages);

        $producttracking = new Producttracking();

        $producttracking->productcode = $request->input('productcode');
        $producttracking->trackcode = $request->input('trackcode');
        $product = Product::where('codepro',$request->input('productcode'))->first();
        $producttracking->product_id = $product->id;
        try{
            $producttracking->save();
        }
        catch (Exception $exception){
            return redirect(route('back.producttrackings.create'))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! مرسوله ثبت شد.' ;
        return redirect(route('back.producttrackings'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producttracking  $producttracking
     * @return \Illuminate\Http\Response
     */
    public function show(Producttracking $producttracking)
    {
        return view('back.producttrackings.show',compact('producttracking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producttracking  $producttracking
     * @return \Illuminate\Http\Response
     */
    public function edit(Producttracking $producttracking)
    {
        $products = Product::all();
        return view('back.producttrackings.edit',compact('products','producttracking'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Producttracking  $producttracking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producttracking $producttracking)
    {
        $producttracking->productcode = $request->input('productcode');
        $producttracking->trackcode = $request->input('trackcode');
        try{
            $producttracking->update();
        }
        catch (Exception $exception){
            return redirect(route('back.producttrackings.edit',$producttracking->id))->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! مرسوله ویرایش شد.' ;
        return redirect(route('back.producttrackings'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producttracking  $producttracking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producttracking $producttracking)
    {
        try{
            $producttracking->delete();
        }catch (Exception $exception){
            return redirect(route('back.producttrackings'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.producttrackings'))->with('success',$msg);
    }
}
