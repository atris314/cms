@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-10 offset-lg-1 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">سفارش: {{$present->product->title}} | Order :{{$present->subject}} </h3>
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
                                        <i class="fa fa-globe"></i>{{$present->product->title}}
                                        <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($present->created_at)}} | {{\Hekmatinasser\Verta\Verta::instance($present->product->created_at)}} </small>
                                    </h2>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-lg-12 table-bordered table-responsive pt-5">
                                    <div class="row">
                                        <b>تصاویر| images : </b> <br>
                                        @foreach($present->photos as $photo)
                                            <img src="{{$photo->path}}" class="img-fluid" style="border-radius: 10px; width:250px;"  alt="{{$present->title}}">
                                        @endforeach
                                    </div>
                                    <table class="table table-striped" >

                                        <tehead><h4> اطلاعات سفارش :</h4></tehead>
                                        <tr>
                                            <td>شناسه سفارش دهنده :</td>
                                            @foreach(@$present->product->user()->pluck('code') as $code)
                                               <td  style="text-align: right; direction: ltr">{{$code}}</td>
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <td>کد سفارش :</td>
                                            <td>{{$present->product->codepro}}</td>
                                        </tr>
                                        <tr>
                                            <td>عنوان سفارش :</td>
                                            <td>{{$present->product->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>دسته بندی سفارش  : </td>
                                            <td>{{$present->product->catorder->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>نوع منبع یابی  :</td>
                                            <td>{{$present->product->pack->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>تاریخ ثبت سفارش :</td>
                                            <td>{{\Hekmatinasser\Verta\Verta::instance($present->product->created_at)}}</td>
                                        </tr>
                                        <tr>
                                            <td>شرح سفارش:</td>
                                            <td style="width:560px; text-align: justify;" >{!! $present->product->description !!}</td>
                                        </tr>



                                    </table>
                                </div>
                            </div>

                            <div class="row invoice-info">
                                <div class="col-lg-12 table-bordered table-responsive pt-5">
                                    <table class="table table-striped" >
                                        <tehead><h4><b>اطلاعات سفارش حاضر شده :</b> </h4></tehead>
                                        <tr>
                                            <td><b> کد سفارش:</b> </td>
                                            <td>{{$present->productcode}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>زمان تحویل سفارش  :</b> </td>
                                            <td>{{$present->deliverytime}}</td>
                                        </tr>
                                        <tr>
                                            <td><b>هزینه خرید کالا : </b></td>
                                            <td>{{$present->price}} تومان </td>
                                        </tr>
                                        <tr>
                                            <td><b>هزینه ترخیص کالا : </b></td>
                                            <td>@if(isset($present->releaseprice)) {{$present->releaseprice}} تومان  @else نامشخص @endif  </td>
                                        </tr>
                                        <tr>
                                            <td><b>هزینه منبع یابی : </b></td>
                                            <td>{{$packprice}} تومان </td>
                                        </tr>
                                        <tr>
                                            <td><b>مبلغ قابل پرداخت : </b></td>
                                            <td>بعد از اعمال محاسبات توسط کاربر مشخص می شود</td>
                                        </tr>
                                        <tr>
                                            <td><b>تاریخ ثبت سفارش آماده شده :</b> </td>
                                            <td>{{\Hekmatinasser\Verta\Verta::instance($present->created_at)}}</td>
                                        </tr>
                                        <tr class="mt-5">
                                            <td><b>آخرین وضعیت سفارش:</b></td>
                                            @if($present['status'] == 0)
                                                <td style="width:560px; text-align: justify;" class="label pull-center bg-yellow-gradient mt-5"  >در انتظار پرداخت</td>
                                            @elseif($present['status']== 1)
                                                <td style="width:560px; text-align: justify;" class="label pull-center bg-green-gradient mt-5" >پرداخت شده</td>
                                            @elseif($present['status'] == 2 )
                                                <td style="width:560px; text-align: justify;" class="label pull-center bg-navy mt-5" >انصراف توسط کاربر</td>
                                            @elseif($present->status==3)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-blue-gradient mt-5" >در انتظار پرداخت هزینه ترخیص</td>
                                            @elseif($present->status==4)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-blue-gradient mt-5" >هزینه خرید کالا پرداخت شد</td>
                                            @elseif($present->status==5)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-blue-gradient mt-5" >هزینه ترخیص کالا پرداخت شد</td>
                                            @endif
                                        </tr>
                                        <tr class="mt-5">
                                        <td><b> وضعیت سفارش:</b></td>
                                            @if($present->product->status==0)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-maroon" >ثبت شد</td>
                                            @elseif($present->product->status==1)
                                                <td style="width:560px; text-align: justify;" class="label pull-center bg-navy" >کوپن تخفیف خود را استفاده کرد</td>
                                            @elseif($present->product->status==2)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-olive" >پرداخت منبع یابی</td>
                                            @elseif($present->product->status==3)
                                                <td style="width:560px; text-align: justify;" class="label pull-center bg-orange">سفارش حاضر شده در انتظار پرداخت</td>
                                            @elseif($present->product->status==4)
                                                <td style="width:560px; text-align: justify;" class="label pull-center bg-purple" >پرداخت نهایی انجام شد</td>
                                            @elseif($present->product->status==5)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-teal" >در دست اقدام</td>
                                            @elseif($present->product->status==6)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-blue-active" >درخواست مجدد</td>
                                            @elseif($present->product->status==7)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-fuchsia" >ترجمه شد</td>
                                            @elseif($present->product->status==8)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-yellow-gradient" >هزینه خرید کالا پرداخت شد</td>
                                            @elseif($present->product->status==9)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-green-gradient" >هزینه ترخیص کالا پرداخت شد</td>
                                            @elseif($present->product->status==10)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-blue-gradient" >هزینه ترخیص کالا تعیین شد</td>
                                            @elseif($present->product->status==11)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-olive" >اطلاعات سفارش تکمیل شد</td>
                                            @elseif($present->product->status==12)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-olive" >در انتظار تکمیل اطلاعات سفارش</td>
                                            @elseif($present->product->status==13)
                                                <td style="width:560px; text-align: justify;"  class="label pull-center bg-olive" >کاربر انصراف داد</td>
                                            @elseif($present->product->status==14)
                                                <td style="width:560px; text-align: justify;" class="label pull-center bg-blue-gradient" >سفارش حاضر است</td>
                                            @elseif($present->product->status==15)
                                                <td style="width:560px; text-align: justify;" class="label pull-center bg-orange" >حذف شده توسط کاربر(لغو)</td>
                                            @elseif($present->product->status==16)
                                                <td style="width:560px; text-align: justify;" class="label pull-center bg-green-gradient" >تایید الکترونیکی انجام شد</td>
                                            @endif
                                        </tr>
                                        @if(isset($present->confirm))
                                        <tr>
                                            <td><b>تایید کاربر : </b></td>
                                            <td>کاربر، اطلاعات سفارش و منبع یابی را تایید کرد<i class="fa fa-check-square-o" style="color: #24c39e;font-size: 14pt;" aria-hidden="true"></i></td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td><b>توضیحات:</b></td>
                                            <td style="width:560px; text-align: justify;" >{!! $present->description !!}</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <br><br><br>
                            <br><br><br>
                            <!-- this row will not appear when printing -->
                            <div class="row no-print mt-5">
                                <div class="col-xs-6">
                                    <a href="{{route('back.presentsprint',$present->id)}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> پرینت</a>
                                </div>
{{--                                <a href="{{route('back.presents.create',$present->id)}}" class="btn btn-success"><i class="fa fa-send"></i>ایجاد صورت حساب ترخیص کالا</a>--}}
                            </div>
                        </section>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{route('back.presents')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
