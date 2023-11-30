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
                                        <i class="fa fa-globe"></i>درخواست نمایندگی
                                        <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($representation->created_at)}}  </small>
                                    </h2>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-lg-12 table-bordered table-responsive pt-5">
                                    <table class="table table-striped" >
                                        <tehead><h4> اطلاعات درخواست :</h4></tehead>
                                        <tr>
                                            <td>نام و نام خانوادگی :</td>
                                            <td>{{$representation->name}} </td>
                                        </tr>
                                        <tr>
                                            <td>ایمیل :</td>
                                            <td>{{$representation->email}}</td>
                                        </tr>
                                        <tr>
                                            <td>شماره تماس :</td>
                                            <td>{{$representation->phone}}</td>
                                        </tr>
                                        <tr>
                                            <td>توضیحات:</td>
                                            <td>{{$representation->description}}</td>
                                        </tr>
                                        <tr>
                                            <td>تاریخ ثبت درخواست :</td>
                                            <td>{{\Hekmatinasser\Verta\Verta::instance($representation->created_at)}}</td>
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
                                    @if($representation['status']==0)
                                    <a  class="btn btn-light" >تایید نشده</a>
                                    @elseif($representation['status']==1)
                                        <a  class="label pull-center bg-navy" >تایید شده</a>
                                    @endif
                                </div>
                                </div>
                        </section>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{route('back.representations')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
