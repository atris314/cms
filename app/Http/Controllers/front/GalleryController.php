<?php

namespace App\Http\Controllers\front;

use App\frontmodels\Post;
use App\Http\Controllers\Controller;
use App\Models\Catalog;
use App\Models\Gallery;
use App\Models\Photo;
use App\Models\Portfolio;
use App\Models\Video;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function gallerySearch(Request $request, Gallery $gallery)
    {
        $query = $gallery->title;
        $posts = Post::where('title','like',"%".$query."%")->orwhere('description','like',"%".$query."%")->orwhere('meta_description','like',"%".$query."%")
            ->orwhere('meta_keywords','like',"%".$query."%")->get();
        $postcount = $posts->count();

        $portfolios = Portfolio::where('name','like',"%".$query."%")->orwhere('description','like',"%".$query."%")->orwhere('tag','like',"%".$query."%")->get();
        $portfoliocount = $portfolios->count();

        $catalogs = Catalog::where('title','like',"%".$query."%")->orwhere('body','like',"%".$query."%")->orwhere('description','like',"%".$query."%")->get();
        $catalogcount = $catalogs->count();

        $videos = Video::where('title','like',"%".$query."%")->get();
        $videocount = $videos->count();

        return view('front.gallery-search',compact('gallery','posts','portfolios','postcount','portfoliocount','catalogs','catalogcount','videos','videocount'));
    }
}
