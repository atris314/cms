@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">تبلیغ جدید +</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.ads.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">عنوان: </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{old('title')}}" placeholder="عنوان">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">لینک: </label>
                        <input type="text" class="form-control @error('link') is-invalid @enderror" id="exampleInputEmail1" name="link" value="{{old('link')}}" placeholder="لینک">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">دسته بندی ها:</label>
                        <select class=" form-control" name="catorder_id">
                            @foreach($catorders as $categories_id => $categories_name)
                                <option value="{{$categories_id}}">{{$categories_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <lable for="exampleInputEmail1"> توضیحات:</lable>
                        <textarea id="editor" type="text" class="form-control @error('description') is-invalid @enderror" name="description" >{{old('description')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">تصویر  :</label>
                        <input type="file" name="photo_id" id="exampleInputFile">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.ads')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection
