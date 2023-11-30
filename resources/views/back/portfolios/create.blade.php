@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">ایجاد نمونه سفارش</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form"  action="{{route('back.portfolios.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">عنوان: </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1" name="name" value="{{old('name')}}" placeholder="عنوان">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">تگ:</label>
                        <input type="text" class="form-control @error('tag') is-invalid @enderror" id="exampleInputEmail1" name="tag" value="{{old('tag')}}" placeholder=" تگ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">لینک:</label>
                        <input type="text" class="form-control @error('link') is-invalid @enderror" id="exampleInputEmail1" name="link" value="{{old('link')}}" placeholder="لینک ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1"> توضیحات: </label>
                        <textarea id="full-featured"  type="text" class="form-control @error('description') is-invalid @enderror" name="description" >{{old('description')}}</textarea>
                    </div>
                    <hr>
                    <div class="form-group" style=" direction: ltr !important;">
                        <label for="exampleInputEmail1" >Title: </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{old('title')}}" placeholder="Title">
                    </div>
                    <div class="form-group" style=" direction: ltr !important;">
                        <label for="exampleInputEmail1"> Description: </label>
                        <textarea id="editor"  type="text" class="form-control @error('body') is-invalid @enderror" name="body" >{{old('body')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">اپلود کاتالوگ و لیست نمونه ها  :</label>
                        <input type="file" name="photo_id" class="form-control" id="exampleInputFile">
                    </div>
                    <div class="form-group">
                        <label for="pro-photo">تصاویر محصول :</label>
                        <div class="col-sm-12">
                            <input type="hidden" name="photos[]" id="pro-photo">
                            <div id="photo" class="dropzone"></div>
                        </div>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" onclick="productGallery()" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.portfolios')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
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
