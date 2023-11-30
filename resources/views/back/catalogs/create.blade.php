@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">ایجاد کاتالوگ</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.catalogs.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">عنوان: </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{old('title')}}" placeholder="عنوان">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">نام مستعار: </label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="exampleInputEmail1" name="slug" value="{{old('slug')}}" placeholder="نام مستعار">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">لینک:(کاتالوگ را در رسانه ها آپلود کرده و جهت دانلود کاربر لینک آن را در این فیلد قرار دهید)</label>
                        <input type="text" class="form-control @error('link') is-invalid @enderror" id="exampleInputEmail1" name="link" value="{{old('link')}}" placeholder="لینک">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">قیمت:</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="exampleInputEmail1" name="price" value="{{old('price')}}" placeholder="قیمت">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">توضیحات : </label>
                        <textarea id="full-featured"  type="text" class="form-control @error('body') is-invalid @enderror" name="body" >{{old('body')}}</textarea>

                    </div>
                    <div class="form-group">
                        <lable for="exampleInputEmail1">متای کلمات کلیدی:</lable>
                        <textarea type="text" class="form-control @error('keyword') is-invalid @enderror" name="keyword"  >{{old('keyword')}}</textarea>
                    </div>
                    <div class="form-group">
                        <lable for="exampleInputEmail1">متای توضیحات:</lable>
                        <textarea type="text" class="form-control @error('description') is-invalid @enderror" name="description"  >{{old('description')}}</textarea>
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
                        <select class="chosen-select form-control" name="catalogcat_id" multiple style="width:400px;">
                            @foreach($catalogcats as $catalogcat_id => $catalogcat_name)
                                <option value="{{$catalogcat_id}}" @if (old('catalogcat_id') == $catalogcat_id) {{ 'selected' }} @endif >{{$catalogcat_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">تصویر شاخص :(تصویری از صفحه اصلی کاتالوگ جهت نمایش در سایت آپلود کنید)</label>
                        <input type="file" name="photo_id" id="exampleInputFile">
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.catalogs')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
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
