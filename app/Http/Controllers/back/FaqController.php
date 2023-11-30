<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $faqs = Faq::orderBy('created_at','DESC')->paginate(120);
        return view('back.faqs.faqs',compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('back.faqs.create');
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
            'question.required' => ' لطفا فیلد پرسش را وارد نمایید',
            'answer.required' => ' لطفا فیلد پاسخ را وارد نمایید',
        ];
        $validateData = $request->validate([
            'question' => 'required',
            'answer' => 'required',
        ],$messages);

        $faq = new Faq();

        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');

        try{
            $faq->save();
        }catch (Exception $exception){
            return redirect(route('back.faqs.create'))->with('warning',$exception->getCode());
        }
        $msg = 'پرسش و پاسخ با موفقیت ایجاد شد ' ;
        return redirect(route('back.faqs'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(Faq $faq)
    {
        return view('back.faqs.edit',compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {

        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');

        try{
            $faq->update();
        }catch (Exception $exception){
            return redirect(route('back.faqs.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'پرسش و پاسخ با موفقیت ویرایش شد ' ;
        return redirect(route('back.faqs'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Faq  $faq
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faq $faq)
    {
        if(Gate::allows('isAdmin')){
            try{
                $faq->delete();
            }catch (Exception $exception){
                return redirect(route('back.faqs'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.faqs'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }
    }
}
