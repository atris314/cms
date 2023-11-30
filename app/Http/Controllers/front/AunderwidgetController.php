<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Aunderwidget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AunderwidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
     * @param  \App\Models\Aunderwidget  $aunderwidget
     * @return \Illuminate\Http\Response
     */
    public function show(Aunderwidget $aunderwidget)
    {
        return view('front.widgetdetail',compact('aunderwidget'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Aunderwidget  $aunderwidget
     * @return \Illuminate\Http\Response
     */
    public function edit(Aunderwidget $aunderwidget)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Aunderwidget  $aunderwidget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Aunderwidget $aunderwidget)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Aunderwidget  $aunderwidget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Aunderwidget $aunderwidget)
    {

    }
}
