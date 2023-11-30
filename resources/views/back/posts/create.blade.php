@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">ایجاد مطلب جدید</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.posts.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">عنوان: </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{old('title')}}" placeholder="عنوان">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">نام مستعار:</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="exampleInputEmail1" name="slug" value="{{old('slug')}}" placeholder="نام مستعار">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">محتوای مطلب: </label>
                        <textarea id="full-featured"  type="text" class="form-control @error('description') is-invalid @enderror" name="description" >{{old('description')}}</textarea>

                    </div>
                    <div class="form-group">
                        <lable for="exampleInputEmail1">متای توضیحات:</lable>
                        <textarea type="text" class="form-control @error('meta_description') is-invalid @enderror" name="meta_description"  >{{old('meta_description')}}</textarea>

                    </div>
                    <div class="form-group">
                        <lable for="exampleInputEmail1">متای برچسب ها:</lable>
                        <textarea type="text" class="form-control @error('meta_keywords') is-invalid @enderror" name="meta_keywords"  >{{old('meta_keywords')}}</textarea>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">وضعيت:</label>
                        <select class="form-control" name="status" >
                            <option value="0">منتشر شده</option>
                            <option value="1">منتشر نشده</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">دسته بندی ها:</label>
                        <div id="output"></div>
                        <select class="chosen-select form-control" name="categories[]" multiple style="width:400px;">
                            @foreach($categories as $categories_id => $categories_name)
                                <option value="{{$categories_id}}">{{$categories_name}}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="exampleInputFile">تصویر شاخص :</label>
                        <input type="file" name="photo_id" id="exampleInputFile">
                    </div>
                </div>



                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.posts')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
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
