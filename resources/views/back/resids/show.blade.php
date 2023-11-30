@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-6">
            @if($resid->photo_id)
                <td><img src="{{$resid->photo->path}}" class="img-fluid" style="border-radius: 10px; width: 100%;"  alt="{{$resid->user->name}}"></td>
            @endif
        </div>
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title"> {{$resid->user->name}} </h3>
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
                                        <i class="fa fa-globe"></i>{{$resid->user->name}}
                                        <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($resid->created_at)}}  </small>
                                    </h2>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-lg-12 table-bordered table-responsive">
                                    <table class="table table-striped" >
                                        <tehead><h4> اطلاعات کاربر :</h4></tehead>
                                        <tr>
                                            <td>نام و نام خانوادگی :</td>
                                            <td>{{$resid->user->lastname}}</td>
                                        </tr>
                                        <tr>
                                            <td>کد کاربر :</td>
                                            <td>{{$resid->user->code}}</td>
                                        </tr>
                                        <tr>
                                            <td>نام شرکت :</td>
                                            <td>{{$resid->user->companyname}}</td>
                                        </tr>
                                        <tr>
                                            <td>به آدرس : </td>
                                            <td>{{$resid->user->address}}</td>
                                        </tr>
                                        <tr>
                                            <td>تلفن تماس :</td>
                                            <td>{{$resid->user->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>تلفن همراه :</td>
                                            <td>{{$resid->user->mobile}}</td>
                                        </tr>
                                        <tr>
                                            <td>ایمیل :</td>
                                            <td>{{$resid->user->email}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row invoice-info">
                                <div class="col-lg-12 table-bordered table-responsive">
                                    <table class="table table-striped" >
                                        <tehead><h4> اطلاعات سفارش :</h4></tehead>
                                        @if($resid->product)
                                        <tr>
                                            <td>کد سفارش :</td>
                                            <td>{{$resid->product->codepro}}</td>
                                        </tr>
                                        <tr>
                                            <td>عنوان سفارش  :</td>
                                            <td>{{$resid->product->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>تعداد سفارش: </td>
                                            <td>{{$resid->product->number}}</td>
                                        </tr>
                                        <tr>
                                            <td>نوع منبع یابی :</td>
                                            <td>{{$resid->product->pack->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>دسته بندی :</td>
                                            <td>{{$resid->product->catorder->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>مبلغ نهایی:</td>
                                            <td>{{$resid->product->totalamount}}</td>
                                        </tr>
                                        <tr>
                                            <td>شرح سفارش:</td>
                                            <td>{!! $resid->product->description !!}</td>
                                        </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            <!-- /.row -->
                            <br><br><br>
                            <!-- this row will not appear when printing -->
                            <div class="row no-print mt-5">
{{--                                <div class="col-xs-12">--}}
{{--                                    <a href="{{route('back.productprint',$product->id)}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> پرینت</a>--}}
{{--                                </div>--}}
                            </div>
                        </section>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{route('back.resids')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
