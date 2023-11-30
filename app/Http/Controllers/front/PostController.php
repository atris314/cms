<?php

namespace App\Http\Controllers\front;

use App\Events\PostViewEvent;
use App\frontmodels\Comment;
use App\Http\Controllers\Controller;
use App\frontmodels\Category;
use App\frontmodels\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $posts =Post::with('user' , 'categories','photo')->where('status',0)->orderBy('id','DESC')->paginate(10);
        //dd($posts);
        return view('front.posts',compact('posts','categories'));
    }

    public function show(Post $post)
    {

        $user = Auth::user();
        //$post = Post::with('user','categories','photo','comments')->first();
        event(new PostViewEvent($post));
        $comments = $post->comments()->where('status', 1)->get();
        $posts =Post::with('user' , 'categories','photo')->where('status',0)->orderBy('id','DESC')->paginate(10);
        //dd($comments);
        $categories = Category::all();
        return view('front.postdetail',compact('post','comments','categories','user','posts'));
    }

    public function searchTitle(Request $request )
    {
        $query = $request->input('title');
//        dd($query);
        $posts = Post::with('user','categories','post')
            ->where('title','like' , "%".$query."%")
            ->where('status',1)->paginate(3);
        $categories = Category::all();
        return view('front.search',compact('posts','categories','query'));
    }

    public function postshow($slug)
    {
        $user = Auth::user();
        $category = Category::where('slug' , $slug)->first();

        $posts =Post::with('categories')->whereHas('posts', function ($q) use ($category){
            $q->where('category_id', $category->id);
        })->paginate(20);

        $categories = Category::all();

        return view('front.posts',compact('user','category','posts','categories'));
    }

}
