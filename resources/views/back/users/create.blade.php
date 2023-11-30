@extends('back.index')
@section('content')
    <div class="row">
    <div class="col-md-6 justify-content-md-center">
        <div class="box box-warning col-md-6 offset-md-3">
            <div class="box-header with-border">
                <h3 class="box-title">ثبت کاربر جدید</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.users.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">نام: </label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1" name="name" value="{{old('name')}}" placeholder="نام">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">نام و نام خانوادگی: </label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="exampleInputEmail1" name="lastname" value="{{old('lastname')}}" placeholder="نام و نام خانوادگي">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">ايميل:</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" value="{{old('email')}}" placeholder="ايميل">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">شماره موبایل:</label>
                        <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="exampleInputEmail1" name="mobile" value="{{old('mobile')}}" placeholder="شماره موبایل">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">شماره تلفن ثابت:</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="exampleInputEmail1" name="phone" value="{{old('phone')}}" placeholder="شماره تلفن ثابت">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">زمینه کاری:(اختیاری)</label>
                        <input type="text" class="form-control @error('jobs') is-invalid @enderror" id="exampleInputEmail1" name="jobs" value="{{old('jobs')}}" placeholder="زمینه کاری">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">نام شرکت :(اختیاری)</label>
                        <input type="text" class="form-control @error('companyname') is-invalid @enderror" id="exampleInputEmail1" name="companyname" value="{{old('companyname')}}" placeholder="نام شرکت ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">کد پستی :</label>
                        <input type="text" class="form-control @error('postcode') is-invalid @enderror" id="exampleInputEmail1" name="postcode" value="{{old('postcode')}}" placeholder="کدپستی   ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">استان:</label>
                        <select class="form-control" name="province_id">
                            @foreach($proviencs as $proviencs_id => $proviencs_name)
                                <option value="{{$proviencs_id}}">{{$proviencs_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">شهر:</label>
                        <select class="form-control" name="city_id">
                            @foreach($cities as $cities_id => $cities_name)
                                <option value="{{$cities_id}}">{{$cities_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">آدرس:</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="exampleInputEmail1" name="address" value="{{old('address')}}" placeholder="آدرس را به صورت کامل بنویسید   ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">وضعيت:</label>
                        <select class="form-control" name="status" >
                            <option value="0">غير فعال</option>
                            <option value="1">فعال</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">نقش:</label>
                        <div id="output"></div>
                        <select class="chosen-select form-control" name="roles[]" multiple >
                            @foreach($roles as $roles_id => $roles_name)
                                <option value="{{$roles_id}}">{{$roles_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">رمز عبور:</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="رمز عبور">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">تکرار رمز عبور:</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password_confirmation" placeholder="تکرار رمز عبور">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">آپلود تصویر پروفایل</label>
                        <input type="file" name="photo_id" id="exampleInputFile">
                    </div>
                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.users')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
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
