@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @if($work->photo_id)
                <td><img src="{{$work->photo->path}}" class="img-fluid" style="border-radius: 30px; width:250px;     height: 250px;" ></td>
            @else
                <td><img src="{{url('back/dist/img/avatar-default.png')}}" class="img-fluid" style="border-radius: 50%; width:250px;     height: 250px;"></td>
            @endif
        </div>
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش درباره ما: </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.works.update',$work->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">عنوان: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$work->title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">شرایط و قوانین: </label>
                            <textarea type="text" class="form-control @error('body') is-invalid @enderror" rows="15" name="body" style="font-family: 'vazir';" >{{$work->body}}</textarea>

                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">بنر </label>
                            <input type="file" name="photo_id" id="exampleInputFile">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.works')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
