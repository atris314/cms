@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @foreach($product->photos as $photo)
                <td><img src="{{$photo->path}}" class="img-fluid" style="border-radius: 10px; width:350px;"  alt="{{$product->title}}"></td>
            @endforeach
        </div>
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">سفارش: {{$product->title}} </h3>
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
                                    <i class="fa fa-globe"></i>{{$product->title}}
                                    <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($product->created_at)}}  </small>
                                </h2>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-lg-12 table-bordered table-responsive">
                                <table class="table table-striped" >
                                    <tr>
                                        <td>نام شرکت :</td>
                                        <td>{{$product->user->companyname}}</td>
                                    </tr>
                                    <tr>
                                        <td>به آدرس : </td>
                                        <td>{{$product->user->address}}</td>
                                    </tr>
                                    <tr>
                                        <td>تلفن تماس :</td>
                                        <td>{{$product->user->phone}}</td>
                                    </tr>
                                    <tr>
                                        <td>تلفن همراه :</td>
                                        <td>{{$product->user->mobile}}</td>
                                    </tr>
                                    <tr>
                                        <td>ایمیل :</td>
                                        <td>{{$product->user->email}}</td>
                                    </tr>
                                    <tr>
                                        <td>کدپستی :</td>
                                        <td>{{$product->postcode}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-12 table-bordered table-responsive pt-5">
                                <table class="table table-striped" >
                                    <tehead><h4> اطلاعات سفارش :</h4></tehead>
                                    <tr>
                                        <td>شناسه سفارش :</td>
                                        <td>{{$product->codepro}}</td>
                                    </tr>
                                    <tr>
                                        <td>عنوان سفارش :</td>
                                        <td>{{$product->title}}</td>
                                    </tr>
                                    <tr>
                                        <td>تعداد سفارش :</td>
                                        <td>{{$product->number}}</td>
                                    </tr>
                                    <tr>
                                        <td>شماره قطعه یا شماره سریال  :</td>
                                        <td>{{$product->partnumber}}</td>
                                    </tr>
                                    <tr>
                                        <td>دسته بندی سفارش  : </td>
                                        <td>{{$product->catorder->title}}</td>
                                    </tr>
                                    <tr>
                                        <td>نوع منبع یابی  :</td>
                                        <td>{{$product->pack->title}}</td>
                                    </tr>
                                    <tr>
                                        <td>تاریخ ثبت سفارش :</td>
                                        <td>{{\Hekmatinasser\Verta\Verta::instance($product->created_at)}}</td>
                                    </tr>
                                    <tr>
                                        <td> مبلغ کل :</td>
                                        <td>{{$product->amount}} تومان</td>
                                    </tr>
                                    <tr>
                                        <td>مبلغ تخفیف :</td>
                                        <td>{{$product->discountamount}} تومان</td>
                                    </tr>
                                    <tr>
                                        <td>قابل پرداخت:</td>
                                        <td>{{$product->totalamount}} تومان</td>
                                    </tr>
                                    @if($product->isiran)
                                        <tr>
                                            <td>درایران موجود است؟</td>
                                            @if($product->isiran == 'yes')
                                                <td>بله موجود است </td>
                                            @elseif($product->isiran == 'no')
                                                <td>خیر </td>
                                            @elseif($product->isiran == 'dont-know')
                                                <td>اطلاعی ندارم </td>
                                            @endif
                                        </tr>
                                    @endif
                                    @if($product->question)
                                        <tr>
                                            <td>دلیل اینکه ما را انتخاب کرده اید چه بوده است؟</td>

                                            <td>{{$product->question}}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>شرح سفارش:</td>
                                        <td style="width:560px; text-align: justify;" >{!! $product->description !!}</td>
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
                                @if($product['status']==0)
                                    <a  class="btn btn-light" >ثبت شد</a>
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
                                    <a  class="label pull-center bg-blue-gradient" >درانتظار پرداخت هزینه ترخیص</a>
                                @elseif($product->status==11)
                                    <a  class="label pull-center bg-olive" >اطلاعات سفارش تکمیل شد</a>
                                @elseif($product->status==12)
                                    <a  class="label pull-center bg-olive" >در انتظار تکمیل اطلاعات سفارش</a>
                                @elseif($product->status==13)
                                    <a  class="label pull-center bg-red" >کاربر انصراف داد</a>
                                @endif
                            </div>
                        </div>
                        <!-- /.row -->
                        <br><br><br>
                        <!-- this row will not appear when printing -->
                        <div class="row no-print mt-5">
                            <div class="col-xs-12">
                                <a href="{{route('back.productstoreprint',$product->id)}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> پرینت</a>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <a href="{{route('back.productstore')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </div>
        </div>
    </div>
@endsection
