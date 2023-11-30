<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Cancel;
use Exception;
use Illuminate\Http\Request;

class CancelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cancels = Cancel::orderBy('created_at','desc')->paginate(20);
        return view('back.cancels.cancels',compact('cancels'));
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
     * @param  \App\Models\Cancel  $cancel
     * @return \Illuminate\Http\Response
     */
    public function show(Cancel $cancel)
    {
        return view('back.cancels.show',compact('cancel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cancel  $cancel
     * @return \Illuminate\Http\Response
     */
    public function edit(Cancel $cancel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cancel  $cancel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cancel $cancel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cancel  $cancel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cancel $cancel)
    {
        try{
            $cancel->delete();
        }catch (Exception $exception){
            return redirect(route('back.cancels'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.cancels'))->with('success',$msg);
    }
}
