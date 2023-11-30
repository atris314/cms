@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">همکار جدید</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.teammates.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="exampleInputEmail1">نام و نام خانوادگی کاربر:</label>
                            <select class="chosen-select form-control" name="user_id">
                                @foreach($users as $user_id => $user_name)
                                    <option value="{{$user_id}}">{{$user_name}}</option>
                                @endforeach
                            </select>
                        </div>
                     </div>
                    <div class="form-group">
                        <label for="statictitle" class="col-form-label gray-text-color">تاریخ تولد: <span style="color: darkred"> *</span></label>
                        <div class="input-group">

                            <input id="inputDate3" type="text" name="borndate" value="{{old('borndate')}}"
                                   aria-label="date3"
                                   aria-describedby="date3"
                                   placeholder="تاریخ تولد خود را وارد کنید" class="date form-control gray-text-color @error('borndate') is-invalid @enderror">
                            <span class="input-group-addon" id="date3" style="cursor: pointer">
                                     انتخاب
                                    </span>
                        </div>

                    </div>
{{--                    <div class="form-group">--}}
{{--                        <label for="exampleInputEmail1">تاریخ تولد: </label>--}}
{{--                        <input type="text" class="form-control @error('borndate') is-invalid @enderror" id="exampleInputEmail1" name="borndate" value="{{old('borndate')}}" placeholder="تاریخ تولد">--}}
{{--                    </div>--}}
                    <div class="form-group">
                        <label for="exampleInputEmail1">محدوده سکونت: </label>
                        <input type="text" class="form-control @error('residence') is-invalid @enderror" id="exampleInputEmail1" name="residence" value="{{old('residence')}}" placeholder="محدوده سکونت">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">رشته تحصیلی: </label>
                        <input type="text" class="form-control @error('major') is-invalid @enderror" id="exampleInputEmail1" name="major" value="{{old('major')}}" placeholder="رشته تحصیلی">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">میزان تحصیلات: </label>
                        <input type="text" class="form-control @error('education') is-invalid @enderror" id="exampleInputEmail1" name="education" value="{{old('education')}}" placeholder="میزان تحصیلات">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">سوابق کاری: </label>
                        <input type="text" class="form-control @error('resume') is-invalid @enderror" id="exampleInputEmail1" name="resume" value="{{old('resume')}}" placeholder="سوابق کاری">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">دسته بندی نوع همکاری:</label>
                        <select class="chosen-select form-control" name="catwork_id" >
                            @foreach($catworks as $catwork_id => $catwork_name)
                                <option value="{{$catwork_id}}">{{$catwork_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">توضیحات: </label>
                        <textarea id="editor"  type="text" class="form-control @error('description') is-invalid @enderror" name="description" >{{old('description')}}</textarea>

                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">ارسال فایل رزومه:</label>
                        <input type="file" name="photo_id" id="exampleInputFile">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.teammates')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection
