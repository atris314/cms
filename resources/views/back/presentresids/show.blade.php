@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-6">
            @foreach($presentresid->photos as $photo)
                <td><img src="{{$photo->path}}" class="img-fluid" style="border-radius: 10px; width:350px;"  alt="{{$presentresid->title}}"></td>
            @endforeach
        </div>
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title"> {{$presentresid->user->name}} </h3>
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
                                        <i class="fa fa-globe"></i>{{$presentresid->user->name}}
                                        <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($presentresid->created_at)}}  </small>
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
                                            <td>{{$presentresid->user->lastname}}</td>
                                        </tr>
                                        <tr>
                                            <td>کد کاربر :</td>
                                            <td>{{$presentresid->user->code}}</td>
                                        </tr>
                                        <tr>
                                            <td>نام شرکت :</td>
                                            <td>{{$presentresid->user->companyname}}</td>
                                        </tr>
                                        <tr>
                                            <td>به آدرس : </td>
                                            <td>{{$presentresid->user->address}}</td>
                                        </tr>
                                        <tr>
                                            <td>تلفن تماس :</td>
                                            <td>{{$presentresid->user->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>تلفن همراه :</td>
                                            <td>{{$presentresid->user->mobile}}</td>
                                        </tr>
                                        <tr>
                                            <td>ایمیل :</td>
                                            <td>{{$presentresid->user->email}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row invoice-info">
                                <div class="col-lg-12 table-bordered table-responsive">
                                    <table class="table table-striped" >
                                        <tehead><h4> اطلاعات سفارش :</h4></tehead>
                                        <tr>
                                            <td>کد سفارش :</td>
                                            <td>{{$presentresid->present->productcode}}</td>
                                        </tr>
                                        <tr>
                                            <td>زمان تحویل سفارش: </td>
                                            <td>{{$presentresid->present->deliverytime}}</td>
                                        </tr>
                                        <tr>
                                            <td>هزینه خرید کالا :</td>
                                            <td>{{$presentresid->present->price}}</td>
                                        </tr>
                                        <tr>
                                            <td>هزینه ترخیص کالا :</td>

                                            <td>@if(isset($presentresid->present->releaseprice)) {{$presentresid->present->releaseprice}} تومان  @else نامشخص @endif</td>
                                        </tr>
                                        <tr>
                                            <td>مبلغ قابل پرداخت:</td>
                                            <td>{{$presentresid->present->totalprice}} تومان </td>
                                        </tr>

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
                        <a href="{{route('back.presentresids')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
