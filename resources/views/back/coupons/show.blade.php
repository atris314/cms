@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
            کوپن تخفیف | {{$coupon->title}}

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="{{route('back.coupons.show',$coupon->id)}}"> کوپن تخفیف  | {{$coupon->title}} </a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">

                </div>
                <hr>

        <!-- /.box-header -->
        <div class="box-body">

            @include('back.massages')
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div>
                <div class="row">
                    <div class="col-sm-6 offset-2">
                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">

                            </tr>
                            </thead>
                            <tbody>
                                <tr role="row" class="odd">
                                    <td>عنوان تخفیف</td>
                                    <td>{{$coupon->title}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td>کد تخفیف</td>
                                    <td>{{$coupon->code}}</td>
                                </tr>
                                <tr role="row" class="odd">
                                    <td>درصد تخفیف</td>
                                    <td>{{$coupon->price}}</td>
                                </tr>
                           </tbody>
                        </table>
                        <form action="{{route('back.coupons.Sent',$coupon->id)}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">ارسال به کاربران</button>
                        </form>
                    </div>
                </div>
            </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
