@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @if($slideshow->photo_id)
                <td><img src="{{$slideshow->photo->path}}" class="img-fluid" style="border-radius: 50%; width:250px;     height: 250px;" ></td>
            @else
                <td><img src="{{url('back/dist/img/avatar-default.png')}}" class="img-fluid" style="border-radius: 50%; width:250px;     height: 250px;"></td>
            @endif
        </div>
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش اسلایدشو : </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.slideshows.update',$slideshow->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">alt تصویر: </label>
                            <input type="text" class="form-control @error('alt') is-invalid @enderror" id="exampleInputEmail1" name="alt" value="{{$slideshow->alt}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">تصویر شاخص</label>
                            <input type="file" name="photo_id" id="exampleInputFile">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.slideshows')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
