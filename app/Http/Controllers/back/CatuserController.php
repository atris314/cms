<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Mail\Catagdownload;
use App\Models\Catalog;
use App\Models\Catuser;
use App\Models\Photo;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CatuserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catusers = Catuser::orderBy('created_at','desc')->paginate(30);
        return view('back.catusers.catusers',compact('catusers'));
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
     * @param  \App\Models\Catuser  $catuser
     * @return \Illuminate\Http\Response
     */
    public function show(Catuser $catuser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Catuser  $catuser
     * @return \Illuminate\Http\Response
     */
    public function edit(Catuser $catuser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Catuser  $catuser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catuser $catuser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Catuser  $catuser
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catuser $catuser)
    {
        try{
            $catuser->delete();
        }catch (Exception $exception){
            return redirect(route('back.catusers'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.catusers'))->with('success',$msg);
    }
}
