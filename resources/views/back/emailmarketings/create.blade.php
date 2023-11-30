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
            <form role="form" action="{{route('back.emailmarketings.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">موضوع ایمیل: </label>
                        <input type="text" class="form-control @error('subject') is-invalid @enderror" id="exampleInputEmail1" name="subject" value="{{old('subject')}}" placeholder="موضوع ایمیل">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">نام ارسال کننده : </label>
                        <input type="text" class="form-control @error('fromname') is-invalid @enderror" id="exampleInputEmail1" name="fromname" value="{{old('fromname')}}" placeholder="نام ارسال کننده">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">عنوان: </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1"name="title" value="{{old('title')}}" placeholder="عنوان">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">آدرس ایمیل: <span class="label label-default">لطفا آدرس ایمیل ها را فقط با علامت | بدون فاصله از هم جدا کنید</span> </label>
                        <textarea  type="text" class="form-control @error('emailaddress') is-invalid @enderror" name="emailaddress" rows="10" >{{old('emailaddress')}}</textarea>
                    </div>
                    <div class="form-group">
                        <lable for="exampleInputEmail1">متن ایمیل:</lable>
                        <textarea id="full-featured" type="text" class="form-control @error('body') is-invalid @enderror" name="body" >{{old('body')}}</textarea>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">تصویر  :</label>
                        <input type="file" name="photo_id" id="exampleInputFile">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.emailmarketings')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection

