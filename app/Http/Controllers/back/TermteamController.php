<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Termpro;
use App\Models\Termteam;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TermteamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $termteams = Termteam::orderBy('id','DESC')->paginate(20);
        return view('back.termteams.termteams',compact('termteams'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.termteams.create');
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
            'body.required' => 'لطفا شرایط و قوانین را وارد نمایید',
        ];
        $validateData = $request->validate([
            'body' => 'required',
        ],$messages);

        $termteams = new Termteam([
            'title'     => $request->input('title'),
            'body'  => $request->input('body'),
        ]);
        //dd($emails);
        try{
            $termteams->save();
        }catch (Exception $exception){
            return redirect(route('back.termteams.create'))->with('warning',$exception->getCode());
        }
        $msg = 'شرایط و قوانین با موفقیت ایجاد شد :)' ;
        return redirect(route('back.termteams'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Termteam  $termteam
     * @return \Illuminate\Http\Response
     */
    public function show(Termteam $termteam)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Termteam  $termteam
     * @return \Illuminate\Http\Response
     */
    public function edit(Termteam $termteam)
    {
        return view('back.termteams.edit',compact('termteam'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Termteam  $termteam
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Termteam $termteam)
    {
        $messages = [
            'body.required' => 'لطفا شرایط و قوانین را وارد نمایید',
        ];
        $validateData = $request->validate([
            'body' => 'required',
        ],$messages);

        $termteam->title = $request->input('title');
        $termteam->body = $request->input('body');
        //dd($emails);
        try{
            $termteam->save();
        }catch (Exception $exception){
            return redirect(route('back.termteams.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'شرایط و قوانین با موفقیت ویرایش شد :)' ;
        return redirect(route('back.termteams'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Termteam  $termteam
     * @return \Illuminate\Http\Response
     */
    public function destroy(Termteam $termteam)
    {
        if (Gate::allows('isAdmin')){
            try{
                $termteam->delete();
            }catch (Exception $exception){
                return redirect(route('back.termteams'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.termteams'))->with('success',$msg);
        }
        else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد.' ;
            return back()->with('info',$msg);
        }
    }
}
