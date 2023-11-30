<?php

namespace App\Http\Controllers\back;

use App\frontmodels\Product;
use App\Http\Controllers\Controller;
use App\Models\Coin;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoinController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coins = Coin::orderBy('created_at','desc')->paginate(20);
        return view('back.coins.coins',compact('coins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.coins.create');
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
            'title.required' => ' لطفا فیلد عنوان را وارد نمایید',
            'photo_id.required' => ' لطفا تصویر شاخص را وارد نماييد',
        ];
        $validateData = $request->validate([
            'title' => 'required',
            'photo_id' => 'required',
        ],$messages);


        $coin = new Coin();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $coin->photo_id = $photo->id;
        }

        $coin->title = $request->input('title');
        $coin->boxone = $request->input('boxone');
        $coin->boxtwo = $request->input('boxtwo');

        try{
            $coin->save();
        }catch (Exception $exception){
            return redirect(route('back.coins.create'))->with('warning',$exception->getCode());
        }
        $msg = 'یابانه کوین با موفقیت ایجاد شد :)' ;
        return redirect(route('back.coins'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function show(Coin $coin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function edit(Coin $coin)
    {
        return view('back.coins.edit',compact('coin'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coin $coin)
    {
        $messages = [
            'title.required' => ' لطفا فیلد عنوان را وارد نمایید',
        ];
        $validateData = $request->validate([
            'title' => 'required',
        ],$messages);


        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $coin->photo_id = $photo->id;
        }

        $coin->title = $request->input('title');
        $coin->boxone = $request->input('boxone');
        $coin->boxtwo = $request->input('boxtwo');

        try{
            $coin->save();
        }catch (Exception $exception){
            return redirect(route('back.coins.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'یابانه کوین با موفقیت ویرایش شد :)' ;
        return redirect(route('back.coins'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coin  $coin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coin $coin)
    {
        try{
            $coin->delete();
        }catch (Exception $exception){
            return redirect(route('back.coins'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.coins'))->with('success',$msg);
    }

}
