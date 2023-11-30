<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Portfolio;
use App\Models\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $portfolios = Portfolio::count();
//        dd($portfolios);
        $portfoliocount = $portfolios->count();

        $catalogs = Catalog::get();
        $catalogcount = $catalogs->count();

        $videos = Video::get();
        $videocount = $videos->count();

        return view('front.main',compact('portfolios','portfoliocount','catalogs','catalogcount','videos','videocount'));
    }
}
