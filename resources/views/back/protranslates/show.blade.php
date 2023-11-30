@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-10 offset-lg-1 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">سفارش: {{$protranslate->product->title}} | Order :{{$protranslate->subject}} </h3>
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
                                        <i class="fa fa-globe"></i>{{$protranslate->product->title}} | {{$protranslate->subject}}
                                        <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($protranslate->created_at)}} | {{$protranslate->product->created_at}} </small>
                                    </h2>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-lg-12 table-bordered table-responsive pt-5">
                                    <div class="row">
                                       <b>تصاویر| images : </b> <br>
                                        @foreach($protranslate->product->photos as $photo)
                                           <img src="{{$photo->path}}" class="img-fluid" style="border-radius: 10px; width:250px;"  alt="{{$protranslate->product->title}}">
                                        @endforeach
                                    </div>


                                    <table class="table table-striped" >

                                        <tehead><h4> اطلاعات سفارش :</h4></tehead>
                                        <tr>

                                        </tr>
                                        <tr>
                                            <td>شناسه سفارش دهنده :</td>
                                            @foreach(@$protranslate->product->user()->pluck('code') as $code)
                                               <td  style="text-align: right; direction: ltr">{{$code}}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>کد سفارش :</td>
                                            <td>{{$protranslate->product->codepro}}</td>
                                        </tr>
                                        <tr>
                                            <td>تعداد سفارش :</td>
                                            <td>{{$protranslate->product->number}}</td>
                                        </tr>
                                        <tr>
                                            <td>عنوان سفارش :</td>
                                            <td>{{$protranslate->product->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>دسته بندی سفارش  : </td>
                                            <td>{{$protranslate->product->catorder->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>نوع منبع یابی  :</td>
                                            <td>{{$protranslate->product->pack->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>تاریخ ثبت سفارش :</td>
                                            <td>{{\Hekmatinasser\Verta\Verta::instance($protranslate->product->created_at)}}</td>
                                        </tr>
                                        <tr>
                                            <td>شرح سفارش:</td>
                                            <td style="width:560px; text-align: justify;" >{!! $protranslate->product->description !!}</td>
                                        </tr>



                                    </table>
                                </div>
                            </div>

                            <div class="row invoice-info">
                                <div class="col-lg-12 table-bordered table-responsive pt-5">
                                    <table class="table table-striped" dir="ltr" >
                                        <tehead dir="ltr"><h4><b>order information :</b> </h4></tehead>
                                        <tr>
                                            <td><b>Order Code :</b> </td>
                                            <td>{{$protranslate->product->codepro}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Order Title|Subject :</b> </td>
                                            <td>{{$protranslate->subject}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>Order Cetegory : </b></td>
                                            <td>{{$protranslate->category}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>created :</b> </td>
                                            <td>{{$protranslate->product->created_at}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>specification:</b></td>
                                            <td style="width:560px; text-align: justify;" >{!! $protranslate->description !!}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <br><br><br>
                            <br><br><br>
                            <!-- this row will not appear when printing -->
                            <div class="row no-print mt-5">
                                <div class="col-xs-6">
                                    <a href="{{route('back.protranslatesprint',$protranslate->id)}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> پرینت</a>
                                </div>
                                <div class="col-xs-6 text-left">
                                    <form action="{{route('back.protranslates.prosent',$protranslate->id)}}" method="post" style="display: inline-block">
                                        @csrf
                                        <button  type="submit" class="btn btn-success"><i class="fa fa-send"></i> ارسال نهایی به چین</button>
                                    </form>

{{--                                    <form action="{{route('back.protranslates.proSentUser',$protranslate->id)}}" method="post" style="display: inline-block">--}}
{{--                                        @csrf--}}
{{--                                        <button type="submit" class="btn btn-success"><i class="fa fa-send"></i>فرم ارسال به کاربر</button>--}}
{{--                                    </form>--}}

                                    <a href="{{route('back.presents.create',$protranslate->id)}}" class="btn btn-success"><i class="fa fa-send"></i>فرم ارسال سفارش به کاربر</a>

                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{route('back.protranslates')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
