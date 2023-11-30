@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">ایجاد منو</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.menus.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">عنوان: </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{old('title')}}" placeholder="عنوان">
                    </div>
                    <div class="form-group">
                        <lable for="title">سرگروه</lable>
                        <select class="form-control" name="post_id" style="font-family: 'Vazir';">
                            <option value="0">---</option>
                            @foreach($menutop as $key=> $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">ترتیب نمایش:</label>
                        <input type="text" class="form-control @error('sort') is-invalid @enderror" id="exampleInputEmail1" name="sort" value="{{old('sort')}}" placeholder="ترتیب نمایش">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">لینک:</label>
                        <input type="text" class="form-control @error('url') is-invalid @enderror" id="exampleInputEmail1" name="url" value="{{old('url')}}" placeholder="لینک">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">وضعيت:</label>
                        <select class="form-control" name="status" >
                            <option value="0">فعال</option>
                            <option value="1">غیرفعال</option>
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
                    <a href="{{route('back.menus')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection
