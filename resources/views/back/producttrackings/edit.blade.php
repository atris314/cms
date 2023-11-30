@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-10 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش : </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.producttrackings.update',$producttracking->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <h4> کد مرسوله</h4>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> کد رهگیری مرسوله: </label>
                            <input type="text" class="text-right form-control @error('trackcode') is-invalid @enderror" dir="ltr" id="exampleInputEmail1" name="trackcode" value="{{$producttracking->trackcode}}" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">کد پیگیری سفارش : </label>
                            <input type="text" class="form-control @error('productcode') is-invalid @enderror" id="exampleInputEmail1" name="productcode" value="{{$producttracking->productcode}}" >
                        </div>
                        
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.producttrackings')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
