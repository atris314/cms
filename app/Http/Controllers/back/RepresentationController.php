<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Mail\ProductStore;
use App\Mail\RepresentationConfirm;
use App\Models\Representation;
use App\Notifications\ProductAdd;
//use App\Notifications\RepresentationConfirm;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class RepresentationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $representations = Representation::orderBy('created_at','DESC')->paginate(30);
        return view('back.representations.representations',compact('representations'));
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
     * @param  \App\Models\Representation  $representation
     * @return \Illuminate\Http\Response
     */
    public function show(Representation $representation)
    {
        return view('back.representations.show',compact('representation'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Representation  $representation
     * @return \Illuminate\Http\Response
     */
    public function edit(Representation $representation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Representation  $representation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Representation $representation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Representation  $representation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Representation $representation)
    {
        try{
            $representation->delete();
        }catch (Exception $exception){
            return redirect(route('back.representations'))->with('warning',$exception->getCode());
        }
        $msg = 'درخواست كاربر مورد نظر حذف گردید :)' ;
        return redirect(route('back.representations'))->with('success',$msg);
    }

    public function updatestatus(Representation $representation)
    {
        if ($representation->status==1)
        {
            $representation->status = 0;
        }else
        {
            $representation->status = 1;
            Mail::to([$representation->email])
                ->send(new RepresentationConfirm($representation));
        }

        $representation->save();
        $msg = "بروزرسانی با موفقیت انجام شد :)";
        return redirect(route('back.representations'))->with('success',$msg);
    }
}
