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
            <form role="form" action="{{route('back.settings.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">تلفن: </label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="exampleInputEmail1" name="phone" value="{{old('phone')}}" placeholder="تلفن">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">ایمیل:</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" value="{{old('email')}}" placeholder="ایمیل">
                    </div>
                    <div class="form-group">
                        <lable for="exampleInputEmail1">آدرس:</lable>
                        <textarea id="full-featured" type="text" class="form-control @error('address') is-invalid @enderror" name="address" >{{old('address')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">کپی رایت:</label>
                        <input type="text" class="form-control @error('copyright') is-invalid @enderror" id="exampleInputEmail1" name="copyright" value="{{old('copyright')}}" placeholder="کپی رایت">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">اینستاگرام:</label>
                        <input type="text" class="form-control @error('instagram') is-invalid @enderror" id="exampleInputEmail1" name="instagram" value="{{old('instagram')}}" placeholder="اینستاگرام">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">توییتر:</label>
                        <input type="text" class="form-control @error('twitter') is-invalid @enderror" id="exampleInputEmail1" name="twitter" value="{{old('twitter')}}" placeholder="توییتر">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">واتس اپ:</label>
                        <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" id="exampleInputEmail1" name="whatsapp" value="{{old('whatsapp')}}" placeholder="واتس اپ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">تلگرام:</label>
                        <input type="text" class="form-control @error('telegram') is-invalid @enderror" id="exampleInputEmail1" name="telegram" value="{{old('telegram')}}" placeholder="تلگرام">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">اسکایپ:</label>
                        <input type="text" class="form-control @error('skype') is-invalid @enderror" id="exampleInputEmail1" name="skype" value="{{old('skype')}}" placeholder="اسکایپ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">لینکدین:</label>
                        <input type="text" class="form-control @error('linkedin') is-invalid @enderror" id="exampleInputEmail1" name="linkedin" value="{{old('linkedin')}}" placeholder="لینکدین">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">فیسبوک:</label>
                        <input type="text" class="form-control @error('facebook') is-invalid @enderror" id="exampleInputEmail1" name="facebook" value="{{old('facebook')}}" placeholder="فیسبوک">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">لوگو :</label>
                        <input type="file" name="photo_id" id="exampleInputFile">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.settings')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection
