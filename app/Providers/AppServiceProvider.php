<?php

namespace App\Providers;

use App\frontmodels\Ad;
use App\frontmodels\Catorder;
use App\frontmodels\Coupon;
use App\frontmodels\Menu;
use App\frontmodels\Pack;
use App\frontmodels\Portfolio;
use App\frontmodels\Post;
use App\frontmodels\Slider;
use App\frontmodels\Teammate;
use App\Models\About;
use App\Models\Aboutlist;
use App\Models\Aunderwidget;
use App\Models\Bannerhome;
use App\Models\Catalog;
use App\Models\Catslider;
use App\Models\Client;
use App\Models\Cta;
use App\Models\Customer;
use App\Models\Gallery;
use App\Models\Role;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slideshow;
use App\Models\User;
use App\Models\Video;
use App\Notifications\Couponsent;
use Ghasedak\GhasedakApi;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Notification;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\schema;
use mysql_xdevapi\Exception;
use phpDocumentor\Reflection\DocBlock\Tag;
use Illuminate\Auth\Access\Response;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\OrderRepositoryInterface',
            'App\Repositories\OrderRepository');
    }

    /**
     * Bootstrap any application services.
     *
     * @param GateConstract $gate
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
//        Blade::directive('profilecheck', function () {
//            $isAuth = false;
//
//            // check if the user authenticated is teacher
//            if (auth()->check() && isset(auth()->user()->mobile) && isset(auth()->user()->phone) && isset(auth()->user()->address) && isset(auth()->user()->postcode)){
//
//                $isAuth = true;
//            }
//
/*            return "<?php if (" . intval($isAuth) . ") { ?>";*/
//        });
//
//        Blade::directive('endprofilecheck', function () {
/*            return "<?php } ?>";*/
//        });
//        if (Auth::user()){
//            $user = Auth::user();
//            $coupon = Coupon::where('title','اولین ثبت سفارش')->first();
////        Notification::send($user , new Couponsent($coupon));
//            $site = 'yabane.ir';
//            if (Auth::user()->mobile){
//                try{
//                    $receptor = $user->mobile;
//                    $type = 1;
//                    $template = "Couponsent";
//                    $param1 = $user->name;
//                    $param2 = $coupon->code;
//                    $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
//                    $api->Verify($receptor, $type, $template, $param1,$param2);
//                }
//                catch(\Ghasedak\Exceptions\ApiException $e){
//                    echo $e->errorMessage();
//                }
//                catch(\Ghasedak\Exceptions\HttpException $e){
//                    echo $e->errorMessage();
//                }
//            }
//        }


        Paginator::useBootstrap();

//        view::share('user', User::all());
//        view::share('teammate',Teammate::first());
//        view::share('sliders',Slider::orderBy('id','DESC')->first());
//        view::share('bannerhome',Bannerhome::orderBy('id','DESC')->first());
//        view::share('abouts',About::orderBy('id','DESC')->first());
//        view::share('settings',Setting::orderBy('id','DESC')->first());
//        view::share('aboutlists',Aboutlist::orderBy('id','DESC')->get());
//        view::share('aunderwidgets',Aunderwidget::orderBy('id','ASC')->get());
//        view::share('galleries',Gallery::orderBy('id','ASC')->get());
//        view::share('services',Service::orderBy('id','ASC')->get());
//        view::share('clients',Client::orderBy('id','ASC')->get());
//        view::share('ctas',Cta::orderBy('id','DESC')->first());
//        view::share('lastposts',Post::where('status',0)->orderBy('id','DESC')->paginate(3));
//        view::share('packs',Pack::orderBy('id','ASC')->paginate(3));
//        view::share('menus',Menu::orderBy('created_at','DESC')->where('status', 1)->get());
//        view::share('ads',Ad::orderBy('id','DESC')->paginate(2));
//        view::share('adset',Ad::first());
//        view::share('catorders',Catorder::orderBy('id','DESC')->where('status', 0)->get());
//        view::share('catorderslider',Catslider::orderBy('id','ASC')->get());
//        view::share('portfolio',Portfolio::orderBy('created_at','DESC')->paginate(8));
//        view::share('tags',Portfolio::all()->unique('tag'));
//        view::share('catalogs',Catalog::orderBy('created_at','DESC')->paginate(6));
//        view::share('customers',Customer::orderBy('created_at','DESC')->get());
//        view::share('slideshows',Slideshow::orderBy('created_at','DESC')->get());
//
//        view::share('portfoliocount',Portfolio::count());
//        view::share('videocount',Video::count());
//        view::share('catalogcount',Catalog::count());

//        View::composer(['front.main'], function($view)
//        {
//            $view->with('settings', Setting::orderBy('id','DESC')->first());
//        });
    }



}
