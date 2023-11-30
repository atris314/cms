<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Resid;
use Exception;
use Illuminate\Http\Request;

class ResidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resids = Resid::with('product')->orderBy('created_at','desc')->paginate(30);
//        dd($resids);
        return view('back.resids.resids',compact('resids'));
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
     * @param  \App\Models\Resid  $resid
     * @return \Illuminate\Http\Response
     */
    public function show(Resid $resid)
    {
        return view('back.resids.show',compact('resid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resid  $resid
     * @return \Illuminate\Http\Response
     */
    public function edit(Resid $resid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resid  $resid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resid $resid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resid  $resid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resid $resid)
    {
        try{
            $resid->delete();
        }catch (Exception $exception){
            return redirect(route('back.resids'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.resids'))->with('success',$msg);
    }
}
