@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش ویجت: </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.aboutlists.update',$aboutlist->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">عنوان: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$aboutlist->title}}">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.aboutlists')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
