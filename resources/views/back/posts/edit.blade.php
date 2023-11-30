@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @if($post->photo_id)
                <td><img src="{{$post->photo['path']}}" class="img-fluid" style="border-radius: 50%; width:250px;     height: 250px;" ></td>
            @else
                <td><img src="{{url('back/dist/img/avatar-default.png')}}" class="img-fluid" style="border-radius: 50%; width:250px;     height: 250px;"></td>
            @endif
        </div>
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش پست: {{$post->title}} </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.posts.update',$post->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">عنوان: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$post->title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">نام مستعار:</label>
                            <input type="text" class="form-control @error('slug') is-invalid @enderror" id="exampleInputEmail1" name="slug" value="{{$post->slug}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">محتوای مطلب: </label>
                            <textarea id="full-featured" type="text" class="form-control @error('description') is-invalid @enderror" name="description"  >{{$post->description}}</textarea>

                        </div>
                        <div class="form-group">
                            <lable for="exampleInputEmail1">متای توضیحات:</lable>
                            <textarea type="text" class="form-control @error('meta_description') is-invalid @enderror" name="meta_description"  >{{$post->meta_description}}</textarea>

                        </div>
                        <div class="form-group">
                            <lable for="exampleInputEmail1">متای برچسب ها:</lable>
                            <textarea type="text" class="form-control @error('meta_keywords') is-invalid @enderror" name="meta_keywords"  >{{$post->meta_keywords}}</textarea>

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">وضعيت:</label>
                            <select class="form-control" name="status" >
                                <option value="0">منتشر نشده</option>
                                <option value="1"  <?php if($post->status==1) echo 'selected' ; ?>>منتشر شده</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">دسته بندي:</label>
                            <div id="output"></div>
                            <select class="chosen-select form-control" name="categories[]" multiple style="width:400px;">
                                @foreach($categories as $cat_id => $cat_name)

                                    <option value="{{$cat_id}}"
                                    <?php
                                        if (
                                        in_array($cat_id,$post->categories->pluck('id')->toArray())
                                        )
                                            echo 'selected';
                                        ?>

                                    >{{$cat_name}}
                                    </option>

                                @endforeach

{{--                                    @foreach ($categories as $cat_id => $cat_name)--}}
{{--                                        <option @if(in_array($cat_id, $post->categories()->pluck('category_id')->toArray())) selected--}}
{{--                                                @endif value="{{ $cat_id}}">{{$cat_name }}</option>--}}
{{--                                    @endforeach--}}
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">تصویر شاخص</label>
                            <input type="file" name="photo_id" id="exampleInputFile">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.posts')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
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
