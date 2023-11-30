@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">
            <div class="box box-success col-md-9  justify-content-md-center">
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <div class="box-body">
                    <section class="invoice">
                        <div class="row invoice-info">
                            <div class="col-lg-12 table-bordered table-responsive pt-5">
                                <table class="table table-striped" >
                                    <tr>
                                        <td>شناسه کاربر :</td>
                                        <td>{{$cancel->user->code}}</td>
                                    </tr>
                                    <tr>
                                        <td>عنوان سفارش :</td>
                                        <td>{{$cancel->product->title}}</td>
                                    </tr>
                                    <tr>
                                        <td>متن پیغام نظرسنجی:</td>
                                        <td style="width:560px; text-align: justify;" >{!! $cancel->body !!}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </section>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <a href="{{route('back.cancels')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </div>
        </div>
    </div>
@endsection
