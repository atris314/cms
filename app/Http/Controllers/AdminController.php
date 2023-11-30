<?php

namespace App\Http\Controllers;

use App\frontmodels\Post;
use App\Models\Admin;
use App\Models\Catalog;
use App\Models\Portfolio;
use App\Models\Photo;
use App\Models\Video;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('front.main-search');
    }
    public function searchmain(Request $request)
    {
        $query = $request->input('search');

        $posts = Post::where('title','like',"%".$query."%")->orwhere('description','like',"%".$query."%")->orwhere('meta_description','like',"%".$query."%")
            ->orwhere('meta_keywords','like',"%".$query."%")->get();
        $postcount = $posts->count();

        $portfolios = Portfolio::where('name','like',"%".$query."%")->orwhere('description','like',"%".$query."%")->orwhere('tag','like',"%".$query."%")->get();
        $portfoliocount = $portfolios->count();

        $catalogs = Catalog::where('title','like',"%".$query."%")->orwhere('body','like',"%".$query."%")->orwhere('description','like',"%".$query."%")->get();
        $catalogcount = $catalogs->count();

        $videos = Video::where('title','like',"%".$query."%")->get();
        $videocount = $videos->count();

//        dd($videos);
        return view('front.main-search',compact('posts','portfolios','postcount','portfoliocount','catalogs','catalogcount','videos','videocount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
