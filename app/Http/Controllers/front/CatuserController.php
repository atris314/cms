<?php

namespace App\Http\Controllers\front;

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
            'email.required' => ' لطفا فیلد ایمیل را وارد نمایید',
        ];
        $validateData = $request->validate([
            'email' => 'required',
        ],$messages);


        $catuser = new Catuser();

        $catuser->email = $request->input('email');
        $catuser->mobile = $request->input('mobile');
        $catuser->catalog_id = $request->input('catalog_id');

        $catalog = Catalog::where('id',$catuser->catalog_id)->first();
        $catalogs = Catalog::where('catalogcat_id',$catalog->catalogcat_id)->orderBy('created_at','desc')->get();

        Mail::to([$catuser->email,'yabane.ir@gmail.com'])
            ->send(new Catagdownload($catalog));

        try{
            $catuser->save();
        }catch (Exception $exception){
            return redirect()->back()->with('warning',$exception->getCode());
        }
        $msg = 'لینک دانلود با موفقیت ایجاد شد و همچنین به آدرس ایمیل شما ارسال شد. با تشکر' ;
        return view('front.downloadcatalog',compact('catalog','catalogs'))->with('success',$msg);
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
        //
    }
}
