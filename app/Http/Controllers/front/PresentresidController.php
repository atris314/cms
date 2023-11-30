<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Photo;
use App\frontmodels\Present;
use App\frontmodels\Product;
use App\Http\Controllers\Controller;
use App\Models\Presentresid;
use App\Models\User;
use App\Notifications\ResidSent;
use Exception;
use Ghasedak\GhasedakApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class PresentresidController extends Controller
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

        $presentresid = new Presentresid();


        $presentresid->resid_code = $request->input('resid_code');
        $presentresid->user_id = Auth::user()->id;
        $presentresid->present_id = $request->input('present_id');

        $present = Present::where('id',$request->input('present_id'))->first();
        $product = Product::where('id',$present->product_id)->first();
        $photos = explode(',', $request->input('photos')[0]);

        $user = User::where('id',$presentresid->user_id)->first();
        $users = Auth::user();
//        $users->rate +=10;
        $users->update();

        if ($users = User::whereHas('roles' , function($q){
            $q->where('role_id', '1' );
        })->get()) {
            Notification::send($users, new ResidSent($presentresid->user_id));
        }

        $receptor = '09370068263';
        $type = 1;
        $template = "presentResidSent";
        $param1 = $user->code;
        $param2=$product->codepro;
        $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
        $api->Verify($receptor, $type, $template, $param1,$param2);
        try{
            if (isset($request->input('photos')[0])) {
                $product->photos()->sync($photos);
            }
            $presentresid->save();
        }catch (Exception $exception){
            return redirect()->back()->with('warning',$exception->getCode());
        }
        $msg = 'رسید پرداخت با موفقیت ارسال شد. متشکرم' ;
        return redirect()->back()->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Presentresid  $presentresid
     * @return \Illuminate\Http\Response
     */
    public function show(Presentresid $presentresid)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presentresid  $presentresid
     * @return \Illuminate\Http\Response
     */
    public function edit(Presentresid $presentresid)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Presentresid  $presentresid
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Presentresid $presentresid)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presentresid  $presentresid
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presentresid $presentresid)
    {
        //
    }
}
