@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
         لیست سفارشات حاضر شده و ارسال شده برای کاربر

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">لیست سفارشات حاضر شده</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box" style="padding: 30px ">
                <form action="{{route('presentCodeSearch')}}" method="get">
                    @csrf
                    <label style="display: inline-flex !important; ">جستجو براساس کد سفارش </label>
                    <div class="input-group input-group-sm col-lg-4">
                        <input type="text" class="form-control" placeholder="کد سفارش را وارد کنید" name="productcode" value="{{old('productcode')}}" >
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
            <h3 class="box-title">لیست سفارشات حاضر شده</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('back.massages')
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row">
                    <div class="col-sm-6"></div><div class="col-sm-6"></div></div>
                        <div class="row">
                            <div class="col-sm-12">
                        <table  class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">

                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">
                                    کد سفارش
                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">
                                    شناسه کاربر
                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    تصویر
                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                  زمان تحویل عادی
                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                  زمان تحویل فوری
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    دسته بندی
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                هزینه خرید کالا
                                </th>
                                <th style="width: 92px" class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                هزینه تریخص عادی کالا
                                </th>
                                <th style="width: 92px" class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                هزینه تریخص فوری کالا
                                </th>
                                <th style="width: 92px" class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                هزینه قابل پرداخت
                                </th>
{{--                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">--}}
{{--                                وضعیت نهایی سفارش--}}
{{--                                </th>--}}
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                وضعیت سفارش
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                تایید کاربر
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
                            @foreach($presents as $present)
                                @if(isset($present->product))
                                <tr role="row" class="odd">
                                    <td>{{$i++}}</td>
                                    <td class="text-center">{{$present->productcode}}</td>
                                    <td dir="ltr" class="text-center">
                                        @foreach(@$present->user()->pluck('code') as $code)
                                            {{$code}}
                                        @endforeach
                                    </td>

                                        @if($present->photos->pluck('path')->first())
                                        <td class="text-center">
                                            <img src="{{$present->photos->pluck('path')->first()}}" style="border-radius: 10px; width:50px;     height: 50px;" >
                                        </td>
                                            @else
                                        <td class="text-center">
                                            <i class="fa fa-window-close" style="color: #f39c12;"></i>
                                        </td>
                                        @endif

                                    <td class="text-center">{{$present->deliverytime}}</td>
                                    <td class="text-center">{{$present->quick}}</td>
                                    <td class="text-center">
                                        @foreach(@$present->product->catorder()->pluck('title') as $catorder)
                                            <span  class="  btn btn-sm btn-default" >{{$catorder}}</span><br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">{{$present->price}}
                                        @if($present->currency==0)
                                            <i class="icofont-riyal"></i>
                                        @elseif($present->currency==1)
                                            <i class="icofont-dollar"></i>
                                        @elseif($present->currency==2)
                                            <i class="icofont-euro"></i>
                                        @elseif($present->currency==3)
                                            <i class="icofont-yen"></i>
                                        @else
                                            تومان
                                        @endif
                                    </td>
                                    <td class="text-center">@if(isset($present->releaseprice)) {{$present->releaseprice}}
                                        @if($present->currency==0)
                                            <i class="icofont-riyal"></i>
                                        @elseif($present->currency==1)
                                            <i class="icofont-dollar"></i>
                                        @elseif($present->currency==2)
                                            <i class="icofont-euro"></i>
                                        @elseif($present->currency==3)
                                            <i class="icofont-yen"></i>
                                        @else
                                            تومان
                                        @endif  @else درحال بررسی @endif
                                    </td>
                                    <td class="text-center">@if(isset($present->quickprice)) {{$present->quickprice}}
                                        @if($present->currency==0)
                                            <i class="icofont-riyal"></i>
                                        @elseif($present->currency==1)
                                            <i class="icofont-dollar"></i>
                                        @elseif($present->currency==2)
                                            <i class="icofont-euro"></i>
                                        @elseif($present->currency==3)
                                            <i class="icofont-yen"></i>
                                        @else
                                            تومان
                                        @endif  @else درحال بررسی @endif
                                    </td>
                                    <td class="text-center" style="width: 108px;">
                                        از سمت کاربر قبل از پرداخت محاسبه میشود
                                    </td>
{{--                                        <td class="text-center">--}}
{{--                                        @if($present->status == 0)--}}
{{--                                            <a  class="label pull-center bg-yellow-gradient" >در انتظار پرداخت</a>--}}
{{--                                        @elseif($present->status==1)--}}
{{--                                            <a  class="label pull-center bg-green-gradient" >پرداخت شده</a>--}}
{{--                                        @elseif($present->status==2)--}}
{{--                                            <a  class="label pull-center bg-navy" >انصراف توسط کاربر</a>--}}
{{--                                        @elseif($present->status==3)--}}
{{--                                            <a  class="label pull-center bg-blue-gradient" >در انتظار پرداخت هزینه ترخیص</a>--}}
{{--                                            @elseif($present->status==4)--}}
{{--                                            <a  class="label pull-center bg-blue-gradient" >هزینه خرید کالا پرداخت شد</a>--}}
{{--                                            @elseif($present->status==5)--}}
{{--                                            <a  class="label pull-center bg-blue-gradient" >هزینه ترخیص کالا پرداخت شد</a>--}}
{{--                                        @endif--}}
{{--                                        </td>--}}
                                    <td class="text-center">
                                        @if($present->product['status']==0)
                                            <a  class="label pull-center bg-maroon" >در انتظار پرداخت هزینه منبع یابی</a>
                                        @elseif($present->product['status']==1)
                                            <a  class="label pull-center bg-navy" >کوپن تخفیف خود را استفاده کرد</a>
                                        @elseif($present->product['status']==2)
                                            <a  class="label pull-center bg-olive" >پرداخت منبع یابی</a>
                                        @elseif($present->product['status']==3)
                                            <a class="label pull-center bg-orange">سفارش حاضر شده در انتظار پرداخت</a>
                                        @elseif($present->product['status']==4)
                                            <a  class="label pull-center bg-purple" >پرداخت نهایی انجام شد</a>
                                        @elseif($present->product['status']==5)
                                            <a  class="label pull-center bg-teal" >در دست اقدام</a>
                                        @elseif($present->product['status']==6)
                                            <a  class="label pull-center bg-blue-active" >درخواست مجدد</a>
                                        @elseif($present->product['status']==7)
                                            <a  class="label pull-center bg-fuchsia" >ترجمه شد</a>
                                        @elseif($present->product->status==8)
                                            <a  class="label pull-center bg-yellow-gradient" >هزینه خرید کالا پرداخت شد</a>
                                        @elseif($present->product->status==9)
                                            <a  class="label pull-center bg-green-gradient" >هزینه ترخیص کالا پرداخت شد</a>
                                        @elseif($present->product->status==10)
                                            <a  class="label pull-center bg-blue-gradient" >هزینه ترخیص کالا تعیین شد</a>
                                        @elseif($present->product->status==11)
                                            <a  class="label pull-center bg-olive" >اطلاعات سفارش تکمیل شد</a>
                                        @elseif($present->product->status==12)
                                            <a  class="label pull-center bg-olive" >در انتظار تکمیل اطلاعات سفارش</a>
                                        @elseif($present->product->status==13)
                                            <a  class="label pull-center bg-olive" >کاربر انصراف داد</a>
                                        @elseif($present->product->status==14)
                                            <a  class="label pull-center bg-blue-gradient" >سفارش حاضر است</a>
                                        @elseif($present->product->status==15)
                                            <a  class="label pull-center bg-orange" >حذف شده توسط کاربر(لغو)</a>
                                        @elseif($present->product->status==16)
                                            <a  class="label pull-center bg-green-gradient" >تایید الکترونیکی انجام شد</a>
                                        @endif
                                        </td>
                                    <td class="text-center" style="width: 108px;">@if(isset($present->confirm))کاربر، اطلاعات سفارش و منبع یابی را تایید کرد<i class="fa fa-check-square-o" style="color: #24c39e;font-size: 14pt;" aria-hidden="true"></i>@endif</td>
                                    <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($present->created_at)}}</td>
                                    <td class="text-center">
                                        <a class=" label pull-center bg-aqua" href="{{route('back.presents.show',$present->id)}}">نمایش</a>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.presents.edit',$present->id)}}">بروزرسانی</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.presents.destroy',$present->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                           </tbody>

                        </table>

                                <table id="tableID" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info" >
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">
                                            کد سفارش
                                        </th>
                                        <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">
                                            عنوان سفارش
                                        </th>
                                        <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">
                                            شناسه کاربر
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                            تاریخ ثبت سفارش
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                            تاریخ پرداخت هزینه منبع یابی
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                            تاریخ پرداخت هزینه نهایی
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; ?>
                                    @foreach($payments as $payment)
                                        @if(isset($payment->product))
                                            <tr role="row" class="odd">
                                                <td class="text-center">{{$payment->product->codepro}}</td>
                                                <td class="text-center">{{$payment->product->title}}</td>
                                                <td dir="ltr" class="text-center">
                                                    @foreach(@$payment->user()->pluck('code') as $code)
                                                        {{$code}}
                                                    @endforeach
                                                </td>
                                                <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($payment->product->created_at)}}</td>
                                                <td class="text-center" style="font-size:10px;">
                                                    @if($payment->ordernextpay)
                                                    @if($payment->ordernextpay->payer_desc == 'پرداخت هزینه منبع یابی')
                                                        {{\Hekmatinasser\Verta\Verta::instance($payment->ordernextpay->created_at)}}
                                                    @endif
                                                        @endif
                                                </td>
                                                <td class="text-center" style="font-size:10px;">
                                                    @if($payment->ordernextpay)
                                                    @if($payment->ordernextpay->payer_desc == 'پرداخت نهایی')
                                                        {{\Hekmatinasser\Verta\Verta::instance($payment->ordernextpay->created_at)}}
                                                    @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                    </tbody>

                                </table>
                        <button class="btn btn-block btn-lg pull-center bg-aqua" id="present-export-to-excel" onclick="exportTableToExcel('tableID')">خروجی اکسل</button>
                    </div>
                </div>
                {{$presents->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
