<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Addsource;
use App\Models\Catorder;
use Exception;
use Illuminate\Http\Request;

class AddsourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resources = Addsource::orderBy('created_at','desc')->paginate(120);
        return view('back.resources.resources',compact('resources'));
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Addsource  $addsource
     * @return \Illuminate\Http\Response
     */
    public function show(Addsource $addsource)
    {
        return view('back.resources.show',compact('addsource'));
    }

    public function resourcesprint(Addsource $addsource)
    {
        return view('back.resources.resourcesprint',compact('addsource'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Addsource  $addsource
     * @return \Illuminate\Http\Response
     */
    public function edit(Addsource $addsource)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Addsource  $addsource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Addsource $addsource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Addsource  $addsource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Addsource $addsource)
    {
        try{
            $addsource->delete();
        }catch (Exception $exception){
            return redirect(route('back.resources'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.resources'))->with('success',$msg);
    }
}
