<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Product;
use App\Http\Controllers\Controller;
use App\Models\Confirmation;
use App\Models\Producttracking;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProducttrackingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        $confirmationset = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->first();
        $products = Product::where('user_id',$user->id)->pluck('id');
        $producttrackings = Producttracking::wherein('product_id',$products)->orderBy('created_at','DESC')->paginate(120);
        $producttrackingset = Producttracking::wherein('product_id',$products)->first();

        return view('front.dashboard.producttrackings-list',compact('producttrackings','producttrackingset','user','productcount','confirmationset'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Producttracking  $producttracking
     * @return \Illuminate\Http\Response
     */
    public function show(Producttracking $producttracking)
    {
//        dd($producttracking);
        $user = Auth::user();
        $productcount = Product::with('user')->with('message')
            ->where('user_id',$user->id)
            ->where('status','<>','15')->count();
        $confirmationset = Confirmation::whereHas('product', function ($q) use($user){
            $q->where('status','7')->where('user_id',$user->id);
        })->first();
        return view('front.dashboard.producttrackings',compact('producttracking','user','productcount','confirmationset'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Producttracking  $producttracking
     * @return \Illuminate\Http\Response
     */
    public function edit(Producttracking $producttracking)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Producttracking  $producttracking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Producttracking $producttracking)
    {

    }
}
