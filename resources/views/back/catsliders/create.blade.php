@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">ایجاد دسته بندي سفارشات جدید</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.catsliders.store')}}" method="post" enctype="multipart/form-data">
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
                        <label for="exampleInputEmail1">کد رنگی :</label>
                        <input type="text" class="form-control @error('color') is-invalid @enderror" id="exampleInputEmail1" name="color" value="{{old('color')}}" placeholder="کد رنگی ">
                    </div>
                    <div class="form-group">
                        <lable for="title">سرگروه</lable>
                        <select class="form-control" name="catslider_id" style="font-family: 'Vazir';">
                            <option value="0">---</option>
                            @foreach($catsliderstop as $key=> $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <lable for="exampleInputEmail1">متای توضیحات:</lable>
                        <textarea type="text" class="form-control @error('meta_description') is-invalid @enderror" name="meta_description" style="font-family: 'vazir';" >{{old('meta_description')}}</textarea>
                    </div>
                    <div class="form-group">
                        <lable for="exampleInputEmail1">متای برچسب ها:</lable>
                        <textarea type="text" class="form-control @error('meta_keywords') is-invalid @enderror" name="meta_keywords" style="font-family: 'vazir';" >{{old('meta_keywords')}}</textarea>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">تصویر  :</label>
                        <input type="file" name="photo_id" id="exampleInputFile">
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.catsliders')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection

