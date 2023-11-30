<?php

namespace App\Http\Controllers\front;


use App\Models\Photo;
use App\Models\Post;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Http\Request;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Exception;


class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Portfolio $portfolio
     * @return \Illuminate\Http\Response
     */
    public function index(Portfolio $portfolio)
    {
       //$portfolios = Portfolio::orderBy('id','DESC')->paginate(10);
       return view('front.portfolio-detail',compact('portfolio'));
    }

    public function portfolioAll()
    {
        $photo = Photo::first();
        $portfolios = Portfolio::orderby('created_at','DESC')->paginate(20);
        return view('front.portfolio-all',compact('portfolios'));
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Portfolio $portfolio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portfolio $portfolio)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio)
    {


    }
}
