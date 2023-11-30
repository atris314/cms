<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Emailmarketing;
use App\Mail\Emailmarke;
use App\Models\Photo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailmarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $emailmarketings = Emailmarketing::orderBy('created_at','desc')->paginate(30);
        return view('back.emailmarketings.emailmarketings',compact('emailmarketings'));
    }
    public function sent(Emailmarketing $emailmarketing)
    {

        $address =$emailmarketing->emailaddress;
        $emailaddress=explode("|",$address);
        $photo_id = $emailmarketing->photo_id;
        $photo = Photo::where('id',$photo_id)->pluck('path')->first();
        for($i=0; $i<count($emailaddress); $i++){
            Mail::to(['farinaz.haghighi314@gmail.com',$emailaddress[$i]])
                ->send(new Emailmarke($emailmarketing,$photo));
        }
        $msg = 'ایمیل تبلیغاتی مورد نظر؛ به کاربرانی که ایمیل آنها را در قسمت آدرس ثبت کرده بودید، با موفقیت ارسال شد' ;
        return redirect(route('back.emailmarketings'))->with('info',$msg);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.emailmarketings.create');
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
            'subject.required' => ' لطفا فیلد موضوع ایمیل را وارد نمایید',
            'fromname.required' => ' لطفا فیلد نام ارسال کننده را وارد نمایید',
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'emailaddress.required' => ' لطفا فیلد آدرس ایمیل را وارد نمایید',
            'body.required' => ' لطفا فیلد متن ایمیل را وارد نمایید',
            'photo_id.required' => ' لطفا تصویر شاخص را وارد نماييد',

        ];
        $validateData = $request->validate([
            'subject' => 'required',
            'fromname' => 'required',
            'title' => 'required',
            'emailaddress' => 'required',
            'body' => 'required',
            'photo_id' => 'required',
        ],$messages);


        $emailmarketing = new Emailmarketing();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $emailmarketing->photo_id = $photo->id;
        }
        $emailmarketing->subject = $request->input('subject');
        $emailmarketing->fromname = $request->input('fromname');
        $emailmarketing->title = $request->input('title');
        $emailmarketing->emailaddress = $request->input('emailaddress');
        $emailmarketing->body = $request->input('body');

        try{
            $emailmarketing->save();
        }catch (Exception $exception){
            return redirect(route('back.emailmarketings.create'))->with('warning',$exception->getCode());
        }
        $msg = 'ایمیل تبلیغاتی با موفقیت ثبت شد با کلیک بر روی دکمه *ارسال* ایمیل تبلیغاتی ارسال خواهد شد' ;
        return redirect(route('back.emailmarketings'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Emailmarketing  $emailmarketing
     * @return \Illuminate\Http\Response
     */
    public function show(Emailmarketing $emailmarketing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Emailmarketing  $emailmarketing
     * @return \Illuminate\Http\Response
     */
    public function edit(Emailmarketing $emailmarketing)
    {
        return view('back.emailmarketings.edit',compact('emailmarketing'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Emailmarketing  $emailmarketing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Emailmarketing $emailmarketing)
    {
        $messages = [
            'subject.required' => ' لطفا فیلد موضوع ایمیل را وارد نمایید',
            'fromname.required' => ' لطفا فیلد نام ارسال کننده را وارد نمایید',
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'emailaddress.required' => ' لطفا فیلد آدرس ایمیل را وارد نمایید',
            'body.required' => ' لطفا فیلد متن ایمیل را وارد نمایید',
        ];
        $validateData = $request->validate([
            'subject' => 'required',
            'fromname' => 'required',
            'title' => 'required',
            'emailaddress' => 'required',
            'body' => 'required',
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
            $emailmarketing->photo_id = $photo->id;
        }
        $emailmarketing->subject = $request->input('subject');
        $emailmarketing->fromname = $request->input('fromname');
        $emailmarketing->title = $request->input('title');
        $emailmarketing->emailaddress = $request->input('emailaddress');
        $emailmarketing->body = $request->input('body');

        try{
            $emailmarketing->update();
        }catch (Exception $exception){
            return redirect(route('back.emailmarketings.edit',$emailmarketing->id))->with('warning',$exception->getCode());
        }
        $msg = 'ایمیل تبلیغاتی با موفقیت ویرایش شد با کلیک بر روی دکمه *ارسال* ایمیل تبلیغاتی ارسال خواهد شد' ;
        return redirect(route('back.emailmarketings'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Emailmarketing  $emailmarketing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Emailmarketing $emailmarketing)
    {
        try{
            $emailmarketing->delete();
        }catch (Exception $exception){
            return redirect(route('back.emailmarketings'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.emailmarketings'))->with('success',$msg);
    }
}
