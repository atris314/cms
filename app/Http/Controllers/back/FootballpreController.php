<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Footballpre;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FootballpreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $footballpres = Footballpre::orderby('created_at','desc')->paginate(30);
        return view('back.footballpres.footballpres',compact('footballpres'));
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
     * @param  \App\Models\Footballpre  $footballpre
     * @return \Illuminate\Http\Response
     */
    public function show(Footballpre $footballpre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Footballpre  $footballpre
     * @return \Illuminate\Http\Response
     */
    public function edit(Footballpre $footballpre)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Footballpre  $footballpre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Footballpre $footballpre)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Footballpre  $footballpre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Footballpre $footballpre)
    {
        //
    }
}
