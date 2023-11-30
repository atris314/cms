@extends('back.index')
@section('content')
    <!-- Content Wrapper. Contains page content -->

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                داشبرد
                <small>کنترل پنل</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> خانه</a></li>
                <li class="active">داشبرد</li>
            </ol>
        </section>
        @include('back.massages')
        <!-- Main content -->
        <section class="content">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{$catuserscount}}</h3>

                            <p>تعداد دانلودهای کاتالوگ</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-book"></i>
                        </div>
                        <a href="{{route('back.catusers')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{$postcount}}</h3>

                            <p>مطالب | پست ها</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-edit"></i>
                        </div>
                        <a href="{{route('back.posts')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{$usercount}}</h3>

                            <p>کاربران ثبت شده</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{route('back.users')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{$photocount}}</h3>

                            <p>رسانه </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-folder"></i>
                        </div>
                        <a href="{{route('back.photos')}}" class="small-box-footer">اطلاعات بیشتر <i class="fa fa-arrow-circle-left"></i></a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <div class="row" style="margin-top: 50px;">
                <div class="col-lg-4">
                    <form action="{{route('back.currency.store')}}" method="post" style="margin-right: 120px;">
                        @csrf
                        <button type="submit" id="accessban" class="btn btn-lg">بروز رسانی قیمت ارز در دیتابیس</button>
                    </form>
                </div>
            </div>
            <div class="row justify-content-center">


                <section class="col-lg-4  connectedSortable">

                    <tgju
                            type="market-data"
                            items="775219,775220,775217,775218,137222,137205,137203"
                            columns="dot,diff,low,high,time"
                            token="webservice"
                    ></tgju>
                    <script src="https://api.accessban.com/v1/widget/v2" defer></script>
                </section>

                <section class="col-lg-8 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">آخرین سفارش ثبت شده</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>عنوان</th>
                                        <th>کد کاربری</th>
                                        <th>وضعیت</th>
                                        <th>منبع یابی</th>
                                        <th>تاریخ ایجاد</th>
                                        <th>مدیریت</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)

                                        <tr>
                                            <td><a href="{{route('back.posts.edit',$product->id)}}">{{$product->title}}</a></td>

                                                <td class="text-right"  dir="ltr">
                                                    @if(isset($product->user))
                                                    {{$product->user->code}}
                                                    @endif
                                                </td>
                                            <td >
                                                @if($product['status']==0)
                                                    <a  class="label pull-center bg-maroon" >در انتظار پرداخت هزینه منبع یابی</a>
                                                @elseif($product['status']==1)
                                                    <a  class="label pull-center bg-navy" >کوپن تخفیف خود را استفاده کرد</a>
                                                @elseif($product['status']==2)
                                                    <a  class="label pull-center bg-olive" >پرداخت منبع یابی</a>
                                                @elseif($product['status']==3)
                                                    <a class="label pull-center bg-orange">سفارش حاضر شده در انتظار پرداخت</a>
                                                @elseif($product['status']==4)
                                                    <a  class="label pull-center bg-purple" >پرداخت نهایی انجام شد</a>
                                                @elseif($product['status']==5)
                                                    <a  class="label pull-center bg-teal" >در دست اقدام</a>
                                                @elseif($product['status']==6)
                                                    <a  class="label pull-center bg-blue-active" >درخواست مجدد</a>
                                                @elseif($product['status']==7)
                                                    <a  class="label pull-center bg-fuchsia" >ترجمه شد</a>
                                                @elseif($product->status==8)
                                                    <a  class="label pull-center bg-yellow-gradient" >هزینه خرید کالا پرداخت شد</a>
                                                @elseif($product->status==9)
                                                    <a  class="label pull-center bg-green-gradient" >هزینه ترخیص کالا پرداخت شد</a>
                                                @elseif($product->status==10)
                                                    <a  class="label pull-center bg-blue-gradient" >هزینه ترخیص کالا تعیین شد</a>
                                                @elseif($product->status==11)
                                                    <a  class="label pull-center bg-olive" >اطلاعات سفارش تکمیل شد</a>
                                                @elseif($product->status==12)
                                                    <a  class="label pull-center bg-olive" >در انتظار تکمیل اطلاعات سفارش</a>
                                                @elseif($product->status==13)
                                                    <a  class="label pull-center bg-olive" >کاربر انصراف داد</a>
                                                @endif
                                            </td>
                                            <td>
                                                @foreach(@$product->pack()->pluck('title') as $pack)
                                                    @if($pack == 'طلایی')
                                                        <span  class="label pull-center bg-yellow-gradient" >{{$pack}}</span><br>
                                                    @elseif($pack == 'نقره ای')
                                                        <span  class="label pull-center bg-green-gradient" >{{$pack}}</span><br>
                                                    @elseif($pack == 'برنز')
                                                        <span  class="label pull-center bg-maroon-gradient" >{{$pack}}</span><br>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td style="font-size: 11px; color: gray">{{\Hekmatinasser\Verta\Verta::instance($product->created_at)}}</td>

                                            <td><a target="_blank" href="{{route('back.products.show',$product->id)}}" class="btn btn-success">نمایش سفارش</a></td>
                                        </tr>
                                        <div class="row mr-lg-5 pr-lg-3 justify-content-center"  style="margin-top: 70px; margin-bottom: 20px;" >
                                            <div class="col-lg-3 py-3 order-check" @if($product->status>=0) style="color: white;" @endif>
                                                @if($product->status>=0)
                                                    <div class="hline-blue d-none d-sm-block"></div>
                                                @endif
                                                @if($product->status>=0)
                                                    <div class="order-check-top bg-orange-color mb-10 @if($product->status>=0) bg-blue-color  @endif" >
                                                        سفارش شما در تاریخ{{\Hekmatinasser\Verta\Verta::instance($product->created_at)}}
                                                        ثبت شد و در انتظار پرداخت هزینه منبع یابی قرار گرفت </div>
                                                @endif
                                                <i class='bx bxs-hourglass-top' @if($product->status>=0) style="background-color:#00bcd4; border:2px solid #009aad;" @endif></i>
                                                <span class="order-text" > در انتظار پرداخت منبع یابی</span>
                                            </div>
                                            {{--                                            <div class="col-lg-3 py-3 order-check" @if($product->status>=1) style="color:white;" @endif>--}}
                                            {{--                                                <i class='bx bxs-offer' @if($product->status>=1) style="background-color:#00bcd4; border:2px solid #009aad;" @endif></i>--}}
                                            {{--                                                <span class="order-text">استفاده از کوپن تخفیف</span>--}}
                                            {{--                                            </div>--}}
                                            <div class="col-lg-3 py-3 order-check" @if($product->status>=2) style="color:white;" @endif>
                                                @if($product->status>=2)
                                                    <div class="hline-blue d-none d-sm-block"></div>
                                                @endif
                                                @if($product->status>=2)
                                                    <div class="order-check-top bg-orange-color mb-10 @if($product->status>=2) bg-blue-color  @endif" style="top:-52px !important;">هزینه منبع یابی سفارش در تاریخ {{\Hekmatinasser\Verta\Verta::instance($product->timepayment)}} پرداخت شد.</div>
                                                @endif
                                                <i class='bx bxs-credit-card' @if($product->status>=2) style="background-color:#00bcd4; border:2px solid #009aad;" @endif></i>
                                                <span class="order-text">منبع یابی پرداخت شد</span>
                                            </div>
                                            <div class="col-lg-3 py-3 order-check" @if($product->status==5) style="color: white;" @elseif($product->status==7) style="color: white;" @elseif($product->status==11) style="color: white;" @elseif($product->status==12) style="color: white;" @endif>
                                                @if($product->status==5)
                                                    <div class="hline-blue d-none d-sm-block"></div>
                                                @elseif($product->status==7)
                                                    <div class="hline-blue d-none d-sm-block"></div>
                                                @elseif($product->status==11)
                                                    <div class="hline-blue d-none d-sm-block"></div>
                                                @elseif($product->status==12)
                                                    <div class="hline-blue d-none d-sm-block"></div>
                                                @endif
                                                @if($product->status>=2)
                                                    <div class="order-check-top bg-orange-color mb-10
                                                    @if($product->status==5) bg-blue-color @elseif($product->status==7) bg-blue-color @elseif($product->status==11) bg-blue-color @elseif($product->status==12) bg-blue-color @endif
                                                            ">سفارش شما در حال بررسی و پیگیری می باشد. منبع یابی ها از طریق پیامک و ایمیل به اطلاع شما خواهد رسید.</div>
                                                @endif
                                                <i class='bx bx-time' @if($product->status==5) style="background-color:#00bcd4; border:2px solid #009aad;" @elseif($product->status==7) style="background-color:#00bcd4; border:2px solid #009aad;" @elseif($product->status==11) style="background-color:#00bcd4; border:2px solid #009aad;" @elseif($product->status==12) style="background-color:#00bcd4; border:2px solid #009aad;" @endif></i>
                                                <span class="order-text">در حال بررسی و منبع یابی</span>
                                            </div>
                                            <div class="col-lg-3 py-3 order-check">
                                                @if($product->status==4)
                                                    <div class="order-check-top bg-orange-color mb-10">سفارش شما حاضر شد در انتظار پرداخت هزینه خرید و ترخیص کالا می باشد.</div>
                                                @elseif($product->status==8)
                                                    <div class="order-check-top bg-orange-color mb-10">سفارش شما حاضر شد در انتظار پرداخت هزینه خرید و ترخیص کالا می باشد.</div>
                                                @elseif($product->status==9)
                                                    <div class="order-check-top bg-orange-color mb-10">سفارش شما حاضر شد در انتظار پرداخت هزینه خرید و ترخیص کالا می باشد.</div>
                                                @elseif($product->status==10)
                                                    <div class="order-check-top bg-orange-color mb-10">سفارش شما حاضر شد در انتظار پرداخت هزینه خرید و ترخیص کالا می باشد.</div>
                                                @elseif($product->status==14)
                                                    <div class="order-check-top bg-orange-color mb-10">سفارش شما حاضر شد در انتظار پرداخت هزینه خرید و ترخیص کالا می باشد.</div>
                                                @endif
                                                <i class='bx bx-check'></i>
                                                <span class="order-text">سفارش حاضر است</span>
                                            </div>
                                        </div>
                                        <div class="box-footer clearfix">

                                        </div>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->

                        <!-- /.box-footer -->
                    </div>

                </section>
            </div>


