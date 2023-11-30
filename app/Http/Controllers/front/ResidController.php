<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Product;
use App\Http\Controllers\Controller;
use App\frontmodels\Photo;
use App\frontmodels\Resid;
use App\Notifications\ResidSent;
use App\Models\User;
use Exception;
use Ghasedak\GhasedakApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class ResidController extends Controller
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
    public function store(Request $request,Product $product)
    {

        $messages = [
            'photo_id.required' => ' لطفا تصویر شاخص را وارد نماييد',

        ];
        $validateData = $request->validate([
            'photo_id' => 'required|mimes:jpeg,jpg,png',
        ],$messages);


        $resid = new Resid();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $resid->photo_id = $photo->id;
        }

        $resid->resid_code = $request->input('resid_code');
        $resid->user_id = Auth::user()->id;
        $resid->product_id = $request->input('product_id');
        $product = Product::where('id',$request->input('product_id'))->first();
        $user = User::where('id',$resid->user_id)->first();
        $users = Auth::user();
        if ($users = User::whereHas('roles' , function($q){
            $q->where('role_id', '1' );
        })->get()) {
            Notification::send($users, new ResidSent($resid->user_id));
        }

            $receptor = '09331118943';
            $type = 1;
            $template = "ResiSent";
            $param1 = $user->code;
            $param2=$product->codepro;
            $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
            $api->Verify($receptor, $type, $template, $param1,$param2);

        try{
            $resid->save();
        }catch (Exception $exception){
            return redirect()->back()->with('warning',$exception->getCode());
        }
        $msg = 'رسید پرداخت با موفقیت ارسال شد. متشکرم' ;
        return redirect(route('oldproduct'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resid  $resid
     * @return \Illuminate\Http\Response
     */
    public function show(Resid $resid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resid  $resid
     * @return \Illuminate\Http\Response
     */
    public function edit(Resid $resid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resid  $resid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resid $resid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resid  $resid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resid $resid)
    {
        //
    }
}
