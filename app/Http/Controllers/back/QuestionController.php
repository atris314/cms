<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::ORDERBY('created_at','desc')->paginate(120);
        return view('back.questions.questions',compact('questions'));
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
            'question.required' => 'لطفا متن پرسش خود را در کادر مربوطه بنویسید',
        ];
        $validateData = $request->validate([
            'question' => 'required',
        ],$messages);


        $question = new Question();
        $question->name = $request->input('name');
        $question->email = $request->input('email');
        $question->question = $request->input('question');

            Mail::to(['farinaz.haghighi314@gmail.com'])
                ->send(new \App\Mail\Question($question));
        try{
            $question->save();
        }
        catch (Exception $exception){
            return redirect()->back()->with('warning',$exception->getCode());
        }
        $msg = 'متشکرم ! سوال شما ثبت شد' ;
        return redirect()->back()->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        try{
            $question->delete();
        }catch (Exception $exception){
            return redirect(route('back.questions'))->with('warning',$exception->getCode());
        }
        $msg = 'آیتم مورد نظر حذف گردید :)' ;
        return redirect(route('back.questions'))->with('success',$msg);
    }
}
