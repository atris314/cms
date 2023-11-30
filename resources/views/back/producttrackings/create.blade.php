@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">فرم ثبت کد رهگیری مرسوله</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.producttrackings.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1"> کد رهگیری مرسوله: </label>
                        <input type="text" class="form-control @error('trackcode') is-invalid @enderror" id="exampleInputEmail1" name="trackcode" value="{{old('trackcode')}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> کد پیگیری سفارش: </label>
                        <input type="text" class="form-control @error('productcode') is-invalid @enderror" id="exampleInputEmail1" name="productcode" value="{{old('productcode')}}">
                    </div>


                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection
