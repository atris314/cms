@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">آپلود فایل</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" class="dropzone" action="{{route('back.photos.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <!-- /.box-body -->
{{--                    <input type="file" name="file" />--}}
{{--                <div class="box-footer">--}}
{{--                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>--}}
{{--                    <a href="{{route('back.categories')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>--}}
{{--                </div>--}}
            </form>
            <div class="box-header with-border">
                <a href="{{route('back.photos')}}" class="btn btn-sm btn-danger  mb-5 mt-5">رسانه ها</a>
            </div>

        </div>
    </div>
    </div>
    </div>
    @endsection

