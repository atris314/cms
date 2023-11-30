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
            <form role="form" action="{{route('back.bannerhomes.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">altبنر: </label>
                        <input type="text" class="form-control @error('alt') is-invalid @enderror" id="exampleInputEmail1" name="alt" value="{{old('alt')}}" placeholder="لطفا alt بنر را بنویسید مثال: عید امسال">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">متن دکمه: </label>
                        <input type="text" class="form-control @error('button') is-invalid @enderror" id="exampleInputEmail1" name="button" value="{{old('button')}}" placeholder="متن دکمه">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">لینک دکمه: </label>
                        <input type="text" class="form-control @error('link') is-invalid @enderror" id="exampleInputEmail1" name="link" value="{{old('link')}}" placeholder="لینک مربوط به دکمه مورد نظر">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">وضعيت:</label>
                        <select class="form-control" name="status" >
                            <option value="0">نمایش داده شود</option>
                            <option value="1">منمایش داده نشود</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">تصویر  :</label>
                        <input type="file" name="photo_id" id="exampleInputFile">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.bannerhomes')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection
