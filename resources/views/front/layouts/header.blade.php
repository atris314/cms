<!-- ======= Top Bar ======= -->
{{--<div id="topbar" class="d-none d-lg-flex align-items-center fixed-top ">--}}
{{--    <div class="container-fluid pt-3 d-flex align-items-center justify-content-between">--}}

{{--        <div class="col-lg-3" >--}}
{{--            <a href="{{route('home')}}" class="logo mr-auto"><img src="{{asset('front/assets/img/-فارسی-راست چین سربرگnewcolor+new.png')}}" alt="logo" class="img-fluid"></a>--}}
{{--        </div>--}}
{{--        <div class="col-lg-6">--}}

{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<header id="header" class="fixed-top">
    <div class="container-fluid d-flex justify-content-center">

        <button type="button" class="mobile-nav-toggle d-lg-none"><i class="icofont-navigation-menu"></i></button>
        <!-- Uncomment below if you prefer to use an image logo -->
        <!-- <a href="index.html" class="logo mr-auto"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
        <div class="col-lg-3" >
            <a href="{{route('home')}}" class="logo mr-auto"><img src="{{asset('front/assets/img/-فارسی-راست چین سربرگnewcolor+new.png')}}" alt="logo" class="img-fluid"></a>
        </div>
        <nav class="nav-menu d-none d-lg-block col-lg-6">
            <img src="{{asset('front/assets/img/logo yabane fa bold-newcolor.png')}}" width="200" class="d-lg-none mobile-logo">
            <ul>
                @foreach($menus as $menu)
                    @if($menu['post_id']==0 && $menu['sort']==1)

                        <li  class="@if($menu->getChid->count()>0) drop-down  @endif">

                            <a href="{{$menu->url}}"><img src="{{$menu->photo->path}}" width="50" class="d-lg-none">{{$menu->title}}</a>
                            @if($menu->getChid->count()>0)
                                <ul>
                                    @foreach($menu->getChid as $submenu)
                                        @if($submenu->post_id!=0)
                                            <li class="@if($menu->getChidtow->count()>0) drop-down @endif"><a href="{{$submenu->url}}">{{$submenu->title}}</a>
                                                @if($submenu->getChidtow->count()!=0)
                                                    <ul>
                                                        @foreach($submenu->getChidtow as $sub)
                                                            <li><a href="{{$sub->url}}">{{$sub->title}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>

                            @endif
                        </li>
                    @endif
                @endforeach
            </ul>
            <div class="mobile-social-links d-lg-none mt-3">
                <a href="{{$settings->whatsapp}}" class="whatsapp"> <img src="{{asset('front/assets/img/whatsapp-icon-social.png')}}"> </a>
                <a href="{{$settings->telegram}}" class="telegram"> <img src="{{asset('front/assets/img/media+social+telegram+icon-.png')}}"> </a>
                <a href="{{$settings->instagram}}" class="instagram"> <img src="{{asset('front/assets/img/Instagram_logo.png')}}"> </a>
            </div>
        </nav><!-- .nav-menu -->
        <div class="col-lg-3">
            <div>
                @auth
                    <li style="display: inline-block" >
                        @can('isAdmin')
                            {{--                        <li style="display: inline-block">--}}
                            {{--                            <a class="header-access" href="{{route('admin')}}" target="_blank">--}}
                            {{--                                @if(Auth::user()->photo_id)--}}
                            {{--                                    <img class="img-profiles" src="{{Auth::user()->photo->path}}" alt=" پنل مدیریت :  {{Auth::user()->lastname}}"><i class="icofont-caret-down"></i>--}}
                            {{--                                @else--}}
                            {{--                                    پنل مدیریت--}}
                            {{--                                @endif--}}
                            {{--                            </a>--}}
                            {{--                        </li>--}}
                            <div class="dropdown">
                                <div class="icons">
                                    <span class="user-name">{{Auth::user()->lastname}}<i class='bx bx-chevron-down'></i></span>
                                    <span>
                                    @if(Auth::user()->photo_id)
                                            @if(isset(Auth::user()->photo->path))
                                                <img class="img-profiles" src="{{Auth::user()->photo->path}}" alt=" پروفایل کاربری :  {{Auth::user()->lastname}}">

                                            @else
                                                <img class="img-profiles" src="{{asset('front/assets/img/user-3.jpg')}}">
                                            @endif
                                        @else
                                            <img class="img-profiles" src="{{asset('front/assets/img/user-3.jpg')}}">
                                        @endif
                                </span>

                                </div>
                                <div class="dropdown-content">
                                    @if(Auth::user()->unreadnotifications->count())
                                        @if(Auth::user()->unreadnotifications->pluck('type') == 'App\Notifications\DescriptionAdd')
                                            <a href="{{route('notification')}}" class="bg-purple-notif"><i class="icofont-alarm"></i> {{Auth::user()->unreadnotifications->count()}}اعلان جدید </a>
                                        @endif
                                    @endif
                                    {{--                                        <p class="karma">{{Auth::user()->lastname}}</p>--}}
                                    <a href="{{route('profile')}}"><i class='bx bx-home'></i>داشبورد</a>
                                    <a href="{{route('profileedite',Auth::user()->id)}}"><i class='bx bx-user'></i>تکمیل پروفایل </a>
                                    <a href="{{route('ticket.create')}}" target="_blank"><i class='bx bx-message-square-detail'></i>تیکت</a>
                                    <div class="logout-btn mt-10">
                                        <form action="{{route('logout')}}" method="post">
                                            @csrf
                                            <button type="submit" class="logout-btn-style"><i class='bx bx-log-out'></i>خروج</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="dropdown">
                                <div class="icons">
                                    <span class="user-name">{{Auth::user()->lastname}}<i class='bx bx-chevron-down'></i></span>
                                    <span>
                                    @if(Auth::user()->photo_id)
                                            @if(isset(Auth::user()->photo->path))
                                                <img class="img-profiles" src="{{Auth::user()->photo->path}}" alt=" پروفایل کاربری :  {{Auth::user()->lastname}}">

                                            @else
                                                <img class="img-profiles" src="{{asset('front/assets/img/user-3.jpg')}}">
                                            @endif
                                        @else
                                            <img class="img-profiles" src="{{asset('front/assets/img/user-3.jpg')}}">
                                        @endif
                                </span>

                                </div>
                                <div class="dropdown-content">
                                    @if(Auth::user()->unreadnotifications->count())
                                        <a href="{{route('teammate-notification')}}" class="bg-purple-notif"><i class="icofont-alarm"></i> {{Auth::user()->unreadnotifications->count()}}اعلان جدید </a>
                                    @endif

                                    <a href="{{route('teammate',Auth::user()->id)}}"><i class='bx bx-home'></i>داشبورد</a>
                                    <a href="{{route('teammate-final',Auth::user()->id)}}"><i class='bx bx-user'></i>تکمیل فرم همکاری </a>
                                    <a href="{{route('teammate-ticket.create')}}" target="_blank"><i class='bx bx-message-square-detail'></i>تیکت</a>
                                    <div class="logout-btn mt-10">
                                        <form action="{{route('logout')}}" method="post">
                                            @csrf
                                            <button type="submit"  class="logout-btn-style"><i class='bx bx-log-out'></i>خروج</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @elsecan('isClient')
                            <div class="dropdown">
                                <div class="icons">
                                    <span class="user-name">{{Auth::user()->lastname}}<i class='bx bx-chevron-down'></i></span>
                                    <span>
                                    @if(Auth::user()->photo_id)
                                            @if(isset(Auth::user()->photo->path))
                                                <img class="img-profiles" src="{{Auth::user()->photo->path}}" alt=" پروفایل کاربری :  {{Auth::user()->lastname}}">

                                            @else
                                                <img class="img-profiles" src="{{asset('front/assets/img/user-3.jpg')}}">
                                            @endif
                                        @else
                                            <img class="img-profiles" src="{{asset('front/assets/img/user-3.jpg')}}">
                                        @endif
                                </span>

                                </div>
                                <div class="dropdown-content">
                                    @if(Auth::user()->unreadnotifications->count())
                                        @if(Auth::user()->unreadnotifications->pluck('type') == 'App\Notifications\DescriptionAdd')
                                            <a href="{{route('notification')}}" class="bg-purple-notif"><i class="icofont-alarm"></i> {{Auth::user()->unreadnotifications->count()}}اعلان جدید </a>
                                        @endif
                                    @endif

                                    <a href="{{route('profile',Auth::user()->id)}}"><i class='bx bx-home'></i>داشبورد</a>
                                    <a href="{{route('profileedite',Auth::user()->id)}}"><i class='bx bx-user'></i>تکمیل پروفایل </a>
                                    <a href="{{route('ticket.create')}}" target="_blank"><i class='bx bx-message-square-detail'></i>تیکت</a>
                                    <div class="logout-btn mt-10">
                                        <form action="{{route('logout')}}" method="post">
                                            @csrf
                                            <button type="submit"  class="logout-btn-style"><i class='bx bx-log-out'></i>خروج</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @elsecan('isTeam')
                            <div class="dropdown">
                                <div class="icons">
                                    <span class="user-name">{{Auth::user()->lastname}}<i class='bx bx-chevron-down'></i></span>
                                    <span>
                                    @if(Auth::user()->photo_id)
                                            @if(isset(Auth::user()->photo->path))
                                                <img class="img-profiles" src="{{Auth::user()->photo->path}}" alt=" پروفایل کاربری :  {{Auth::user()->lastname}}">

                                            @else
                                                <img class="img-profiles" src="{{asset('front/assets/img/user-3.jpg')}}">
                                            @endif
                                        @else
                                            <img class="img-profiles" src="{{asset('front/assets/img/user-3.jpg')}}">
                                        @endif
                                </span>

                                </div>
                                <div class="dropdown-content">
                                    @if(Auth::user()->unreadnotifications->count())
                                        <a href="{{route('teammate-notification')}}" class="bg-purple-notif"><i class="icofont-alarm"></i> {{Auth::user()->unreadnotifications->count()}}اعلان جدید </a>
                                    @endif
                                    <a href="{{route('teammate',Auth::user()->id)}}"><i class='bx bx-home'></i>داشبورد</a>
                                    <a href="{{route('teammate-final',Auth::user()->id)}}"><i class='bx bx-user'></i>تکمیل فرم همکاری </a>
                                    <a href="{{route('teammate-ticket.create')}}" target="_blank"><i class='bx bx-message-square-detail'></i>تیکت</a>
                                    <div class="logout-btn mt-10">
                                        <form action="{{route('logout')}}" method="post">
                                            @csrf
                                            <button type="submit" class="logout-btn-style"><i class='bx bx-log-out'></i>خروج</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                @elsecan('isSupport')
                    <li style="display: inline-block">
                        <a class="header-access" href="{{route('admin')}}" target="_blank">
                            @if(Auth::user()->photo_id)
                                @if(isset(Auth::user()->photo->path))
                                    <img class="img-profiles" src="{{Auth::user()->photo->path}}" alt=" پروفایل کاربری :  {{Auth::user()->lastname}}">
                                @endif
                            @else
                                پنل پشتیبان
                            @endif
                        </a>
                    </li>
                @elsecan('isFalse')
                    <div class="dropdown">
                        <div class="icons">
                            <span class="user-name">{{Auth::user()->lastname}}<i class='bx bx-chevron-down'></i></span>
                                <span>
                                    @if(Auth::user()->photo_id)
                                        @if(isset(Auth::user()->photo->path))
                                            <img class="img-profiles" src="{{Auth::user()->photo->path}}" alt=" پروفایل کاربری :  {{Auth::user()->lastname}}">

                                        @else
                                            <img class="img-profiles" src="{{asset('front/assets/img/user-3.jpg')}}">
                                        @endif
                                    @else
                                        <img class="img-profiles" src="{{asset('front/assets/img/user-3.jpg')}}">
                                    @endif
                                </span>

                        </div>
                        <div class="dropdown-content">
                            @if(Auth::user()->unreadnotifications->count())
                                @if(Auth::user()->unreadnotifications->pluck('type') == 'App\Notifications\DescriptionAdd')
                                    <a href="{{route('notification')}}" class="bg-purple-notif"><i class="icofont-alarm"></i> {{Auth::user()->unreadnotifications->count()}}اعلان جدید </a>
                                @endif
                            @endif
                            <a href="{{route('profile',Auth::user()->id)}}"><i class='bx bx-home'></i>داشبورد</a>
                            <a href="{{route('profileedite',Auth::user()->id)}}"><i class='bx bx-user'></i>تکمیل پروفایل </a>
                            <a href="{{route('ticket.create')}}" target="_blank"><i class='bx bx-message-square-detail'></i>تیکت</a>
                            <div class="logout-btn mt-10">
                                <form action="{{route('logout')}}" method="post">
                                    @csrf
                                    <button type="submit"  class="logout-btn-style"><i class='bx bx-log-out'></i>خروج</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endcan
                @can('isAuthor')
                    <li style="display: inline-block">
                        <a class="header-access" href="{{route('admin')}}" target="_blank">
                            @if(Auth::user()->photo_id)
                                @if(isset(Auth::user()->photo->path))
                                    <img class="img-profiles" src="{{Auth::user()->photo->path}}" alt=" پروفایل کاربری :  {{Auth::user()->lastname}}">
                                @endif
                            @else
                                پنل نویسنده
                            @endif
                        </a>
                    </li>
                @endcan
                @else
                    <li style="display: inline-block" >
                        <a class="login-to-profile" href="{{route('login')}}">ورود به حساب کاربری <i class="icofont-user-alt-7"></i>
                        </a>
                    </li>
                    {{--                        <a href="#" class="shopping-cart"><img src="{{asset('front/assets/img/shopping-cart.png')}}" alt="سبد خرید"></a>--}}
                @endauth
                {{--                      <a href=""><i class="icofont-ui-cart"></i></a>--}}
            </div>
        </div>

        {{--        <h1 class="logo mr-auto"><a href="{{route('home')}}"></a></h1>--}}

    </div>
</header><!-- End Header -->



