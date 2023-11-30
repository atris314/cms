@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @if($catalog->photo_id)
                <td><img src="{{$catalog->photo['path']}}" class="img-fluid" style="border-radius: 50%; width:250px;     height: 250px;" ></td>
            @else
                <td><img src="{{url('back/dist/img/avatar-default.png')}}" class="img-fluid" style="border-radius: 50%; width:250px;     height: 250px;"></td>
            @endif
        </div>
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش پست: {{$catalog->title}} </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.catalogs.update',$catalog->slug)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">عنوان: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$catalog->title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">نام مستعار:</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="exampleInputEmail1" name="slug" value="{{$catalog->slug}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">لینک:(کاتالوگ را در رسانه ها آپلود کرده و جهت دانلود کاربر لینک آن را در این فیلد قرار دهید)</label>
                            <input type="text" class="form-control @error('link') is-invalid @enderror" id="exampleInputEmail1" name="link" value="{{$catalog->link}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">قیمت: </label>
                            <input type="text" class="form-control @error('price') is-invalid @enderror" id="exampleInputEmail1" name="price" value="{{$catalog->price}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> توضیحات : </label>
                            <textarea id="full-featured" type="text" class="form-control @error('body') is-invalid @enderror" name="body"  >{{$catalog->body}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">متای توضیحات : </label>
                            <textarea id="full-featured" type="text" class="form-control @error('description') is-invalid @enderror" name="description"  >{{$catalog->description}}</textarea>
                        </div>
                        <div class="form-group">
                            <lable for="exampleInputEmail1">متای کلمات کلیدی:</lable>
                            <textarea type="text" class="form-control @error('keyword') is-invalid @enderror" name="keyword"  >{{$catalog->keyword}}</textarea>

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">وضعيت:</label>
                            <select class="form-control" name="status" >
                                <option value="0">منتشر نشده</option>
                                <option value="1"  <?php if($catalog->status==1) echo 'selected' ; ?>>منتشر شده</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">دسته بندي:</label>
                            <div id="output"></div>
                            <select class="chosen-select form-control" name="catalogcat_id" multiple style="width:400px;">
                                @foreach($catalogcats as $cat_id => $cat_name)

                                    <option value="{{$cat_id}}"
                                    <?php
                                        if (
                                        in_array($cat_id,$catalog->catalogcat->pluck('id')->toArray())
                                        )
                                            echo 'selected';
                                        ?>

                                    >{{$cat_name}}
                                    </option>

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
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.catalogs')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(".chosen-select").chosen()
    </script>
@endsection
