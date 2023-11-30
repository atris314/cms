<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Presentresid;
use App\Models\Product;
use Dflydev\DotAccessData\Data;
use Exception;
use Illuminate\Http\Request;

class PresentresidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $presentresids = Presentresid::with('present')->orderBy('created_at','DESC')->paginate(20);
        //dd($presentresids);
        return view('back.presentresids.presentresids',compact('presentresids'));
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
     * @param  \App\Models\Presentresid  $presentresid
     * @return \Illuminate\Http\Response
     */
    public function show(Presentresid $presentresid)
    {

        return view('back.presentresids.show',compact('presentresid'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presentresid  $presentresid
     * @return \Illuminate\Http\Response
     */
    public function edit(Presentresid $presentresid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Presentresid  $presentresid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presentresid $presentresid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presentresid  $presentresid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presentresid $presentresid)
    {
        try{
            $presentresid->delete();
        }catch (Exception $exception){
            return redirect(route('back.presentresids'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.presentresids'))->with('success',$msg);
    }
}
