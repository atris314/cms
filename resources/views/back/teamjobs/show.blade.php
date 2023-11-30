@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-12 offset-lg-1 justify-content-md-center">

            <div class="box box-success col-md-12  justify-content-md-center">
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
                                        <i class="fa fa-globe"></i>{{$teammate->user->name}}
                                        <small class="pull-left">گزارش فعالیت در {{$carbon}} روز</small>

                                    </h2>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-lg-12 table-bordered table-responsive pt-5">
                                    <table class="table table-striped table-bordered" >

                                        <tehead><h4> اطلاعات کارناس :</h4></tehead>
                                        <tr>
                                            <td>کد کاربری :</td>
                                            <td dir="ltr" style="text-align: right">{{$teammate->user->code}}</td>
                                        </tr>
                                        <tr>
                                            <td>نام کاربری کارشناس :</td>
                                            <td>{{$teammate->user->name}}</td>
                                        </tr>
                                        <tr>
                                            <td>نام و نام خانوادگی:</td>
                                            <td>{{$teammate->user->lastname}}</td>
                                        </tr>
                                        <tr>
                                            <td>امتیاز :</td>
                                            <td>{{$teammate->rate}}</td>
                                        </tr>
                                        <tr>
                                            <td>تعداد ترجمه ها :</td>
                                            <td>{{$teammate->count}}</td>
                                        </tr>
                                        <tr>
                                            <td>فعالیت :</td>
                                            <td>{{$teammate->activity}}</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row invoice-info">
                                <div class="col-lg-12 table-bordered table-responsive pt-5">
                                    <table class="table table-striped table-bordered" >
                                        @if($protranslate)
                                            <tr>
                                                <td>شناسه ترجمه شده ها :</td>
                                                <td>عنوان ترجمه شده ها :</td>
                                                <td>مدت زمان ترجمه :</td>

                                            </tr>
                                            @foreach($protranslate as $pro)
                                                @if($pro->product)
                                                    <tr>
                                                        <td class=" protraslate">{{$pro->product->codepro}}</td>
                                                        <td class=" protraslate">{{$pro->product->title}}</td>
                                                        <td class="protraslate">{{$pro->time}}</td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                        @endif
                                    </table>
                                    {{$protranslate->links()}}
                                </div>
                            </div>
                            <!-- this row will not appear when printing -->
                            <div class="row no-print mt-5">
                                <div class="col-xs-6">
                                    <a href="{{route('back.team.jobs.print',$teammate->id)}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> پرینت</a>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{route('back.teamjobs')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
