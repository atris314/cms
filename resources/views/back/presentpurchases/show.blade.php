@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
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
                                        <i class="fa fa-globe"></i>{{$presentaction->present->title}}
                                        <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($presentaction->created_at)}}  </small>
                                    </h2>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-lg-12 table-bordered table-responsive pt-5">
                                    <table class="table table-striped" >
                                        <tehead><h4> اطلاعات تراکنش :</h4></tehead>
                                        <tr>
                                            <td>مبلغ پرداخت:</td>
                                            <td>{{$presentaction->paid}} تومان</td>
                                        </tr>
                                        <tr>
                                            <td> شناسه پیگیری تراکنش:</td>
                                            <td>
                                            @if(!empty($reference_id))
                                                    {{$reference_id}}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>کد کاربری :</td>
                                            <td dir="ltr" style="text-align: right">{{$presentaction->user->code}}</td>
                                        </tr>
                                        <tr>
                                            <td>نام کاربری :</td>
                                            <td>{{$presentaction->user->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>شناسه سفارش :</td>
                                            <td>{{$presentaction->present->product->codepro}}</td>
                                        </tr>
                                        <tr>
                                            <td>تعداد سفارش :</td>
                                            <td>{{$presentaction->present->product->number}}</td>
                                        </tr>
                                        <tr>
                                            <td>عنوان سفارش :</td>
                                            <td>{{$presentaction->present->product->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>دسته بندی سفارش  : </td>
                                            <td>{{$presentaction->present->product->catorder->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>نوع منبع یابی  :</td>
                                            <td>{{$presentaction->present->product->pack->title}}</td>
                                        </tr>
                                        <tr>
                                            <td>تاریخ ثبت سفارش :</td>
                                            <td>{{\Hekmatinasser\Verta\Verta::instance($presentaction->present->created_at)}}</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>


                            <br><br><br>
                            <div class="row">
                                <div class="col-lg-2">
                                    <p>وضعیت تراکنش : </p>
                                </div>
                                <div class="col-lg-3">
                                    @if($presentaction['status']==0)
                                    <a  class="btn btn-light" >تراکنش ناموفق</a>
                                    @elseif($presentaction['status']==1)
                                        <a  class="label pull-center bg-navy" >تراکنش نامشخص درحال انجام</a>
                                    @elseif($presentaction['status']==2)
                                        <a  class="label pull-center bg-olive" >تراکنش موفق </a>
                                    @endif
                                </div>
                                </div>
                        </section>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{route('back.presentpurchases')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
