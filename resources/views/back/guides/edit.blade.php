@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @if($guide->photo_id)
                <td><img src="{{$guide->photo->path}}" class="img-fluid" style="border-radius: 50%; width:250px;     height: 250px;" ></td>
            @else
                <td><img src="{{url('back/dist/img/avatar-default.png')}}" class="img-fluid" style="border-radius: 50%; width:250px;     height: 250px;"></td>
            @endif
        </div>
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش راهنمای ثبت سفارش: </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.guides.update',$guide->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">عنوان: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$guide->title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">لینک: </label>
                            <input type="text" class="form-control @error('link') is-invalid @enderror" id="exampleInputEmail1" name="link" value="{{$guide->link}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">تصویر شاخص</label>
                            <input type="file" name="photo_id" id="exampleInputFile">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.guides')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
