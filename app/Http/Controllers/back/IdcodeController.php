<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Idcode;
use Exception;
use Illuminate\Http\Request;

class IdcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $idcodes = Idcode::orderBy('created_at','desc')->paginate(50);
        return view('back.idcodes.idcodes',compact('idcodes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.idcodes.create');
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
            'idcode.required' => ' لطفا فیلد کد معرف را وارد نمایید',
            'numbercoin.required' => ' لطفا فیلد تعداد یابانه کوین را وارد نمایید',

        ];
        $validateData = $request->validate([
            'idcode' => 'required',
            'numbercoin' => 'required',
        ],$messages);

        $idcode = new Idcode();

        $idcode->idcode = $request->input('idcode');
        $idcode->numbercoin = $request->input('numbercoin');

        try{
            $idcode->save();
        }catch (Exception $exception){
            return redirect(route('back.idcodes.create'))->with('warning',$exception->getCode());
        }
        $msg = ' کد معرف جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.idcodes'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Idcode  $idcode
     * @return \Illuminate\Http\Response
     */
    public function show(Idcode $idcode)
    {
        return view('back.idcodes.show',compact('idcode'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Idcode  $idcode
     * @return \Illuminate\Http\Response
     */
    public function edit(Idcode $idcode)
    {
        return view('back.idcodes.edit',compact('idcode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Idcode  $idcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Idcode $idcode)
    {
        $messages = [
            'idcode.required' => ' لطفا فیلد کد معرف را وارد نمایید',
            'numbercoin.required' => ' لطفا فیلد تعداد یابانه کوین را وارد نمایید',
        ];
        $validateData = $request->validate([
            'idcode' => 'required',
            'numbercoin' => 'required',
        ],$messages);


        $idcode->idcode = $request->input('idcode');
        $idcode->numbercoin = $request->input('numbercoin');

        try{
            $idcode->update();
        }catch (Exception $exception){
            return redirect(route('back.idcodes.edit'))->with('warning',$exception->getCode());
        }
        $msg = ' کد معرف با موفقیت ویرایش شد :)' ;
        return redirect(route('back.idcodes'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Idcode  $idcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Idcode $idcode)
    {
        try{
            $idcode->delete();
        }catch (Exception $exception){
            return redirect(route('back.idcodes'))->with('warning',$exception->getCode());
        }
        $msg = 'کد معرف مورد نظر حذف گردید :)' ;
        return redirect(route('back.idcodes'))->with('success',$msg);
    }
}
