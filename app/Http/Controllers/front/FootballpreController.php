<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Football;
use App\Models\Footballpre;
use Carbon\Carbon;
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
        //
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
        $messages = [
        ];
        $validateData = $request->validate([
        ],$messages);
//        dd($request);
        $footballpre = new Footballpre();

        $footballpres =Footballpre::where('user_id',Auth::id())->where('answer',$request->answer)->exists();

        $football = Football::where('id',$request->football_id)->first();
        $footballdatetime = $football->date;
        $createTime= Carbon::parse("now");
        $result =( $footballdatetime == $createTime );

        if ($result == false){
            if ($footballpres){
                $msg = 'شما قبلا پیش بینی بازی را ثبت کردید امکان ثبت مجدد نیست' ;
                return redirect(route('profile'))->with('danger',$msg);
            }
            else
                $footballpre->answer = $request->input('answer');
            $footballpre->football_id = $request->input('football_id');
            $footballpre->user_id = Auth::user()->id;
            try{
                $footballpre->save();
            }catch (Exception $exception){
                return redirect(route('profile'))->with('warning',$exception->getCode());
            }
            $msg = 'پیش بینی شما ثبت شد' ;
            return redirect(route('profile'))->with('success',$msg);
        }
        else
        $msg = 'زمان ثبت پیش بینی این بازی به پایان رسیده است' ;
        return redirect(route('profile'))->with('danger',$msg);

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
