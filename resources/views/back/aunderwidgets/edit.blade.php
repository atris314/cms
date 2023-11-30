@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش ویجت </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.aunderwidgets.update',$aunderwidget->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">شماره:</label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="exampleInputEmail1" name="number" value="{{$aunderwidget->number}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">کلاس رنگ:</label>
                            <input type="text" class="form-control @error('color') is-invalid @enderror" id="exampleInputEmail1" name="color" value="{{$aunderwidget->color}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">عنوان: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$aunderwidget->title}}">
                        </div>
                        <div class="form-group">
                            <lable for="exampleInputEmail1">توضیحات:</lable>
                            <textarea id="full-featured" type="text" class="form-control @error('body') is-invalid @enderror" name="body" style="font-family: 'vazir';" >{{$aunderwidget->body}}</textarea>

                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">آیکون  :</label>
                            <input type="file" name="photo_id" id="exampleInputFile">
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.aunderwidgets')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

