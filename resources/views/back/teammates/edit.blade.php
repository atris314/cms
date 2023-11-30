@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @if($teammate->photo_id)
                <td><h3><a href="{{$teammate->photo['path']}}">دانلود رزومه کاربر</a></h3>
                </td>
            @else
                <td><a>رزومه ارسال نشده</a></td>
            @endif
        </div>
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش درخواست همکاری کاربر: {{$teammate->user->lastname}} </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.teammates.update',$teammate->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">وضعیت درخواست:</label>
                            <select class="form-control" name="status" style="height: 50px;">
                                <option  value="0" <?php if($teammate->status==0) echo 'selected' ; ?>>تایید نشده</option>
                                <option  value="1" <?php if($teammate->status==1) echo 'selected' ; ?>>تایید شده</option>
                                <option  value="2" <?php if($teammate->status==2) echo 'selected' ; ?>>مسدود شده</option>
                                <option  value="3" <?php if($teammate->status==3) echo 'selected' ; ?>>تایید و تکمیل شده</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">نام و نام خانوادگی: </label>
                            <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="exampleInputEmail1" name="lastname" value="{{$teammate->user->lastname}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">نام پدر:</label>
                            @if($teammate->fathername)
                            <input type="text" class="form-control @error('fathername') is-invalid @enderror" id="exampleInputEmail1" name="fathername" value="{{$teammate->fathername}}">
                            @else
                                <input type="text" class="form-control @error('fathername') is-invalid @enderror" id="exampleInputEmail1" name="fathername" value="{{$teammate->fathername}}">
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">تاریخ تولد:</label>
                                <input type="text" class="form-control @error('borndate') is-invalid @enderror" id="exampleInputEmail1" name="borndate" value="{{$teammate->borndate}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> ایمیل: </label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" value="{{$teammate->user->email}}" readonly>

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> شماره موبایل: </label>
                                 @if($teammate->user->mobile)
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="exampleInputEmail1" name="mobile" value="{{$teammate->user->mobile}}">
                                @elseif($teammate->mobile)
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="exampleInputEmail1" name="mobile" value="{{$teammate->mobile}}">
                                @endif

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> شماره تلفن: </label>
                            @if($teammate->user->phone)
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="exampleInputEmail1" name="phone" value="{{$teammate->user->phone}}">
                            @elseif($teammate->phone)
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="exampleInputEmail1" name="phone" value="{{$teammate->phone}}">
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> کد ملی: </label>
                            <input type="text" class="form-control @error('codemeli') is-invalid @enderror" id="exampleInputEmail1" name="codemeli" value="{{$teammate->codemeli}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> محدوده سکونت: </label>
                            <input type="text" class="form-control @error('residence') is-invalid @enderror" id="exampleInputEmail1" name="residence" value="{{$teammate->residence}}">
                        </div>
                        <div class="form-group">
                            <lable for="exampleInputEmail1">آدرس :</lable>
                            <textarea type="text" class="form-control @error('address') is-invalid @enderror" name="address" >{{$teammate->address}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> رشته تحصیلی: </label>
                            <input type="text" class="form-control @error('major') is-invalid @enderror" id="exampleInputEmail1" name="major" value="{{$teammate->major}}" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> سوابق کاری: </label>
                            <input type="text" class="form-control @error('resume') is-invalid @enderror" id="exampleInputEmail1" name="resume" value="{{$teammate->resume}}" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> میزان تحصیلات: </label>
                            <input type="text" class="form-control @error('education') is-invalid @enderror" id="exampleInputEmail1" name="education" value="{{$teammate->education}}" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">وضعیت تاهل:</label>
                            <select class="form-control" name="maritalstatus" style="height: 50px;" >
                                <option value="0">مجرد</option>
                                <option value="1"  <?php if($teammate->maritalstatus==1) echo 'selected' ; ?>>متاهل</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">آخرین مدرک تحصیلی:</label>
                            <select class="form-control" name="lasteducation" style="height: 50px;">

                                <option  value="0">دیپلم</option>
                                <option  value="1" <?php if($teammate->lasteducation==1) echo 'selected' ; ?>>کاردانی</option>
                                <option  value="2" <?php if($teammate->lasteducation==2) echo 'selected' ; ?>>کارشناسی</option>
                                <option  value="3" <?php if($teammate->lasteducation==3) echo 'selected' ; ?>>کارشناسی - ارشد</option>
                                <option  value="4" <?php if($teammate->lasteducation==4) echo 'selected' ; ?>>دکتری</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">دسته بندي نوع همکاری:</label>
                            <select class="form-control" name="catwork_id" style="height: 50px;" >
                                <option  value="1" <?php if($teammate->catwork_id==1) echo 'selected' ; ?>>دورکاری</option>
                                <option  value="2" <?php if($teammate->catwork_id==2) echo 'selected' ; ?>>حضوری</option>
                                <option  value="3" <?php if($teammate->catwork_id==3) echo 'selected' ; ?>>  پاره وقت </option>
                                <option  value="4" <?php if($teammate->catwork_id==4) echo 'selected' ; ?>>تمام وقت</option>
                                <option  value="5" <?php if($teammate->catwork_id==5) echo 'selected' ; ?>> پروژه ای</option>
{{--                                @foreach($catworks as $catwork_id => $catwork_name)--}}
{{--                                    <option value="{{$catwork_id}}"--}}
{{--                                    <?php--}}
{{--                                        if (--}}
{{--                                        in_array($catwork_id,$teammate->catwork->pluck('id')->toArray())--}}
{{--                                        )--}}
{{--                                            echo 'selected';--}}
{{--                                        ?>--}}
{{--                                    >{{$catwork_name}}--}}
{{--                                    </option>--}}
{{--                                @endforeach--}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">گروه بندي همکاری:</label>
                            <div id="output"></div>
                            <select class=" chosen-select form-control" name="groups[]" multiple style="height: 50px;" >

                                @foreach($groups as $cat_id => $cat_name)

                                    <option value="{{$cat_id}}"
                                    <?php
                                        if (
                                        in_array($cat_id,$teammate->groups->pluck('id')->toArray())
                                        )
                                            echo 'selected';
                                        ?>

                                    >{{$cat_name}}
                                    </option>

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">گروه بندي منبع یابی:</label>
                            <div id="output"></div>
                            <select class=" chosen-select form-control" name="packs[]" multiple style="height: 50px;" >

                                @foreach($packs as $cat_id => $cat_name)

                                    <option value="{{$cat_id}}"
                                    <?php
                                        if (
                                        in_array($cat_id,$teammate->packs->pluck('id')->toArray())
                                        )
                                            echo 'selected';
                                        ?>

                                    >{{$cat_name}}
                                    </option>

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">دسته بندي پشتیبانی:</label>
                            <select class="form-control" name="catorder_id" style="height: 50px;" >

                                @foreach($catorders as $cat_id => $cat_name)

                                    <option value="{{$cat_id}}"
                                    <?php
                                        if (
                                        in_array($cat_id,$teammate->catorder()->pluck('id')->toArray())
                                        )
                                            echo 'selected';
                                        ?>

                                    >{{$cat_name}}
                                    </option>

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <lable for="exampleInputEmail1">مهارت ها  :</lable>
                            <textarea type="text" class="form-control @error('skill') is-invalid @enderror" name="skill"  >{{$teammate->skill}}</textarea>
                        </div>
                        <div class="form-group">
                            <lable for="exampleInputEmail1">توضیحات  :</lable>
                            <textarea id="editor" type="text" class="form-control @error('description') is-invalid @enderror" name="description"  >{!! $teammate->description !!}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">فایل رزومه </label>
                            <input type="file" name="photo_id" id="exampleInputFile">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.teammates')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
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
