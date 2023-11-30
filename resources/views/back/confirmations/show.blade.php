@extends('back.index')
@section('content')
    <div class="row">
        <div class="row" id="app">
            <div class="col-xs-12">
                <div class="">
                    <div class="box-body">
                        <div class="box box-success col-md-9  justify-content-md-center">
                            <div class="box-header with-border">
                                <h3 class="box-title">اطلاعات سفارش ثبت شده: {{$confirmation->protitle}} </h3>
                            </div>
                            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <table id="example2" class="table table-responsive table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                            <thead style="background: #1da09540; height: 50px;">
                                            <tr role="row">
                                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                                    کد سفارش
                                                </th>
                                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                                    عنوان سفارش
                                                </th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                                    تعداد
                                                </th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                    نوع منبع یابی
                                                </th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                    دسته بندی
                                                </th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                    تاریخ ثبت سفارش
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr role="row" class="odd">
                                                <td class="text-center">{{$confirmation->product->codepro}} </td>
                                                <td class="text-center">{{$confirmation->protitle}}</td>
                                                <td class="text-center">{{$confirmation->product->number}}</td>
                                                <td class="text-center">{{$confirmation->propack}}</td>
                                                <td class="text-center">{{$confirmation->procaorder}}</td>
                                                {{--                                                            <td class="text-center" dir="ltr">--}}
                                                {{--                                                                @if(isset($confirmation->user))--}}
                                                {{--                                                                    {{$confirmation->user->code}}--}}
                                                {{--                                                                @endif--}}
                                                {{--                                                            </td>--}}
                                                <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($confirmation->product->created_at)}}</td>
                                            </tr>
                                            </tbody>


                                        </table>
                                        <table  class="table table-responsive table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                            <thead style="background: #1da09540; height: 50px;">
                                            <tr role="row">
                                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                                    توضیحات سفارش
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr role="row" class="odd px-3 py-3">
                                                <td>{!! $confirmation->prodes !!}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-2">
{{--                                        @foreach($confirmation->product->photos as $photo)--}}
{{--                                            <td><img src="{{$confirmation->product->path}}" class="img-fluid" style="border-radius: 10px; width:350px;"  alt="{{$confirmation->product->title}}"></td>--}}
{{--                                        @endforeach--}}
                                        <td><img src="{{$confirmation->product->photos->pluck('path')->first()}}" class="img-fluid" style="border-radius: 10px; width:350px;"  alt="{{$confirmation->product->title}}"></td>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-header with-border">
                                <h3 class="box-title">اطلاعات ترجمه سفارش: {{$confirmation->translatesubject}} </h3>
                            </div>
                            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <table id="example2" class="table table-responsive table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                            <thead style="background: #1da09540; height: 50px;">
                                            <tr role="row">
                                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                                    order code
                                                </th>
                                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                                    subject
                                                </th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                                    number
                                                </th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                    category
                                                </th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                    description
                                                </th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                    date
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr role="row" class="odd">
                                                <td class="text-center">{{$confirmation->product->codepro}} </td>
                                                <td class="text-center">{{$confirmation->translatesubject}}</td>
                                                <td class="text-center">{{$confirmation->product->number}}</td>
                                                <td class="text-left">{{$confirmation->translatecategory}}</td>
                                                <td class="text-left">{!! $confirmation->translatedes !!}</td>
                                                <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($confirmation->protranslate->created_at)}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-header with-border">
                                <h3 class="box-title">اطلاعات کاربر ثبت کننده سفارش </h3>
                            </div>
                            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <table id="example2" class="table table-responsive table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                            <thead style="background: #1da09540; height: 50px;">
                                            <tr role="row">
                                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                                    کد کاربر
                                                </th>
                                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                                   نام کاربری
                                                </th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                                    نام و نام خانوادگی
                                                </th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                    شماره تماس
                                                </th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                    ایمیل
                                                </th>
                                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                    آدرس
                                                </th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr role="row" class="odd">
                                                <td class="text-center">{{$confirmation->user->code}} </td>
                                                <td class="text-center">{{$confirmation->user->username}}</td>
                                                <td class="text-center">{{$confirmation->user->name}}  {{$confirmation->user->lastname}}</td>
                                                <td class="text-canter">{{$confirmation->user->phone}} - {{$confirmation->user->mobile}}</td>
                                                <td class="text-center">{{$confirmation->user->email}}</td>
                                                <td class="text-canter">
                                                    @if($confirmation->user->province_id==1)آذربايجان شرقي
                                                    @elseif($confirmation->user->province_id==2)آذربايجان غربي
                                                    @elseif($confirmation->user->province_id==3)اردبيل
                                                    @elseif($confirmation->user->province_id==4)اصفهان
                                                    @elseif($confirmation->user->province_id==5)البرز
                                                    @elseif($confirmation->user->province_id==6)ايلام
                                                    @elseif($confirmation->user->province_id==7)بوشهر
                                                    @elseif($confirmation->user->province_id==8)تهران
                                                    @elseif($confirmation->user->province_id==9)چهارمحال بختياري
                                                    @elseif($confirmation->user->province_id==10)خراسان جنوبي
                                                    @elseif($confirmation->user->province_id==11)خراسان رضوي
                                                    @elseif($confirmation->user->province_id==12)خراسان شمالي
                                                    @elseif($confirmation->user->province_id==13)خوزستان
                                                    @elseif($confirmation->user->province_id==14)زنجان
                                                    @elseif($confirmation->user->province_id==15)سمنان
                                                    @elseif($confirmation->user->province_id==16)سيستان و بلوچستان
                                                    @elseif($confirmation->user->province_id==17)فارس
                                                    @elseif($confirmation->user->province_id==18)قزوين
                                                    @elseif($confirmation->user->province_id==19)قم
                                                    @elseif($confirmation->user->province_id==20)كردستان
                                                    @elseif($confirmation->user->province_id==21)كرمان
                                                    @elseif($confirmation->user->province_id==22)كرمانشاه
                                                    @elseif($confirmation->user->province_id==23)كهكيلويه و بويراحمد
                                                    @elseif($confirmation->user->province_id==24)گلستان
                                                    @elseif($confirmation->user->province_id==25)گيلان
                                                    @elseif($confirmation->user->province_id==26)لرستان
                                                    @elseif($confirmation->user->province_id==27)مازندران
                                                    @elseif($confirmation->user->province_id==28)مركزي
                                                    @elseif($confirmation->user->province_id==29)هرمزگان
                                                    @elseif($confirmation->user->province_id==30)همدان
                                                    @elseif($confirmation->user->province_id==31)يزد
                                                    @endif
                                                    -{{$confirmation->user->address}}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <table id="example2" class="table table-responsive table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                            <thead style="background: #1da09540; height: 50px;">
                                            <tr role="row">
                                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                                   امضای الکترونیکی
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr role="row" class="odd">
                                                <td class="text-center" style="padding: 20px;/* margin-top: 29px; */font-size: 18pt;">
                                                    <a  class="label btn-lg  pull-center bg-green-gradient" >تطابق اطلاعات درج شده با اطلاعات سفارش ثبت شده توسط کاربر تایید شد <i class="fa fa-check"></i></a>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end no-print mt-5">
                                <div class="col-xs-10 text-left">
                                    <a href="{{route('back.confirmations.pdf',$confirmation->id)}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> دانلود فایل pdf</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
