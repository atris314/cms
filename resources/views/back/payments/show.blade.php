@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">سفارش: {{$nextpayment->product->title}} </h3>
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
                                        <i class="fa fa-globe"></i>{{$nextpayment->product->title}}
                                        <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($nextpayment->product->created_at)}}  </small>
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
                                                <td>{{$nextpayment->order_id}}</td>
                                            </tr>
                                            <tr>
                                                <td>مبلغ پرداخت : </td>
                                                <td>{{$nextpayment->amount}} ریال </td>
                                            </tr>
                                            <tr>
                                                <td>عنوان پرداخت :</td>
                                                <td>{{$nextpayment->ordernextpay->payer_desc}}</td>
                                            </tr>
                                            <tr>
                                                <td>شناسه پیگیری تراکنش :</td>
                                                <td>{{$nextpayment->track_id}}</td>
                                            </tr>
                                            <tr>
                                                <td>تاریخ پرداخت :</td>
                                                <td>{{\Hekmatinasser\Verta\Verta::instance($nextpayment->created_at)}}</td>
                                            </tr>
                                        </table>
                                </div>
                                <div class="col-lg-12 table-bordered table-responsive">
                                    @if($nextpayment->user)
                                    <table class="table table-striped" >
                                        <tr>
                                            <td>نام شرکت :</td>
                                            <td>{{$nextpayment->user->companyname}}</td>
                                        </tr>
                                        <tr>
                                            <td>به آدرس : </td>
                                            <td>{{$nextpayment->user->address}}</td>
                                        </tr>
                                        <tr>
                                            <td>استان  : </td>
                                            <td>
                                                {{$nextpayment->user->province->name}}
                                            </td>
                                        </tr>
                                        @if(isset($nextpayment->user->city_id))
                                        <tr>
                                            <td>شهر  : </td>
                                            <td>{{$nextpayment->user->city->name}}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <td>کدپستی :</td>
                                            <td>{{$nextpayment->user->postcode}}</td>
                                        </tr>
                                        <tr>
                                            <td>تلفن تماس :</td>
                                            <td>{{$nextpayment->user->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>تلفن همراه :</td>
                                            <td>{{$nextpayment->user->mobile}}</td>
                                        </tr>
                                        <tr>
                                            <td>ایمیل :</td>
                                            <td>{{$nextpayment->user->email}}</td>
                                        </tr>

                                    </table>
                                        @endif
                                </div>
                                <div class="col-lg-12 table-bordered table-responsive pt-5">
                                    <table class="table table-striped" >
                                        <tehead><h4> اطلاعات سفارش :</h4></tehead>
                                        <tr>
                                            <td>شناسه سفارش :</td>
                                            <td>{{$nextpayment->product->codepro}}</td>
                                        </tr>
                                        <tr>
                                            <td>عنوان سفارش :</td>
                                            <td>{{$nextpayment->product->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>تعداد سفارش :</td>
                                            <td>{{$nextpayment->product->number}}</td>
                                        </tr>

                                        <tr>
                                            <td>دسته بندی سفارش  : </td>
                                            <td>{{$nextpayment->product->catorder->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>نوع منبع یابی  :</td>
                                            <td>{{$nextpayment->product->pack->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>تاریخ ثبت سفارش :</td>
                                            <td>{{\Hekmatinasser\Verta\Verta::instance($nextpayment->product->created_at)}}</td>
                                        </tr>
                                        @if($nextpayment->ordernextpay->payer_desc=='پرداخت نهایی')
                                            <tr>
                                                <td> مبلغ کل پرداخت شده :</td>
                                                <td>{{$nextpayment->ordernextpay->amount}} ریال</td>
                                            </tr>
                                        @else
                                        <tr>
                                            <td> مبلغ کل :</td>
                                            <td>{{$nextpayment->product->amount}} تومان</td>
                                        </tr>
                                        <tr>
                                            <td>مبلغ تخفیف :</td>
                                            <td>{{$nextpayment->product->discountamount}} تومان</td>
                                        </tr>
                                        <tr>
                                            <td>قابل پرداخت:</td>
                                            <td>{{$nextpayment->product->totalamount}} تومان</td>
                                        </tr>
                                        @endif

                                        <tr>
                                            <td>شرح سفارش:</td>
                                            <td style="width:560px; text-align: justify;" >{!! $nextpayment->product->description !!}</td>
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
                                    @if($nextpayment->product['status']==0)
                                    <a  class="btn btn-light" >ثبت شد</a>
                                    @elseif($nextpayment->product['status']==1)
                                        <a  class="label pull-center bg-navy" >کوپن تخفیف خود را استفاده کرد</a>
                                    @elseif($nextpayment->product['status']==2)
                                        <a  class="label pull-center bg-olive" >پرداخت منبع یابی</a>
                                    @elseif($nextpayment->product['status']==3)
                                        <a class="label pull-center bg-orange">سفارش حاضر شده در انتظار پرداخت</a>
                                    @elseif($nextpayment->product['status']==4)
                                        <a  class="label pull-center bg-purple" >پرداخت نهایی انجام شد</a>
                                    @elseif($nextpayment->product['status']==5)
                                        <a  class="label pull-center bg-teal" >در دست اقدام</a>
                                    @elseif($nextpayment->product['status']==6)
                                        <a  class="label pull-center bg-blue-active" >درخواست مجدد</a>
                                    @elseif($nextpayment->product['status']==7)
                                        <a  class="label pull-center bg-fuchsia" >ترجمه شد</a>
                                    @elseif($nextpayment->product->status==8)
                                        <a  class="label pull-center bg-yellow-gradient" >هزینه خرید کالا پرداخت شد</a>
                                    @elseif($nextpayment->product->status==9)
                                        <a  class="label pull-center bg-green-gradient" >هزینه ترخیص کالا پرداخت شد</a>
                                    @elseif($nextpayment->product->status==10)
                                        <a  class="label pull-center bg-blue-gradient" >درانتظار پرداخت هزینه ترخیص</a>
                                    @elseif($nextpayment->product->status==11)
                                        <a  class="label pull-center bg-olive" >اطلاعات سفارش تکمیل شد</a>
                                    @elseif($nextpayment->product->status==12)
                                        <a  class="label pull-center bg-olive" >در انتظار تکمیل اطلاعات سفارش</a>
                                    @elseif($nextpayment->product->status==13)
                                        <a  class="label pull-center bg-olive" >کاربر انصراف داد</a>
                                    @elseif($nextpayment->product->status==14)
                                        <a  class="label pull-center bg-blue-gradient" >سفارش حاضر است</a>
                                    @elseif($nextpayment->product->status==15)
                                        <a  class="label pull-center bg-orange" >حذف شده توسط کاربر(لغو)</a>
                                    @elseif($nextpayment->product->status==16)
                                        <a  class="label pull-center bg-green-gradient" >تایید الکترونیکی انجام شد</a>
                                    @endif
                                </div>
                                </div>
                            <!-- /.row -->
                            <br><br><br>
                            <!-- this row will not appear when printing -->
                            <div class="row no-print mt-5">
                                <div class="col-xs-12">
                                    <a href="{{route('back.nextpaymentsprint',$nextpayment->id)}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> پرینت</a>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{route('back.nextpayments')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
