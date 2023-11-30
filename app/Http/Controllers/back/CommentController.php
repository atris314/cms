<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('isAdmin')){
            $comments = Comment::with('post')->orderBy('id','DESC')->paginate(30);
            return view('back.comments.comments',compact('comments'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        if (Gate::allows('isAdmin')){
            return view('back.comments.edit',compact('comment'));
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $messages = [
            'description.required' => ' لطفا فیلد متن را وارد نمایید',
            'description.min' => 'عنوان نمی تواند کمتر از 10 کاراکتر باشد.',

        ];
        $validateData = $request->validate([
            'description' => 'required|min:10',
        ],$messages);


        try{
            $comment->update($request->all());
        }catch (Exception $exception){
            return redirect(route('back.comments.edit'))->with('warning',$exception->getCode());
        }

        $msg = 'ويرايش کامنت با موفقیت انجام شد ' ;
        return redirect(route('back.comments'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        if (Gate::allows('isAdmin')){
            try{
                $comment->delete();
            }catch (Exception $exception){
                return redirect(route('back.comments'))->with('warning',$exception->getCode());
            }
            $msg = 'كامنت كاربر مورد نظر حذف گردید :)' ;
            return redirect(route('back.comments'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر می تواند حذف انجام دهد' ;
            return back()->with('info',$msg);
        }
    }

    public function updatestatus(Comment $comment)
    {
        if (Gate::allows('isAdmin')){
            if ($comment->status==1)
            {
                $comment->status = 0;
            }else
            {
                $comment->status = 1;
            }
            $comment->save();
            $msg = "بروزرسانی با موفقیت انجام شد :)";
            return redirect(route('back.comments'))->with('success',$msg);
        }else{
            $msg = 'فقط مدیر به این بخش دسترسی دارد' ;
            return back()->with('info',$msg);
        }

    }
}
