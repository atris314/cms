@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
           سفارشات ترجمه شده ارسال شده توسط کارشناس

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">سفارشات ترجمه شده</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="padding: 30px ">
                <form action="{{route('proCodeSearch')}}" method="get">
                    @csrf
                    <label style="display: inline-flex !important; ">جستجو براساس کد سفارش </label>
                    <div class="input-group input-group-sm col-lg-4">
                        <input type="text" class="form-control" placeholder="کد سفارش را وارد کنید" name="codepro" value="{{old('codepro')}}" >
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-info btn-flat">جستجو</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
        <div class="box-header">
            <h3 class="box-title">لیست سفارشات ترجمه شده</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('back.massages')
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div>
                <div class="row"><div class="col-sm-12">
                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">

                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">
                                    شناسه کاربر
                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    تصویر
                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                   عنوان| subject
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    کدسفارش
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    تعداد سفارش
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    دسته بندی
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  نوع منبع یابی
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                 وضعیت سفارش
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                 وضعیت ترجمه
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                 کارشناس مربوطه
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                 زمان ترجمه
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    تاریخ ایجاد
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  مديريت
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i=1; ?>
                            @foreach($protranslates as $protranslate)
                                @if(isset($protranslate->product))
                                 <tr role="row" class="odd">
                                    <td>{{$i++}}</td>
                                    <td dir="ltr">

                                        @foreach(@$protranslate->user()->pluck('code') as $code)
                                            {{$code}}
                                        @endforeach

                                    </td>
                                    <td class="text-center">
                                        @if($protranslate->product->photos)
                                        <img src="{{$protranslate->product->photos->pluck('path')->first()}}" style="border-radius: 10px; width:50px;     height: 50px;" >
                                            @endif
                                    </td>

                                    <td class="text-center"><a href="{{route('back.products.show',$protranslate->id)}}">{!! mb_substr($protranslate->subject,0,10).'..'!!} </a></td>
                                    <td class="text-center" >{{$protranslate->product->codepro}}</td>
                                    <td class="text-center" >{{$protranslate->product->number}}</td>
                                    <td class="text-center">
                                        @foreach(@$protranslate->product->catorder()->pluck('title') as $catorder)
                                            <span  class="  btn btn-sm btn-default" >{{$catorder}}</span><br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @foreach(@$protranslate->product->pack()->pluck('title') as $pack)
                                            @if($pack=='طلایی')
                                            <span  class="label pull-center bg-yellow-gradient" >{{$pack}}</span><br>
                                            @elseif($pack == 'نقره ای')
                                                <span  class="label pull-center  bg-green-gradient" >{{$pack}}</span><br>
                                            @elseif($pack == 'برنزی')
                                                <span  class="label pull-center bg-maroon-gradient" >{{$pack}}</span><br>
                                            @endif
                                        @endforeach
                                    </td>
                                        <td class="text-center">
                                            @if($protranslate->product['status']==0)
                                                <a  class="label pull-center bg-maroon" >در انتظار پرداخت هزینه منبع یابی</a>
                                            @elseif($protranslate->product['status']==1)
                                                <a  class="label pull-center bg-navy" >کوپن تخفیف خود را استفاده کرد</a>
                                            @elseif($protranslate->product['status']==2)
                                                <a  class="label pull-center bg-olive" >پرداخت منبع یابی</a>
                                            @elseif($protranslate->product['status']==3)
                                                <a class="label pull-center bg-orange">سفارش حاضر شده در انتظار پرداخت</a>
                                            @elseif($protranslate->product['status']==4)
                                                <a  class="label pull-center bg-purple" >پرداخت نهایی انجام شد</a>
                                            @elseif($protranslate->product['status']==5)
                                                <a  class="label pull-center bg-teal" >در دست اقدام</a>
                                            @elseif($protranslate->product['status']==6)
                                                <a  class="label pull-center bg-blue-active" >درخواست مجدد</a>
                                            @elseif($protranslate->product['status']==7)
                                                <a  class="label pull-center bg-fuchsia" >ترجمه شد</a>
                                            @elseif($protranslate->product->status==8)
                                                <a  class="label pull-center bg-yellow-gradient" >هزینه خرید کالا پرداخت شد</a>
                                            @elseif($protranslate->product->status==9)
                                                <a  class="label pull-center bg-green-gradient" >هزینه ترخیص کالا پرداخت شد</a>
                                            @elseif($protranslate->product->status==10)
                                                <a  class="label pull-center bg-blue-gradient" >هزینه ترخیص کالا تعیین شد</a>
                                            @elseif($protranslate->product->status==11)
                                                <a  class="label pull-center bg-olive" >اطلاعات سفارش تکمیل شد</a>
                                            @elseif($protranslate->product->status==12)
                                                <a  class="label pull-center bg-olive" >در انتظار تکمیل اطلاعات سفارش</a>
                                            @elseif($protranslate->product->status==13)
                                                <a  class="label pull-center bg-olive" >کاربر انصراف داد</a>
                                            @elseif($protranslate->product->status==14)
                                                <a  class="label pull-center bg-blue-gradient" >سفارش حاضر است</a>
                                            @elseif($protranslate->product->status==15)
                                                <a  class="label pull-center bg-orange" >حذف شده توسط کاربر(لغو)</a>
                                            @elseif($protranslate->product->status==16)
                                                <a  class="label pull-center bg-green-gradient" >تایید الکترونیکی انجام شد</a>
                                            @endif
                                        </td>
                                    <td class="text-center">
                                        @if($protranslate->status == 0)
                                            <a  class="label pull-center bg-purple" >ثبت شده</a>
                                        @elseif($protranslate->status==1)
                                            <a  class="label pull-center bg-navy" >انصراف توسط کاربر</a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                       {{$protranslate->user->lastname}}
                                    </td>
                                     <td class="text-center">
                                       {{$protranslate->time}}روز
                                    </td>
                                    <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($protranslate->created_at)}}</td>
                                    <td class="text-center">
                                        <a class=" label pull-center bg-green" href="{{route('back.protranslates.show',$protranslate->id)}}">نمایش</a>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.protranslates.edit',$protranslate->id)}}">ویرایش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.protranslates.destroy',$protranslate->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$protranslates->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
