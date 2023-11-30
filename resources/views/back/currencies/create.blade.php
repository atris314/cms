@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">ثبت قیمت لحظه ای ارز ( ریال ) </h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.currencies.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">دلار: </label>
                        <input type="text" class="form-control @error('dollarf') is-invalid @enderror" id="exampleInputEmail1" name="dollarf" value="{{old('dollarf')}}" placeholder="دلار">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">یورو: </label>
                        <input type="text" class="form-control @error('yorof') is-invalid @enderror" id="exampleInputEmail1" name="yorof" value="{{old('yorof')}}" placeholder="یورو">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">یوان: </label>
                        <input type="text" class="form-control @error('yoan') is-invalid @enderror" id="exampleInputEmail1" name="yoan" value="{{old('yoan')}}" placeholder="یوان">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.currencies')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection

