@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">پیغام برای سفارش: {{$message->product->title}} </h3>
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
                                        <i class="fa fa-globe"></i>{{$message->product->title}}
                                        <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($message->created_at)}}  </small>
                                    </h2>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-lg-12" style="margin: 40px">
                                    <span class="btn btn-md btn-primary">{{$message->message}}</span>
                                </div>
                                <div class="col-lg-12 table-bordered table-responsive pt-5">
                                    <table class="table table-striped" >
                                        <tehead><h4> اطلاعات سفارش :</h4></tehead>
                                        <tr>
                                            <td>شناسه سفارش :</td>
                                            <td>{{$message->product->codepro}}</td>
                                        </tr>
                                        <tr>
                                            <td>عنوان سفارش :</td>
                                            <td>{{$message->product->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>تعداد سفارش :</td>
                                            <td>{{$message->product->number}}</td>
                                        </tr>

                                        <tr>
                                            <td>دسته بندی سفارش  : </td>
                                            <td>{{$message->product->catorder->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>نوع منبع یابی  :</td>
                                            <td>{{$message->product->pack->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>تاریخ ثبت سفارش :</td>
                                            <td>{{\Hekmatinasser\Verta\Verta::instance($message->product->created_at)}}</td>
                                        </tr>
                                        <tr>
                                            <td> مبلغ کل :</td>
                                            <td>{{$message->product->amount}} تومان</td>
                                        </tr>
                                        <tr>
                                            <td>مبلغ تخفیف :</td>
                                            <td>{{$message->product->discountamount}} تومان</td>
                                        </tr>
                                        <tr>
                                            <td>قابل پرداخت:</td>
                                            <td>{{$message->product->totalamount}} تومان</td>
                                        </tr>
                                        @if($message->product->isiran)
                                            <tr>
                                                <td>درایران موجود است؟</td>
                                                @if($message->product->isiran == 'yes')
                                                <td>بله موجود است </td>
                                                @elseif($message->product->isiran == 'no')
                                                <td>خیر </td>
                                                @elseif($message->product->isiran == 'dont-know')
                                                <td>اطلاعی ندارم </td>
                                                @endif
                                            </tr>
                                        @endif
                                        @if($message->product->question)
                                            <tr>
                                                <td>دلیل اینکه ما را انتخاب کرده اید چه بوده است؟</td>

                                                <td>{{$message->product->question}}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td>شرح سفارش:</td>
                                            <td style="width:560px; text-align: justify;" >{!! $message->product->description !!}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </section>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{route('back.messages')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
