@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش منو: {{$menu->title}} </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.menus.update',$menu->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">عنوان: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$menu->title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">ترتیب نمایش:</label>
                            <input type="text" class="form-control @error('sort') is-invalid @enderror" id="exampleInputEmail1" name="sort" value="{{$menu->sort}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">لینک:</label>
                            <input type="text" class="form-control @error('url') is-invalid @enderror" id="exampleInputEmail1" name="url" value="{{$menu->url}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">وضعيت:</label>
                            <select class="form-control" name="status" >
                                <option value="0">منتشر نشده</option>
                                <option value="1"  <?php if($menu->status==1) echo 'selected' ; ?>>منتشر شده</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <lable for="title">سرگروه</lable>
                            <select class="form-control" name="post_id" >
                                <option value="0">---</option>
                                @foreach($menusub as $post_id=> $post_name)
                                    <option value="{{$post_id}}">{{$post_name}}</option>
                                @endforeach
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
                        <a href="{{route('back.menus')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
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
