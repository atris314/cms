<!-- right side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-right image">
                @if(isset(Auth::user()->photo_id))
                    @if(isset(Auth::user()->photo->path))
                        <img src="{{Auth::user()->photo->path}}" class="img-circle" alt="User Image">
                    @endif
                @else
                    <i class="fa fa-user"></i>
                @endif
            </div>
            <div class="pull-right info">
                <p>{{Auth::user()->lastname}}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> {{Auth::user()->roles()->pluck('name')->first()}}</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="جستجو">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">منو</li>
            <li class="active treeview">
                <a href="#">
                    <i class="fa fa-dashboard"></i> <span>سایت اختصاصی</span>
                    <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li class="active"><a target="_blank" href="{{route('home')}}"><i class="fa fa-circle-o"></i>مشاهده وب سایت</a></li>
                    <li><a href="{{route('admin')}}"><i class="fa fa-circle-o"></i>پنل مدیریت</a></li>
                </ul>
            </li>
            @can('isAdmin')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-share"></i> <span>مدیریت محتوای خانه</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href=""><i class="fa fa-hand-pointer-o"></i>متن هدر سایت
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.sliders')}}"><i class="fa fa-list"></i>لیست </a></li>
                                <li><a href="{{route('back.sliders.create')}}"><i class="fa fa-plus"></i>ایجاد </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-hand-pointer-o"></i>بنر هدر سایت
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.bannerhomes')}}"><i class="fa fa-list"></i>لیست </a></li>
                                <li><a href="{{route('back.bannerhomes.create')}}"><i class="fa fa-plus"></i>ایجاد </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-hand-pointer-o"></i>اسلایدشو
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.slideshows')}}"><i class="fa fa-list"></i>لیست </a></li>
                                <li><a href="{{route('back.slideshows.create')}}"><i class="fa fa-plus"></i>ایجاد </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-hand-pointer-o"></i>گالری
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.galleries')}}"><i class="fa fa-list"></i>لیست </a></li>
                                <li><a href="{{route('back.galleries.create')}}"><i class="fa fa-plus"></i>ایجاد </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-hand-pointer-o"></i>اسلایدردسته بندی ها
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.catsliders')}}"><i class="fa fa-list"></i>لیست </a></li>
                                <li><a href="{{route('back.catsliders.create')}}"><i class="fa fa-plus"></i>ایجاد </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-user-secret"></i>درباره ما
                                <span class="pull-left-container">
                  <i class="fa fa-angle-left pull-left"></i>
                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.abouts')}}"><i class="fa fa-list"></i>لیست درباره ما</a></li>
                                <li><a href="{{route('back.abouts.create')}}"><i class="fa fa-plus"></i>ایجاد درباره ما</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-th"></i>ویجت
                                <span class="pull-left-container">
                  <i class="fa fa-angle-left pull-left"></i>
                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.aunderwidgets')}}"><i class="fa fa-list"></i>لیست ویجت ...</a></li>
                                <li><a href="{{route('back.aunderwidgets.create')}}"><i class="fa fa-plus"></i> ایجاد ویجت ...</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-gear"></i>خدمات
                                <span class="pull-left-container">
                  <i class="fa fa-angle-left pull-left"></i>
                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.services')}}"><i class="fa fa-list"></i>لیست خدمات</a></li>
                                <li><a href="{{route('back.services.create')}}"><i class="fa fa-plus"></i>ایجاد خدمات</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-gear"></i>لوگوی همکاران
                                <span class="pull-left-container">
                  <i class="fa fa-angle-left pull-left"></i>
                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.clients')}}"><i class="fa fa-list"></i>لیست </a></li>
                                <li><a href="{{route('back.clients.create')}}"><i class="fa fa-plus"></i>ایجاد </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-gear"></i>کال اکشن
                                <span class="pull-left-container">
                  <i class="fa fa-angle-left pull-left"></i>
                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.ctas')}}"><i class="fa fa-list"></i>لیست </a></li>
                                <li><a href="{{route('back.ctas.create')}}"><i class="fa fa-plus"></i>ایجاد </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-gear"></i>رضایت مشتریان
                                <span class="pull-left-container">
                  <i class="fa fa-angle-left pull-left"></i>
                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.customers')}}"><i class="fa fa-list"></i>لیست </a></li>
                                <li><a href="{{route('back.customers.create')}}"><i class="fa fa-plus"></i>ایجاد </a></li>
                            </ul>
                        </li>

                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bars"></i> <span>ویدئوها </span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.videos')}}"><i class="fa fa-list"></i>لیست </a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bars"></i> <span>امضای الکترونیکی</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.confirmations')}}"><i class="fa fa-list"></i>لیست </a></li>
                    </ul>
                </li>

                <li class="treeview">
                    <a href="">
                        <i class="fa fa-shopping-bag"></i> <span>مدیریت سفارشات</span>
                        <span class="pull-left-container">
                        <i class="fa fa-angle-left pull-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="{{route('back.products.create')}}"><i class="fa fa-check-square-o"></i>ایجاد سفارش
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.products.create')}}"><i class="fa fa-list"></i>ثبت سفارش </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="{{route('back.products')}}"><i class="fa fa-check-square-o"></i>تمام سفارشات
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.products')}}"><i class="fa fa-list"></i>لیست </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-hand-pointer-o"></i>سفارشات اولیه(ثبت شده)
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.productstore')}}"><i class="fa fa-list"></i>لیست </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="{{route('back.holdEdit')}}"><i class="fa fa-hand-pointer-o"></i>سفارشات درانتظار تکمیل
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.holdEdit')}}"><i class="fa fa-list"></i>لیست </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="{{route('back.protranslates')}}"><i class="fa fa-user-secret"></i>سفارشات ترجمه شده
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.protranslates')}}"><i class="fa fa-list"></i>لیست</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="{{route('back.presents')}}"><i class="fa fa-th"></i>سفارشات آماده شده
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.presents')}}"><i class="fa fa-list"></i>لیست</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="{{route('back.products.cancel')}}"><i class="fa fa-gear"></i>سفارشات حذف شده
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.products.cancel')}}"><i class="fa fa-list"></i>لیست خدمات</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="{{route('back.catorders')}}"><i class="fa fa-gear"></i>دسته بندی سفارشات
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.catorders')}}"><i class="fa fa-list"></i>لیست </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="{{route('back.messages')}}"><i class="fa fa-gear"></i>پیغام کارشناس
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.messages')}}"><i class="fa fa-list"></i>لیست پیغام ها </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="{{route('back.producttrackings')}}"><i class="fa fa-gear"></i>کد رهگیری مرسولات
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.producttrackings')}}"><i class="fa fa-list"></i>لیست کد رهگیری مرسولات </a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user-circle-o"></i> <span>مدیریت کاربران</span>
                        <span class="pull-left-container">
                        <i class="fa fa-angle-left pull-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href=""><i class="fa fa-check-square-o"></i> کاربران
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.users')}}"><i class="fa fa-list"></i>لیست کاربران</a></li>
                                <li><a href="{{route('back.users.create')}}"><i class="fa fa-plus"></i>ثبت کاربر</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-hand-pointer-o"></i>نظرات كاربران
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.comments')}}"><i class="fa fa-list"></i>لیست نظرات </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="{{route('back.cancels')}}"><i class="fa fa-hand-pointer-o"></i>نظرسنجی کاربران
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.cancels')}}"><i class="fa fa-list"></i>لیست </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="{{route('back.contacts')}}"><i class="fa fa-user-secret"></i>تماس كاربران
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.contacts')}}"><i class="fa fa-list"></i>لیست</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-users"></i> <span>مدیریت همکاران</span>
                        <span class="pull-left-container">
                        <i class="fa fa-angle-left pull-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="{{route('back.teammates')}}"><i class="fa fa-check-square-o"></i> درخواست های همکاری
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.teammates')}}"><i class="fa fa-list"></i>لیست همکاران</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-hand-pointer-o"></i>دسته بندي نوع همکاری
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.catworks')}}"><i class="fa fa-list"></i>لیست دسته بندي همکاری</a></li>
                                <li><a href="{{route('back.catworks.create')}}"><i class="fa fa-plus"></i> ایجاد دسته بندي</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-hand-pointer-o"></i>مدیریت گروه بندی همکاران
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.groups')}}"><i class="fa fa-list"></i>لیست گروه بندی</a></li>
                                <li><a href="{{route('back.groups.create')}}"><i class="fa fa-plus"></i>ایجاد گروه بندی</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="{{route('back.resources')}}"><i class="fa fa-check-square-o"></i>همکاری به عنوان منبع
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.resources')}}"><i class="fa fa-list"></i>لیست همکاری منبع</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-commenting-o"></i> <span>مدیریت تیکت ها</span>
                        <span class="pull-left-container">
                        <i class="fa fa-angle-left pull-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="{{route('back.tickets')}}"><i class="fa fa-commenting-o"></i>تیکت های کاربران
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.tickets')}}"><i class="fa fa-list"></i>لیست تیکت ها</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="{{route('back.teamtickets')}}"><i class="fa fa-commenting-o"></i>تیکت های کارشناس دورکار
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.teamtickets')}}"><i class="fa fa-list"></i>لیست تیکت های کارشناس</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-file-text-o"></i> <span>مدیریت مطالب</span>
                        <span class="pull-left-container">
                        <i class="fa fa-angle-left pull-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href=""><i class="fa fa-th-list"></i>دسته بندي مطالب
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.categories')}}"><i class="fa fa-list"></i>لیست دسته بندي مطالب</a></li>
                                <li><a href="{{route('back.categories.create')}}"><i class="fa fa-plus"></i> ایجاد دسته بندي</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-edit"></i>مطالب|پست ها
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.posts')}}"><i class="fa fa-list"></i>لیست مطالب</a></li>
                                <li><a href="{{route('back.posts.create')}}"><i class="fa fa-plus"></i> ایجاد مطلب</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-tag"></i> <span>مدیریت تخفیف ها</span>
                        <span class="pull-left-container">
                        <i class="fa fa-angle-left pull-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href=""><i class="fa fa-tag"></i>تخفیف منبع یابی
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.coupons')}}"><i class="fa fa-list"></i>لیست تخفیف منبع یابی </a></li>
                                <li><a href="{{route('back.coupons.create')}}"><i class="fa fa-plus"></i> ایجاد </a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="{{route('back.couponpresents')}}"><i class="fa fa-tags"></i>تخفیف خریدهای نهایی
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.couponpresents')}}"><i class="fa fa-list"></i>لیست تخفیف خرید نهایی </a></li>
                                <li><a href="{{route('back.couponpresents.create')}}"><i class="fa fa-plus"></i> ایجاد </a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-clone"></i> <span>مدیریت کاتالوگ ها</span>
                        <span class="pull-left-container">
                        <i class="fa fa-angle-left pull-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href=""><i class="fa fa-list-alt"></i>دسته بندی کاتالوگ
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.catalogcats')}}"><i class="fa fa-list"></i>لیست </a></li>
                                <li><a href="{{route('back.catalogcats.create')}}"><i class="fa fa-plus"></i> ایجاد</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-tags"></i>کاتالوگ ها
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.catalogs')}}"><i class="fa fa-list"></i>لیست </a></li>
                                <li><a href="{{route('back.catalogs.create')}}"><i class="fa fa-plus"></i> ایجاد</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-tags"></i>ایمیل های دانلود کاتالوگ
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.catusers')}}"><i class="fa fa-list"></i>لیست </a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gamepad"></i> <span>پیش بینی جام جهانی</span>
                        <span class="pull-left-container">
                        <i class="fa fa-angle-left pull-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href=""><i class="fa fa-list-alt"></i>جدول بازی ها
                                <span class="pull-left-container">
                                    <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.footballs')}}"><i class="fa fa-list"></i>لیست </a></li>
                                <li><a href="{{route('back.footballs.create')}}"><i class="fa fa-plus"></i> ایجاد</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href=""><i class="fa fa-tags"></i> پیش بینی کاربران
                                <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{route('back.footballpres')}}"><i class="fa fa-list"></i>لیست پیش بینی ها </a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-mail-reply"></i> <span>ایمیل چین</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.emails')}}"><i class="fa fa-list"></i> مشاهده ایمیل </a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bars"></i> <span>منوها</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.menus')}}"><i class="fa fa-list"></i>لیست منوها</a></li>
                        <li><a href="{{route('back.menus.create')}}"><i class="fa fa-plus"></i>ایجاد منوها</a></li>
                    </ul>
                </li>
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa  fa-users"></i>--}}
                {{--                        <span>مدیریت  گروه بندی همکاران</span>--}}
                {{--                        <span class="pull-left-container">--}}

                {{--              <span class="pull-left">--}}
                {{--                  <i class="fa fa-angle-left pull-left"></i>--}}
                {{--              </span>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.groups')}}"><i class="fa fa-list"></i>لیست گروه بندی</a></li>--}}
                {{--                        <li><a href="{{route('back.groups.create')}}"><i class="fa fa-plus"></i>ایجاد گروه بندی</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}


                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa  fa-users"></i>--}}
                {{--                        <span>مدیریت کاربران</span>--}}
                {{--                        <span class="pull-left-container">--}}

                {{--              <span class="pull-left">--}}
                {{--                  <i class="fa fa-angle-left pull-left"></i>--}}
                {{--              </span>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.users')}}"><i class="fa fa-list"></i>لیست کاربران</a></li>--}}
                {{--                        <li><a href="{{route('back.users.create')}}"><i class="fa fa-plus"></i>ثبت کاربر</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-comments"></i> <span>تماس كاربران</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.contacts')}}"><i class="fa fa-list"></i>ليست تماس ها</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-comments"></i> <span> درخواست مشاوره</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.quickmobiles')}}"><i class="fa fa-list"></i>لیست شماره موبایل</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-comments"></i> <span>بنر بخش کاربری</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.bannerusers')}}"><i class="fa fa-list"></i>ليست</a></li>
                        <li><a href="{{route('back.bannerusers.create')}}"><i class="fa fa-plus"></i> ایجاد </a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user-md"></i> <span>اعضای خبرنامه</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.newsletters')}}"><i class="fa fa-list"></i>لیست اعضای خبرنامه</a></li>
                    </ul>
                </li>
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-th-list"></i> <span>دسته بندي مطالب</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.categories')}}"><i class="fa fa-list"></i>لیست دسته بندي مطالب</a></li>--}}
                {{--                        <li><a href="{{route('back.categories.create')}}"><i class="fa fa-plus"></i> ایجاد دسته بندي</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-edit"></i> <span>مطالب|پست ها</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.posts')}}"><i class="fa fa-list"></i>لیست مطالب</a></li>--}}
                {{--                        <li><a href="{{route('back.posts.create')}}"><i class="fa fa-plus"></i> ایجاد مطلب</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-comments"></i> <span>نظرات كاربران</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.comments')}}"><i class="fa fa-list"></i>ليست نظرات</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}

                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-folder-open-o"></i> <span>نمونه سفارشات</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.portfolios')}}"><i class="fa fa-list"></i>لیست نمونه سفارشات</a></li>
                        <li><a href="{{route('back.portfolios.create')}}"><i class="fa fa-plus"></i> ایجاد نمونه سفارش</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-folder-open-o"></i> <span>صفحه همکاری با ما </span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.works')}}"><i class="fa fa-list"></i>  لیست</a></li>
                        <li><a href="{{route('back.works.create')}}"><i class="fa fa-plus"></i> ایجاد  </a></li>
                    </ul>
                </li>
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-th-list"></i> <span>دسته بندي نوع همکاری</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.catworks')}}"><i class="fa fa-list"></i>لیست دسته بندي همکاری</a></li>--}}
                {{--                        <li><a href="{{route('back.catworks.create')}}"><i class="fa fa-plus"></i> ایجاد دسته بندي</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-universal-access"></i> <span>درخواست های همکاری</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.teammates')}}"><i class="fa fa-list"></i>لیست درخواست های همکاری</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}

                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-th-list"></i> <span>دسته بندي سفارشات</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.catorders')}}"><i class="fa fa-list"></i>لیست دسته بندي </a></li>--}}
                {{--                        <li><a href="{{route('back.catorders.create')}}"><i class="fa fa-plus"></i> ایجاد دسته بندي</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}

                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-briefcase"></i> <span> سفارشات ثبت شده</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}

                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.productstore')}}"><i class="fa fa-list"></i>لیست سفارشات ثبت شده </a></li>--}}
                {{--                    </ul>--}}

                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-briefcase"></i> <span>تمام سفارشات</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}

                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.products')}}"><i class="fa fa-list"></i>لیست تمام سفارشات </a></li>--}}
                {{--                    </ul>--}}

                {{--                </li>--}}

                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-briefcase"></i> <span> سفارشات در انتظار تکمیل</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}

                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.holdEdit')}}"><i class="fa fa-list"></i> مشاهده لیست </a></li>--}}
                {{--                    </ul>--}}

                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-briefcase"></i> <span>سفارشات ترجمه شده</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}

                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.protranslates')}}"><i class="fa fa-list"></i>لیست سفارشات ترجمه شده</a></li>--}}
                {{--                    </ul>--}}

                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-briefcase"></i> <span>سفارشات آماده شده</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}

                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.presents')}}"><i class="fa fa-list"></i>لیست سفارشات آماده</a></li>--}}
                {{--                    </ul>--}}

                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-briefcase"></i> <span>پیغام کارشناس</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}

                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.messages')}}"><i class="fa fa-list"></i>لیست پیغام ها</a></li>--}}
                {{--                    </ul>--}}

                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-briefcase"></i> <span>نظرسنجی کاربران </span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}

                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.cancels')}}"><i class="fa fa-list"></i>لیست نظرسنجی</a></li>--}}
                {{--                    </ul>--}}

                {{--                </li>--}}
            @endcan
            @can('isSupport')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-briefcase"></i> <span>سفارشات ترجمه شده</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>

                    <ul class="treeview-menu">
                        <li><a href="{{route('back.protranslates')}}"><i class="fa fa-list"></i>لیست سفارشات ترجمه شده</a></li>
                    </ul>

                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-briefcase"></i> <span>سفارشات آماده شده</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>

                    <ul class="treeview-menu">
                        <li><a href="{{route('back.presents')}}"><i class="fa fa-list"></i>لیست سفارشات آماده</a></li>
                    </ul>

                </li>
            @endcan
            @can('isAdmin')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dollar"></i> <span>رسیدهای پرداختی</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.resids')}}"><i class="fa fa-list"></i>رسیدهای پرداختی</a></li>
                        <li><a href="{{route('back.presentresids')}}"><i class="fa fa-list"></i>رسیدهای پرداختی نهایی</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dollar"></i> <span>تراکنش ها|پرداخت ها</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.nextpayments')}}"><i class="fa fa-list"></i>تراکنش و پرداخت ها</a></li>
                        {{--                        <li><a href="{{route('back.presentpurchases')}}"><i class="fa fa-list"></i>تراکنش ها و پرداخت های نهایی</a></li>--}}
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-bomb"></i> <span>پکیج ها</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.packs')}}"><i class="fa fa-list"></i>لیست پکیج ها </a></li>
                        <li><a href="{{route('back.packs.create')}}"><i class="fa fa-plus"></i> ایجاد </a></li>
                    </ul>
                </li>
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-tags"></i> <span>تخفیف منبع یابی</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.coupons')}}"><i class="fa fa-list"></i>لیست تخفیف منبع یابی </a></li>--}}
                {{--                        <li><a href="{{route('back.coupons.create')}}"><i class="fa fa-plus"></i> ایجاد </a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-tags"></i> <span>تخفیف خریدهای نهایی</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.couponpresents')}}"><i class="fa fa-list"></i>لیست تخفیف خرید نهایی </a></li>--}}
                {{--                        <li><a href="{{route('back.couponpresents.create')}}"><i class="fa fa-plus"></i> ایجاد </a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-chain"></i> <span>تیکت ها</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.tickets')}}"><i class="fa fa-list"></i>لیست تیکت ها </a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-chain"></i> <span>تیکت های کارشناسان دورکار</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.teamtickets')}}"><i class="fa fa-list"></i>لیست تیکت های کارشناسان </a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}

            @endcan
            @can('isSupport')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-chain"></i> <span>تیکت ها</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.tickets')}}"><i class="fa fa-list"></i>لیست تیکت ها </a></li>
                    </ul>
                </li>
            @endcan
            @can('isAdmin')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-folder"></i> <span>رسانه ها</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.photos')}}"><i class="fa fa-list"></i> لیست فایل ها</a></li>
                        <li><a href="{{route('back.photos.create')}}"><i class="fa fa-plus"></i> آپلود فایل</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-gear"></i> <span>تنظیمات</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.settings')}}"><i class="fa fa-list"></i> لیست تنظیمات</a></li>
                        <li><a href="{{route('back.settings.create')}}"><i class="fa fa-plus"></i> ایجاد</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>شرایط و قوانین </span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.termpros')}}"><i class="fa fa-list"></i>  شرایط و قوانین ثبت سفارش</a></li>
                        <li><a href="{{route('back.termteams')}}"><i class="fa fa-list"></i>  شرایط و قوانین همکاری</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-adn"></i> <span>ایمیل مارکتینگ </span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.emailmarketings')}}"><i class="fa fa-list"></i>لیست</a></li>
                        <li><a href="{{route('back.emailmarketings.create')}}"><i class="fa fa-plus"></i> ایجاد</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-adn"></i> <span>تبلیغات </span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.ads')}}"><i class="fa fa-list"></i>لیست تبلیغات</a></li>
                        <li><a href="{{route('back.ads.create')}}"><i class="fa fa-plus"></i> ایجاد</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user-times"></i> <span>مشاهده درخواست تبلیغات </span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.adsforms')}}"><i class="fa fa-list"></i>لیست درخواست ها</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user-times"></i> <span>مشاهده درخواست نمایندگی </span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.representations')}}"><i class="fa fa-list"></i>لیست درخواست ها</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user-times"></i> <span>ویجت توضیحات نمایندگی </span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.widgets')}}"><i class="fa fa-list"></i>نمایش</a></li>
                        <li><a href="{{route('back.widgets.create')}}"><i class="fa fa-plus"></i> ایجاد</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-user-times"></i> <span>راهنمای ثبت سفارش </span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.guides')}}"><i class="fa fa-list"></i>لیست </a></li>
                        <li><a href="{{route('back.guides.create')}}"><i class="fa fa-plus"></i> ایجاد</a></li>
                    </ul>
                </li>
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-th-list"></i> <span>دسته بندی کاتالوگ </span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.catalogcats')}}"><i class="fa fa-list"></i>لیست </a></li>--}}
                {{--                        <li><a href="{{route('back.catalogcats.create')}}"><i class="fa fa-plus"></i> ایجاد</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-th-list"></i> <span>کاتالوگ ها </span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.catalogs')}}"><i class="fa fa-list"></i>لیست </a></li>--}}
                {{--                        <li><a href="{{route('back.catalogs.create')}}"><i class="fa fa-plus"></i> ایجاد</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-th-list"></i> <span>ایمیل های دانلود کاتالوگ </span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}
                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.catusers')}}"><i class="fa fa-list"></i>لیست ایمیل ها</a></li>--}}
                {{--                    </ul>--}}
                {{--                </li>--}}
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-th-list"></i> <span> کوین</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.coins')}}"><i class="fa fa-list"></i>لیست کوین ها</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-th-list"></i> <span>لیست قیمت ارز </span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.currencies')}}"><i class="fa fa-list"></i>لیست قیمت ارز  </a></li>
                        <li><a href="{{route('back.currencies.create')}}"><i class="fa fa-plus"></i>بروزرسانی قیمت ارز(دستی)</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-th-list"></i> <span>سوالات متداول </span>
                        <span class="pull-left-container">
                            <i class="fa fa-angle-left pull-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.faqs')}}"><i class="fa fa-list"></i>لیست سوالات متداول  </a></li>
                        <li><a href="{{route('back.faqs.create')}}"><i class="fa fa-plus"></i>ایجاد پرسش و پاسخ</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="{{route('back.questions')}}"><i class="fa fa-user-secret"></i>سوال كاربران
                        <span class="pull-left-container">
                                <i class="fa fa-angle-left pull-left"></i>
                                </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.questions')}}"><i class="fa fa-list"></i>لیست</a></li>
                    </ul>
                </li>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-th-list"></i> <span>کد معرف کاربران</span>
                        <span class="pull-left-container">
                            <i class="fa fa-angle-left pull-left"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.idcodes')}}"><i class="fa fa-list"></i>لیست کدهای معرف  </a></li>
                        <li><a href="{{route('back.idcodes.create')}}"><i class="fa fa-plus"></i>ایجادکد معرف</a></li>
                    </ul>
                </li>
                {{--                <li class="treeview">--}}
                {{--                    <a href="#">--}}
                {{--                        <i class="fa fa-briefcase"></i> <span> سفارشات حذف شده</span>--}}
                {{--                        <span class="pull-left-container">--}}
                {{--              <i class="fa fa-angle-left pull-left"></i>--}}
                {{--            </span>--}}
                {{--                    </a>--}}

                {{--                    <ul class="treeview-menu">--}}
                {{--                        <li><a href="{{route('back.products.cancel')}}"><i class="fa fa-list"></i>لیست سفارشات حذف شده </a></li>--}}
                {{--                    </ul>--}}

                {{--                </li>--}}
            @endcan
            @can('isAuthor')
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-edit"></i> <span>مطالب|پست ها</span>
                        <span class="pull-left-container">
              <i class="fa fa-angle-left pull-left"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="{{route('back.posts')}}"><i class="fa fa-list"></i>لیست مطالب</a></li>
                        <li><a href="{{route('back.posts.create')}}"><i class="fa fa-plus"></i> ایجاد مطلب</a></li>
                    </ul>
                </li>
            @endcan


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
