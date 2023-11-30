@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">ایجاد</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.customers.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">نام: </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1" name="name" value="{{old('name')}}" placeholder="نام">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">سمت شغلی : </label>
                        <input type="text" class="form-control @error('job') is-invalid @enderror" id="exampleInputEmail1" name="job" value="{{old('job')}}" placeholder="سمت شغلی">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">متن پیغام: </label>
                        <textarea id="full-featured" type="text" class="form-control @error('comment') is-invalid @enderror" name="comment"  >{{old('comment')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">تصویر  :</label>
                        <input type="file" name="photo_id" id="exampleInputFile">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.customers')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection
@section('js')
    <script>
        $(".chosen-select").chosen()
    </script>
@endsection
