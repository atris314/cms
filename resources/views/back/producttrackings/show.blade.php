@extends('back.index')
@section('content')
    <div class="row">
        <div class="row" id="app">
            <div class="col-xs-12">
                <div class="">
                    <div class="box-body">
                        <div class="box box-success col-md-9  justify-content-md-center">
                            <div class="box-header with-border">
                                <h3 class="box-title">رهگیری مرسوله سفارش: {{$producttracking->product->title}} </h3>
                            </div>
                            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <table  class="table table-responsive table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                            <thead style="background: #1da09540; height: 50px;">
                                            <tr role="row">
                                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                                    کد رهگیری مرسوله
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr role="row" class="text-center odd px-3 py-3">
                                                <td>{{$producttracking->trackcode}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
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
                                                <td class="text-center">{{$producttracking->product->codepro}} </td>
                                                <td class="text-center">{{$producttracking->product->title}}</td>
                                                <td class="text-center">{{$producttracking->product->number}}</td>
                                                <td class="text-center">{{$producttracking->product->pack->title}}</td>
                                                <td class="text-center">{{$producttracking->product->catorder->title}}</td>
                                                <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($producttracking->product->created_at)}}</td>
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
                                                <td>{!! $producttracking->product->description !!}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-2">
                                        <td><img src="{{$producttracking->product->photos->pluck('path')->first()}}" class="img-fluid" style="border-radius: 10px; width:350px;"  alt="{{$producttracking->product->title}}"></td>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="box-header with-border">
                                <h3 class="box-title">اطلاعات کاربر ثبت کننده سفارش </h3>
                            </div>
                            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                                <div class="row">
                                    <div class="col-sm-8">
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
                                                <td class="text-center">{{$producttracking->product->user->code}} </td>
                                                <td class="text-center">{{$producttracking->product->user->username}}</td>
                                                <td class="text-center">{{$producttracking->product->user->name}}  {{$producttracking->product->user->lastname}}</td>
                                                <td class="text-canter">{{$producttracking->product->user->phone}} - {{$producttracking->product->user->mobile}}</td>
                                                <td class="text-center">{{$producttracking->product->user->email}}</td>
                                                <td class="text-canter">
                                                    @if($producttracking->product->user->province_id==1)آذربايجان شرقي
                                                    @elseif($producttracking->product->user->province_id==2)آذربايجان غربي
                                                    @elseif($producttracking->product->user->province_id==3)اردبيل
                                                    @elseif($producttracking->product->user->province_id==4)اصفهان
                                                    @elseif($producttracking->product->user->province_id==5)البرز
                                                    @elseif($producttracking->product->user->province_id==6)ايلام
                                                    @elseif($producttracking->product->user->province_id==7)بوشهر
                                                    @elseif($producttracking->product->user->province_id==8)تهران
                                                    @elseif($producttracking->product->user->province_id==9)چهارمحال بختياري
                                                    @elseif($producttracking->product->user->province_id==10)خراسان جنوبي
                                                    @elseif($producttracking->product->user->province_id==11)خراسان رضوي
                                                    @elseif($producttracking->product->user->province_id==12)خراسان شمالي
                                                    @elseif($producttracking->product->user->province_id==13)خوزستان
                                                    @elseif($producttracking->product->user->province_id==14)زنجان
                                                    @elseif($producttracking->product->user->province_id==15)سمنان
                                                    @elseif($producttracking->product->user->province_id==16)سيستان و بلوچستان
                                                    @elseif($producttracking->product->user->province_id==17)فارس
                                                    @elseif($producttracking->product->user->province_id==18)قزوين
                                                    @elseif($producttracking->product->user->province_id==19)قم
                                                    @elseif($producttracking->product->user->province_id==20)كردستان
                                                    @elseif($producttracking->product->user->province_id==21)كرمان
                                                    @elseif($producttracking->product->user->province_id==22)كرمانشاه
                                                    @elseif($producttracking->product->user->province_id==23)كهكيلويه و بويراحمد
                                                    @elseif($producttracking->product->user->province_id==24)گلستان
                                                    @elseif($producttracking->product->user->province_id==25)گيلان
                                                    @elseif($producttracking->product->user->province_id==26)لرستان
                                                    @elseif($producttracking->product->user->province_id==27)مازندران
                                                    @elseif($producttracking->product->user->province_id==28)مركزي
                                                    @elseif($producttracking->product->user->province_id==29)هرمزگان
                                                    @elseif($producttracking->product->user->province_id==30)همدان
                                                    @elseif($producttracking->product->user->province_id==31)يزد
                                                    @endif
                                                    -{{$producttracking->product->user->address}}
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end no-print mt-5">
                                <div class="col-xs-10 text-left">
{{--                                    <a href="{{route('back.producttrackings.pdf',$producttracking->id)}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> دانلود فایل pdf</a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