{{--            <tgju--}}
{{--                    type="market-overview"--}}
{{--                    items="137203,137205,137207,137206,137225"--}}
{{--                    columns="dot"--}}
{{--                    token="webservice"--}}
{{--            ></tgju>--}}
{{--            <script src="https://api.accessban.com/v1/widget/v2" defer></script>--}}
            <!-- /.row -->
            @can('isAdmin')
            <!-- Main row -->
            <div class="row">
                <section class="col-lg-12 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">مدیریت پیش بینی جام جهانی </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="col-lg-12 col-xl-6 box-body">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title"></h5>
                                        <div class="grid-menu grid-menu-2col">
                                            <div class="no-gutters row">
                                                <div class="col-sm-6">
                                                    <a href="{{route('back.footballs')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-success">
                                                        <i class="lnr-license btn-icon-wrapper"> </i>جدول بازی ها
                                                    </a>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a href="{{route('back.footballpres')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-success">
                                                        <i class="lnr-map btn-icon-wrapper"> </i>پیش بینی کاربران
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="text-center">
                                            <div class="btn-group dropdown">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">مدیریت همکاران </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                                <div class="col-lg-12 col-xl-6 box-body">
                                    <div class="main-card mb-3 card">
                                     <div class="card-body">
                                         <h5 class="card-title"></h5>
                                     <div class="grid-menu grid-menu-2col">
                                        <div class="no-gutters row">
                                    <div class="col-sm-6">
                                        <a href="{{route('back.groups')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-primary">
                                            <i class="lnr-license btn-icon-wrapper"> </i>گروه بندی
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="{{route('back.teamjobs')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-secondary">
                                            <i class="lnr-map btn-icon-wrapper"> </i>لیست فعالیت همکاران
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="{{route('back.teammates')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-success">
                                            <i class="lnr-music-note btn-icon-wrapper"> </i>درخواست های همکاری
                                        </a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="{{route('back.teamtickets')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-info">
                                            <i class="lnr-heart btn-icon-wrapper"> </i>تیکت های همکاری
                                        </a>
                                    </div>
                                </div>
                                     </div>
                                     <div class="divider"></div>
                                     <div class="text-center">
                                     <div class="btn-group dropdown">
                                     </div>
                                    </div>
                        </div>
                    </div>
                                 </div>
                        </div>
                    </div>
                </section>

                <!-- right col -->
                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">مدیریت سفارشات </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="col-lg-12 col-xl-6 box-body">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title"></h5>
                                        <div class="grid-menu grid-menu-2col">
                                            <div class="no-gutters row">
                                                <div class="col-sm-6">
                                                    <a href="{{route('back.catorders')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-primary">
                                                        <i class="lnr-license btn-icon-wrapper"> </i>دسته بندی سفارش
                                                    </a>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a href="{{route('back.products')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-secondary">
                                                        <i class="lnr-map btn-icon-wrapper"> </i>نمایش سفارشات
                                                    </a>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a href="{{route('back.protranslates')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-success">
                                                        <i class="lnr-music-note btn-icon-wrapper"> </i>سفارشات ترجمه شده
                                                    </a>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a href="{{route('back.presents')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-info">
                                                        <i class="lnr-heart btn-icon-wrapper"> </i>سفارشات آماده شده
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="text-center">
                                            <div class="btn-group dropdown">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">مدیریت کاربران </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="col-lg-12 col-xl-6 box-body">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title"></h5>
                                        <div class="grid-menu grid-menu-2col">
                                            <div class="no-gutters row">
                                                <div class="col-sm-6">
                                                    <a href="{{route('back.users')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-primary">
                                                        <i class="lnr-license btn-icon-wrapper"> </i>کاربران
                                                    </a>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a href="{{route('back.contacts')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-secondary">
                                                        <i class="lnr-map btn-icon-wrapper"> </i>تماس های کاربران
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="text-center">
                                            <div class="btn-group dropdown">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">مدیریت مطالب </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="col-lg-12 col-xl-6 box-body">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title"></h5>
                                        <div class="grid-menu grid-menu-2col">
                                            <div class="no-gutters row">
                                                <div class="col-sm-6">
                                                    <a href="{{route('back.categories')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-primary">
                                                        <i class="lnr-license btn-icon-wrapper"> </i>دسته بندی مطالب
                                                    </a>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a href="{{route('back.posts')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-secondary">
                                                        <i class="lnr-map btn-icon-wrapper"> </i>پست ها|مطالب
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="text-center">
                                            <div class="btn-group dropdown">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="box box-warning">
                        <div class="box-header with-border">
                            <h3 class="box-title">مدیریت تیکت ها </h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                            <div class="col-lg-12 col-xl-6 box-body">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title"></h5>
                                        <div class="grid-menu grid-menu-2col">
                                            <div class="no-gutters row">
                                                <div class="col-sm-6">
                                                    <a href="{{route('back.tickets')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-primary">
                                                        <i class="lnr-license btn-icon-wrapper"> </i>تیکت های کاربران|مشتریان
                                                    </a>
                                                </div>
                                                <div class="col-sm-6">
                                                    <a href="{{route('back.teamtickets')}}" target="_blank" class="btn-icon-vertical btn-square btn-transition btn btn-outline-secondary">
                                                        <i class="lnr-map btn-icon-wrapper"> </i>تیکت های همکاران|کارشناسان دورکار
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="divider"></div>
                                        <div class="text-center">
                                            <div class="btn-group dropdown">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>

                <section class="col-lg-6 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">آخرین مطالب</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>عنوان</th>
                                        <th>دسته بندی</th>
                                        <th>تاریخ ایجاد</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($posts as $post)
                                    <tr>
                                        <td><a href="{{route('back.posts.edit',$post->id)}}">{{$post->title}}</a></td>
                                        <td class="btn-group-vertical">
                                            @foreach(@$post->categories()->pluck('title') as $category)
                                                <span style="font-family: 'p30'; width: 100px;" class="  btn btn-sm btn-default" >{{$category}}</span><br>
                                            @endforeach
                                        </td>
                                        <td>{{\Hekmatinasser\Verta\Verta::instance($post->created_at)}}</td>
                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <a target="_blank" href="{{route('back.posts.create')}}" class="btn btn-sm btn-success">پست جدید</a>
                            <a target="_blank" href="{{route('back.posts')}}" class="btn btn-sm btn-warning">نمایش همه</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.nav-tabs-custom -->

                    <!-- Chat box -->
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">آخرین نظرات کاربران</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>عنوان</th>
                                        <th>برای پست</th>
                                        <th>تاریخ ایجاد</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($comments as $comment)
                                        <tr>
                                            <td><a href="{{route('back.comments.edit',$comment->id)}}">{!! mb_substr($comment->description,0,30).'..'!!} </a></td>
                                            @if($comment->post)
                                            <td>{{$comment->post->title}}</td>
                                            @endif
                                            <td>{{\Hekmatinasser\Verta\Verta::instance($comment->created_at)}}</td>
                                            <td>
                                                <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <a target="_blank" href="{{route('back.comments')}}" class="btn btn-sm btn-warning">نمایش همه</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box (chat box) -->



                </section>
                <!-- /.right col -->
                <!-- left col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-6 connectedSortable">
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">آخرین کاربران</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>نام</th>
                                        <th>ایمیل</th>
                                        <th>تاریخ ایجاد</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td><a href="{{route('back.users.edit',$user->id)}}">{{$user->name}}</a></td>
                                        <td>{{$user->email}}</td>
                                        <td>{{\Hekmatinasser\Verta\Verta::instance($user->created_at)}}</td>
                                        <td>
                                            <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <a target="_blank" href="{{route('back.users.create')}}" class="btn btn-sm btn-success">ثبت کاربر</a>
                            <a  target="_blank" href="{{route('back.users')}}" class="btn btn-sm btn-warning">نمایش همه</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>

                    <div class="box box-danger">
                        <div class="box-header with-border">
                            <h3 class="box-title">آخرین تماس کاربران</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>نام</th>
                                        <th>خلاصه پیام</th>
                                        <th>تاریخ ایجاد</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contacts as $contact)
                                        <tr>
                                            <td>{{$contact->name}}</td>
                                            <td><a href="{{route('back.contacts.edit',$contact->id)}}">{!! mb_substr($contact->body,0,30).'..'!!} </a></td>
                                            <td>{{\Hekmatinasser\Verta\Verta::instance($contact->created_at)}}</td>
                                            <td>
                                                <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <a target="_blank"  href="{{route('back.contacts')}}" class="btn btn-sm btn-warning">نمایش همه</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    @endcan
                    @can('isSupport')
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">آخرین سفارشات ثبت شده توسط مشتری</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>عنوان</th>
                                        <th>خلاصه سفارش</th>
                                        <th>تاریخ ایجاد</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td>{{$product->title}}</td>
                                            <td><a href="{{route('back.products.edit',$product->id)}}">{!! mb_substr($product->description,0,50).'..'!!} </a></td>
                                            <td>{{\Hekmatinasser\Verta\Verta::instance($product->created_at)}}</td>
                                            <td>
                                                <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <a target="_blank" href="{{route('back.products')}}" class="btn btn-sm btn-warning">نمایش همه</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    @endcan
                    @can('isAuthor')
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">آخرین مطالب</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table no-margin">
                                        <thead>
                                        <tr>
                                            <th>عنوان</th>
                                            <th>دسته بندی</th>
                                            <th>تاریخ ایجاد</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($posts as $post)
                                            <tr>
                                                <td><a href="{{route('back.posts.edit',$post->id)}}">{{$post->title}}</a></td>
                                                <td class="btn-group-vertical">
                                                    @foreach(@$post->categories()->pluck('title') as $category)
                                                        <span style="font-family: 'p30'; width: 100px;" class="  btn btn-sm btn-default" >{{$category}}</span><br>
                                                    @endforeach
                                                </td>
                                                <td>{{\Hekmatinasser\Verta\Verta::instance($post->created_at)}}</td>
                                                <td>
                                                    <div class="sparkbar" data-color="#00a65a" data-height="20"><canvas width="34" height="20" style="display: inline-block; width: 34px; height: 20px; vertical-align: top;"></canvas></div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.table-responsive -->
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer clearfix">
                                <a target="_blank" href="{{route('back.posts.create')}}" class="btn btn-sm btn-success">پست جدید</a>
                                <a target="_blank" href="{{route('back.posts')}}" class="btn btn-sm btn-warning">نمایش همه</a>
                            </div>
                            <!-- /.box-footer -->
                        </div>
                        @endcan

                </section>
                <!-- left col -->
            </div>
            <!-- /.row (main row) -->

        </section>
        <!-- /.content -->

    @endsection
