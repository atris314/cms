@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش خدمات </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.services.update',$service->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">عنوان: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$service->title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">کلاس آیکون:</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" id="exampleInputEmail1" name="icon" value="{{$service->icon}}">
                        </div>
                        <div class="form-group">
                            <lable for="exampleInputEmail1"> توضیحات:</lable>
                            <textarea id="editor" type="text" class="form-control @error('body') is-invalid @enderror" name="body" style="font-family: 'p30';" >{{$service->body}}</textarea>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.services')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

