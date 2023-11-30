<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>پنل مدیریت اختصاصی</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicons -->
    <link href="{{asset('front/assets/img/favicon-ad.png')}}" rel="icon">
    <link href="{{asset('front/assets/img/appleicon.png')}}" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
{{--    <link href="{{asset('front/assets/vendor/bootstrap/css/bootstrap.rtl.css')}}" rel="stylesheet">--}}
{{--    <link href="{{asset('front/assets/vendor/bootstrap/css/bootstrap.rtl.min.css')}}" rel="stylesheet">--}}
{{--    <link href="{{asset('front/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">--}}
    <link href="{{asset('front/assets/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">

{{--    <link href="{{asset('front/assets/vendor/venobox/venobox.css')}}" rel="stylesheet">--}}
{{--    <link href="{{asset('front/assets/css/owl.carousel.css')}}" rel="stylesheet">--}}
{{--    <link href="{{asset('front/assets/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">--}}

{{--    <link href="{{asset('front/assets/css/owl.theme.css')}}" rel="stylesheet">--}}
{{--    <link href="{{asset('front/assets/vendor/aos/aos.css')}}" rel="stylesheet">--}}
{{--    <link rel="stylesheet" href="{{url('back/chosen/chosen.css')}}"/>--}}
{{--    <link rel="stylesheet" href="{{url('back/chosen/chosen.css/chosen.min.css')}}"/>--}}
    <link rel="stylesheet" href="{{url('back/dist/css/dropzone.min.css')}}">
    @yield('style')

{{--    <!-- Template Main CSS File -->--}}
{{--    <link href="{{asset('front/assets/css/style.css')}}" rel="stylesheet">--}}
{{--    <link rel="stylesheet" href="{{asset('front/assets/src/jquery.md.bootstrap.datetimepicker.style.css')}}" />--}}
{{--    <link rel="stylesheet" href="{{asset('front/assets/dist/jquery.md.bootstrap.datetimepicker.style.css')}}" />--}}
    <link href="{{asset('front/css/app.css')}}" rel="stylesheet">

    <script src="https://cdn.tiny.cloud/1/ct8sqly92m42vvaaapw3r3u5r4v134klm36z2unbur5lac27/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#editor2',
            height: 200,
            dirctionality : "rtl",
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount',
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: 'rtl ltr |undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
    <!-- Google recaptcha -->
    {!! htmlScriptTagJsApi(['lang'=>'fa']) !!}
    @arcaptchaScript
</head>
<body dir="rtl">

<!-- ======= Top Bar ======= -->
{{--<div id="topbar" class="d-none d-lg-flex align-items-center fixed-top ">--}}
{{--    <div class="container-fluid pt-3 d-flex align-items-center justify-content-between">--}}
{{--        <div class="col-lg-3">--}}
{{--            <a href="{{route('home')}}" class="logo mr-auto"><img src="{{asset('front/assets/img/logo yabane fa bold newcolor+new.png')}}" alt="logo" class="img-fluid"></a>--}}
{{--        </div>--}}
{{--        <div class="col-lg-6">--}}
{{--            <form action="{{route('searchmain')}}" method="post">--}}
{{--                @csrf--}}
{{--                <div class="input-group mb-3" >--}}
{{--                    <input type="text" name="search" class="form-control input-costoming" placeholder="جستجو در یابانه..." aria-label="Username" aria-describedby="basic-addon1" style="height: 40px;">--}}
{{--                    <div class="input-group-prepend" style="height: 40px;">--}}
{{--                        <button type="submit" class="input-group-text input-costoming-btn" id="basic-addon1"><i class="icofont-search"></i></button>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}

{{--    </div>--}}
{{--</div>--}}

<header id="header" class="fixed-top">
    <div class="container-fluid d-flex align-items-center">


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
                    <li style="display: inline-block"  class="active">
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

                                <a href="{{route('profile')}}"><i class='bx bx-home'></i>داشبورد </a>
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
                                        <img class="img-profiles" src="{{Auth::user()->photo->path}}" alt=" پروفایل همکاری :  {{Auth::user()->lastname}}">

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
                                        <img class="img-profiles" src="{{Auth::user()->photo->path}}" alt=" پروفایل همکاری :  {{Auth::user()->lastname}}">

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
                    <a href="#" class="shopping-cart"><img src="{{asset('front/assets/img/shopping-cart.png')}}" alt="سبد خرید"></a>
                @endauth

            </div>
        </div>

        {{--        <h1 class="logo mr-auto"><a href="{{route('home')}}"></a></h1>--}}

    </div>
</header><!-- End Header -->
