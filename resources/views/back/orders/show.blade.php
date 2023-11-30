@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">سفارش: {{$payment->product->title}} </h3>
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
                                        <i class="fa fa-globe"></i>{{$payment->product->title}}
                                        <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($payment->product->created_at)}}  </small>
                                    </h2>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-lg-12 table-bordered table-responsive">
                                        <table class="table table-striped" >
                                            <tr>
                                                <td>شماره فاکتور :</td>
                                                <td>{{$payment->order_id}}</td>
                                            </tr>
                                            <tr>
                                                <td>مبلغ پرداخت : </td>
                                                <td>{{$payment->amount}} ریال </td>
                                            </tr>
                                            <tr>
                                                <td>عنوان پرداخت :</td>
                                                <td>{{$payment->order->desc}}</td>
                                            </tr>
                                        </table>
                                </div>
                                <div class="col-lg-12 table-bordered table-responsive">
                                    @if($payment->user)
                                    <table class="table table-striped" >
                                        <tr>
                                            <td>نام شرکت :</td>
                                            <td>{{$payment->user->companyname}}</td>
                                        </tr>
                                        <tr>
                                            <td>به آدرس : </td>
                                            <td>{{$payment->user->address}}</td>
                                        </tr>
                                        <tr>
                                            <td>تلفن تماس :</td>
                                            <td>{{$payment->user->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>تلفن همراه :</td>
                                            <td>{{$payment->user->mobile}}</td>
                                        </tr>
                                        <tr>
                                            <td>ایمیل :</td>
                                            <td>{{$payment->user->email}}</td>
                                        </tr>
                                        <tr>
                                            <td>کدپستی :</td>
                                            <td>{{$payment->user->postcode}}</td>
                                        </tr>
                                    </table>
                                        @endif
                                </div>
                                <div class="col-lg-12 table-bordered table-responsive pt-5">
                                    <table class="table table-striped" >
                                        <tehead><h4> اطلاعات سفارش :</h4></tehead>
                                        <tr>
                                            <td>شناسه سفارش :</td>
                                            <td>{{$payment->product->codepro}}</td>
                                        </tr>
                                        <tr>
                                            <td>عنوان سفارش :</td>
                                            <td>{{$payment->product->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>تعداد سفارش :</td>
                                            <td>{{$payment->product->number}}</td>
                                        </tr>

                                        <tr>
                                            <td>دسته بندی سفارش  : </td>
                                            <td>{{$payment->product->catorder->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>نوع منبع یابی  :</td>
                                            <td>{{$payment->product->pack->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>تاریخ ثبت سفارش :</td>
                                            <td>{{\Hekmatinasser\Verta\Verta::instance($payment->product->created_at)}}</td>
                                        </tr>
                                        <tr>
                                            <td> مبلغ کل :</td>
                                            <td>{{$payment->product->amount}} تومان</td>
                                        </tr>
                                        <tr>
                                            <td>مبلغ تخفیف :</td>
                                            <td>{{$payment->product->discountamount}} تومان</td>
                                        </tr>
                                        <tr>
                                            <td>قابل پرداخت:</td>
                                            <td>{{$payment->product->totalamount}} تومان</td>
                                        </tr>
                                        <tr>
                                            <td>شرح سفارش:</td>
                                            <td style="width:560px; text-align: justify;" >{!! $payment->product->description !!}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>


                            <br><br><br>
                            <div class="row">
                                <div class="col-lg-2">
                                    <p>وضعیت سفارش : </p>
                                </div>
                                <div class="col-lg-3">
                                    @if($payment->product['status']==0)
                                    <a  class="btn btn-light" >ثبت شد</a>
                                    @elseif($payment->product['status']==1)
                                        <a  class="label pull-center bg-navy" >کوپن تخفیف خود را استفاده کرد</a>
                                    @elseif($payment->product['status']==2)
                                        <a  class="label pull-center bg-olive" >پرداخت منبع یابی</a>
                                    @elseif($payment->product['status']==3)
                                        <a class="label pull-center bg-orange">سفارش حاضر شده در انتظار پرداخت</a>
                                    @elseif($payment->product['status']==4)
                                        <a  class="label pull-center bg-purple" >پرداخت نهایی انجام شد</a>
                                    @elseif($payment->product['status']==5)
                                        <a  class="label pull-center bg-teal" >در دست اقدام</a>
                                    @elseif($payment->product['status']==6)
                                        <a  class="label pull-center bg-blue-active" >درخواست مجدد</a>
                                    @elseif($payment->product['status']==7)
                                        <a  class="label pull-center bg-fuchsia" >ترجمه شد</a>
                                    @elseif($payment->product->status==8)
                                        <a  class="label pull-center bg-yellow-gradient" >هزینه خرید کالا پرداخت شد</a>
                                    @elseif($payment->product->status==9)
                                        <a  class="label pull-center bg-green-gradient" >هزینه ترخیص کالا پرداخت شد</a>
                                    @elseif($payment->product->status==10)
                                        <a  class="label pull-center bg-blue-gradient" >درانتظار پرداخت هزینه ترخیص</a>
                                    @elseif($payment->product->status==11)
                                        <a  class="label pull-center bg-olive" >اطلاعات سفارش تکمیل شد</a>
                                    @elseif($payment->product->status==12)
                                        <a  class="label pull-center bg-olive" >در انتظار تکمیل اطلاعات سفارش</a>
                                    @elseif($payment->product->status==13)
                                        <a  class="label pull-center bg-olive" >کاربر انصراف داد</a>
                                    @elseif($payment->product->status==14)
                                        <a  class="label pull-center bg-blue-gradient" >سفارش حاضر است</a>
                                    @elseif($payment->product->status==15)
                                        <a  class="label pull-center bg-orange" >حذف شده توسط کاربر(لغو)</a>
                                    @elseif($payment->product->status==16)
                                        <a  class="label pull-center bg-green-gradient" >تایید الکترونیکی انجام شد</a>
                                    @endif
                                </div>
                                </div>
                            <!-- /.row -->
                            <br><br><br>
                            <!-- this row will not appear when printing -->
                            <div class="row no-print mt-5">
                                <div class="col-xs-12">
                                    <a href="{{route('back.paymentsprint',$payment->id)}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> پرینت</a>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{route('back.payments')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
