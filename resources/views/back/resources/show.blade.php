@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-10 offset-2 justify-content-md-center">
            <div class="box box-danger col-md-12  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">درخواست همکاری به عنوان منبع: {{$addsource->lastname}} </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <section class="invoice">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-xs-12">
                                <h2 class="page-header">
                                    <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($addsource->created_at)}}  </small>
                                </h2>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-lg-12 table-bordered table-responsive">
                                <table class="table table-striped" >
                                    <tehead><h4 style="background: #da5a6b;color: white;padding: 15px;"><b>اطلاعات درخواست دهنده همکاری به عنوان منبع :</b>  </h4></tehead>
                                    <tr>
                                        <td>نام و نام خانوادگی :</td>
                                            <td>{{$addsource->name}}-{{$addsource->lastname}}</td>
                                    </tr>
                                    <tr>
                                        <td>شماره موبایل :</td>
                                        <td>{{$addsource->mobile}}</td>
                                    </tr>
                                    <tr>
                                        <td>آدرس ایمیل :</td>
                                        <td>{{$addsource->email}}</td>
                                    </tr>

                                    <tr>
                                        <td> استان/شهر : </td>
                                        <td>{{$addsource->province->name}}/{{$addsource->city->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>نام شرکت/نام برند :</td>
                                        <td>{{$addsource->brandname}}</td>

                                    </tr>
                                    <tr>
                                        <td>سمت کاری :</td>
                                        <td>{{$addsource->job}}</td>
                                    </tr>
                                    <tr>
                                        <td>آدرس وب سایت :</td>
                                        <td>{{$addsource->website}}</td>
                                    </tr>
                                    <tr>
                                        <td>آدرس و مشخصات دقیق محل کار و متراژ :</td>
                                        <td>{{$addsource->address}}</td>
                                    </tr>
                                    <tr>
                                        <td>زمینه کاری :</td>
                                        <td>{{$addsource->catorder->title}}</td>
                                    </tr>
                                    <tr>
                                        <td>مدت زمان فعالیت در این حوزه :</td>
                                        <td>{{$addsource->activitytime}}</td>
                                    </tr>
                                    <tr>
                                        <td>در چه زمینه ای و به چه صورت قصد همکاری با یابانه را دارید لطفا توضیح دهید :</td>
                                        <td>{!! $addsource->description !!}</td>
                                    </tr>
                                    <tr>
                                        <td>تاریخ ارسال :</td>
                                        <td>{{\Hekmatinasser\Verta\Verta::instance($addsource->created_at)}}</td>
                                    </tr>
                                </table>
                            </div>

                        </div>

                        <br><br><br>
                        <!-- this row will not appear when printing -->
                        <div class="row no-print mt-5">
                            <div class="col-xs-12">
                                <a href="{{route('back.resourcesprint',$addsource->id)}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> پرینت</a>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <a href="{{route('back.resources')}}"  class=" label pull-center bg-red" style="padding: 6px;">بازگشت</a>
                </div>
            </div>
        </div>
    </div>
@endsection
