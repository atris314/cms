<?php

namespace App\Http\Controllers\back;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Newsletter;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Notifications\Postsent;
use Exception;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\Notification;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with('photo')->OrderBy('id','DESC')->paginate(10);
        $user = Auth::user();

        return view('back.posts.posts',compact('posts'));


       // return view('back.posts.posts',compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::all();
        $categories = Category::all()->pluck('title','id');
        return view('back.posts.create',compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//       dd($request);
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'description.required' => ' لطفا فیلد توضیحات را وارد نمایید',
            'photo_id.required' => ' لطفا تصویر شاخص را وارد نماييد',
            'categories.required' => 'لطفا دسته بندی را  تعيين كنيد ',
            'status.required' => ' وضعیت مطلب نامشخص است',
        ];
        $validateData = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'photo_id' => 'required',
            'categories' => 'required',
            'status' => 'required',
        ],$messages);

        $post = new post();

        if ($file = $request->file('photo_id'))
        {
            $name = time().$file->getClientOriginalName();
            $files= $file->move(public_path('images'),$name);
            $photo = new Photo();
            $photo->name =$files;
            $photo->path = $name;
            $photo->user_id = Auth::id();
            $photo ->save();
            $post->photo_id = $photo->id;
        }

        if(empty($request->slug))
        {
            $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        }else
        {
            $slug = SlugService::createSlug(Post::class, 'slug', $request->slug);
        }
        $request->merge(['slug'=> $slug]);

        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->meta_description = $request->input('meta_description');
        $post->meta_keywords = $request->input('meta_keywords');
        $post->status = $request->input('status');
        $post->user_id = Auth::id();
        $post->count = 0;

        $user = Newsletter::all();
        Notification::send($user , new Postsent($post));

        try{
            $post->save();
            $post->categories()->attach($request->categories);
        }catch (Exception $exception){
            return redirect(route('back.posts.create'))->with('warning',$exception->getCode());
        }
        $msg = 'مطلب جدید با موفقیت ایجاد شد :)' ;
        return redirect(route('back.posts'))->with('success',$msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $role=Role::all();
        $categories = Category::all()->pluck('title','id');

        return view('back.posts.edit',compact('categories','post'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $messages = [
            'title.required' => ' لطفا فیلد نام را وارد نمایید',
            'title.min' => 'عنوان نمی تواند کمتر از 10 کاراکتر باشد.',
            'description.required' => ' لطفا فیلد توضیحات را وارد نمایید',
            'categories.required' => 'لطفا دسته بندی را  تعيين كنيد ',
            'status.required' => ' وضعیت مطلب نامشخص است',

        ];
        $validateData = $request->validate([
            'title' => 'required|min:10',
            'description' => 'required',
            'categories' => 'required',
            'status' => 'required',
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
            $post->photo_id = $photo->id;
        }

        if(empty($request->slug))
        {
            $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        }else
        {
            $slug = SlugService::createSlug(Post::class, 'slug', $request->slug);
        }
        $request->merge(['slug'=> $slug]);

//        if ($request->input('slug')){
//            $post->slug = str_slug($request->input('slug'));
//        }
//        else{
//            $post->slug = str_slug($request->input('title'));
//        }

        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->meta_description = $request->input('meta_description');
        $post->meta_keywords = $request->input('meta_keywords');
        $post->status = $request->input('status');
//        $post->slug = $slug;

//        dd($post);
        try{
            $post->update();
            $post->categories()->sync($request->categories);
        }catch (Exception $exception){
            return redirect(route('back.posts.edit'))->with('warning',$exception->getCode());
        }
        $msg = 'مطلب مورد نظر با موفقيت ويرايش شد :)' ;
        return redirect(route('back.posts'))->with('success',$msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
            try{
                $post->delete();
            }catch (Exception $exception){
                return redirect(route('back.posts'))->with('warning',$exception->getCode());
            }
            $msg = 'آیتم مورد نظر حذف گردید :)' ;
            return redirect(route('back.posts'))->with('success',$msg);
    }

    public function updatestatus(Post $post)
    {
        $role = Role::all();
            if ($post->status==1)
            {
                $post->status = 0;
            }else
            {
                $post->status = 1;
            }
            $post->save();
            $msg = "بروزرسانی با موفقیت انجام شد :)";
            return redirect(route('back.posts'))->with('success',$msg);

    }
}
