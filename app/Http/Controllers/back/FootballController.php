<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Football;
use App\Models\Footballpre;
use App\Models\User;
use App\Models\Userfootball;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FootballController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $footballs = Football::orderby('created_at','desc')->paginate(30);
        return view('back.footballs.footballs',compact('footballs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.footballs.create');
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


        $football = new Football();
        $football->teamname = $request->input('teamname');
        $football->time = $request->input('time');
        $football->date = $request->input('date');
        $football->status = $request->input('status');

        try{
            $football->save();
        }catch (Exception $exception){
            return redirect(route('back.footballs.create'))->with('warning',$exception->getCode());
        }
        $msg = ' بازی جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.footballs'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Football  $football
     * @return \Illuminate\Http\Response
     */
    public function show(Football $football)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Football  $football
     * @return \Illuminate\Http\Response
     */
    public function edit(Football $football)
    {
        return view('back.footballs.edit',compact('football'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Football  $football
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Football $football)
    {
        $messages = [
        ];
        $validateData = $request->validate([
        ],$messages);

        $football->teamname = $request->input('teamname');
        $football->time = $request->input('time');
        $football->date = $request->input('date');
        $football->status = $request->input('status');
        $football->gameresult = $request->input('gameresult');

        try{
            $football->save();
        }catch (Exception $exception){
            return redirect(route('back.footballs.edit',$football->id))->with('warning',$exception->getCode());
        }
        $msg = ' بازی جدید با موفقیت ویرایش شد :)' ;
        return redirect(route('back.footballs'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Football  $football
     * @return \Illuminate\Http\Response
     */
    public function destroy(Football $football)
    {
        try{
            $football->delete();
        }catch (Exception $exception){
            return redirect(route('back.footballs'))->with('warning',$exception->getCode());
        }
        $msg = 'این بازی از جدول حذف گردید :)' ;
        return redirect(route('back.footballs'))->with('success',$msg);
    }
    public function updatestatus(Football $football)
    {
        if ($football->status==1)
        {
            $football->status = 0;
        }else
        {
            $football->status = 1;
        }
        $football->save();
        $msg = "وضعیت بازی با موفقیت تغییر کرد";
        return redirect(route('back.footballs'))->with('success',$msg);

    }
    public function result(Football $football)
    {
        $footballpres = Footballpre::where('football_id',$football->id)->where('answer',$football->gameresult)->get();
        $coupon = Coupon::where('code','bronze-pre')->first();

        for ($i = 0; $i < count($footballpres); $i++) {
            $footballpresarray = $footballpres[$i];
            $user = $footballpresarray->user->id;
            $userfootball = new Userfootball();
            $userfootball->user_id = $user;
            $userfootball->football_id = $football->id;
            $userfootball->footballpre_id = $footballpres[$i]->id;
            $userfootball->score = 10;
            $userfootball->award = $coupon->code;
            $userfootball->save();
            dd($userfootball);
        }

    }
}
