<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Comment;
use App\Http\Controllers\Controller;
use App\frontmodels\Post;
use App\Models\User;
use App\Notifications\CommentAdd;
use App\Notifications\ProductAdd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class CommentController extends Controller
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
    public function store(Request $request, Post $post)
    {
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'description' => 'required',
            recaptchaFieldName() => recaptchaRuleName()
        ]);

        $post->comments()->create([
            'name' => $request->name,
            'email'=>$request->email,
            'description'=>$request->description,
        ]);

        $users = User::whereHas('roles' , function($q){
            $q->where('role_id', '1' );
        })->get();
        Notification::send($users , new CommentAdd($request->title));

//        dd($request);
        $msg= ' نظر شما با موفقیت ثبت شد و پس از تایید مدیر سایت به نمایش داده می شود';
        return back()->with('success',$msg);
    }


//    public function reply(Post $post , Request $request)
//    {
//
//        $validateData = $request->validate([
//            'description' => 'required',
//        ]);
//
////
////        $reply = new Comment();
////        $reply->description = $request->get('description');
////        $reply->email = $request->get('email');
////        $reply->name = $request->get('name');
////        $reply->parent_id = $request->get('parent_id');
////        $post = Post::find($request->get('post_id'));
////
////        $post->comments()->save($reply);
////
////        $msg = "پاسخ به نظر كاربر توسط شما با موفقیت ثبت شد و پس از تایید مدیر سایت به نمایش داده می شود";
////        return back()->with('success', $msg);
//
//
////        $post->comments()->create([
////            'name' => $request->name,
////            'email'=>$request->email,
////            'description' => $request->description,
////            'user_id' => auth()->id(),
////            'parent_id' =>$request->parent_id,
////        ]);
////
////        $msg = "ذخیره ی منوی جدید با موفقیت انجام شد";
////        return back()->with('success', $msg);
//
////
//        $postId = $request->input('post_id');
//        $parentId = $request->input('parent_id');
//
//
//        if ($post){
//            $comments = new Comment();
//            $comments->description = $request->input('description');
//            $comments->email = $request->input('email');
//            $comments->name = $request->input('name');
//            $comments->parent_id = $parentId;
//            $comments->post_id = $post->id;
//            $comments->save();
//        }
//
//        $post->save();
//        $msg= ' پاسخ به نظر كاربر توسط شما با موفقیت ثبت شد و پس از تایید مدیر سایت به نمایش داده می شود';
//        return back()->with('success',$msg);
//
//    }

    public function replyStore(Request $request)
    {
        $postId = $request->input('post_id');
        $parentId = $request->input('parent_id');
        $post = Post::findOrFail($postId);
        if ($post) {
            $reply = new Comment();


            $reply->description = $request->input('description');
            $reply->email = Auth::user()->email;
            $reply->name = Auth::user()->name;
            $reply->status = 0;
            $reply->parent_id = $parentId;
            $post = Post::find($request->get('post_id'));
            $post->comments()->save($reply);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
