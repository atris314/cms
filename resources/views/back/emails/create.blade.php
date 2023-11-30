@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">ایجاد ایمیل</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.emails.store')}}" method="post" >
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">نام یا عنوان: </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1"name="name" value="{{old('name')}}" placeholder="نام یا عنوانی صاحب ایمیل">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">نشانی ایمیل: </label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" value="{{old('email')}}" placeholder="نشانی ایمیل را وارد کنید">
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.emails')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection
