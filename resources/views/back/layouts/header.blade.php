<header class="main-header">
    <!-- Logo -->
    <a href="{{route('admin')}}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">پنل</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>کنترل پنل مدیریت</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>


        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications: style can be found in dropdown.less -->
                @can('isAdmin')
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-danger">{{Auth::user()->unreadnotifications->count()}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header">
                            @if(Auth::user()->unreadnotifications->count())
                                {{Auth::user()->unreadnotifications->count()}} اعلان جدید
                                @else
                                اعلان جدید ندارید
                            @endif
                        </li>
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                <li>
                                    <div id="messages">
                                        <a href="{{route('back.products')}}">
                                            @foreach (Auth::user()->unreadNotifications as $notification)
{{--                                                @if(Auth::user()->unreadnotifications->type == 'App\Notifications\ProductAdd')--}}
{{--                                                    سفارش {{$notification->data['title']}} ثبت شده است.--}}
{{--                                                @endif--}}
                                            @endforeach
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <li class="footer"><a href="{{route('back.user.notification')}}">نمایش همه</a></li>

                    </ul>
                </li>
            @endcan
                <!-- Tasks: style can be found in dropdown.less -->

                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        @if(isset(Auth::user()->photo_id))
                            @if(isset(Auth::user()->photo->path))
                                <img src="{{Auth::user()->photo->path}}" class="user-image" alt="User Image">
                                @endif
                            @else
                            <i class="fa fa-user"></i>
                        @endif
                        <span class="hidden-xs">{{Auth::user()->lastname}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            @if(isset(Auth::user()->photo_id))
                                @if(isset(Auth::user()->photo->path))
                            <img src="{{Auth::user()->photo->path}}" class="img-circle" alt="User Image">
                                @endif
                            @else
                                <i class="fa fa-user"></i>
                            @endif
                            <p>
                                {{Auth::user()->lastname}}
                                <small>{{Auth::user()->roles()->pluck('name')->first()}}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
{{--                            <div class="row">--}}
{{--                                <div class="col-xs-4 text-center">--}}
{{--                                    <a href="#">فروش</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <!-- /.row -->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="{{route('back.user.profile',Auth::user()->id)}}" class="btn btn-default btn-flat">پروفایل</a>
                            </div>
                            <div class="pull-left">
                                <form action="{{route('logout')}}" method="post">
                                    @csrf
                                    <button class="btn btn-default btn-flat" type="submit">خروج</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
