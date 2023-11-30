@extends('back.index')
@section('content')
{{--    <div id="app">--}}
{{--        <example-component></example-component>--}}
{{--    </div>--}}
<section >
    <section class="content-header">
        <h1>
           سفارشات

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">سفارشات</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-4">
            <div class="box" style="padding: 30px ">
                <form action="{{route('productSearch')}}" method="get">
                    @csrf
                    <label style="display: inline-flex !important; ">مرتب سازی براساس نوع منبع یابی </label>
                        <div class="input-group input-group-sm">
                            <select  aria-controls="example1" class="form-control input-sm" name="pack_id">
                                @foreach($packs as $packs_id => $packs_name)
                                    <option value="{{$packs_id}}">{{$packs_name}}</option>
                                @endforeach
                            </select>
{{--                            <input type="text" class="form-control" placeholder="عبارت مورد جستجو ..." name="title" value="{{old('title')}}" >--}}
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-info btn-flat">مرتب سازی</button>
                            </span>
                        </div>
                </form>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="box" style="padding: 30px ">
                <form action="{{route('productCodeSearch')}}" method="get">
                    @csrf
                    <label style="display: inline-flex !important; ">جستجو براساس کد سفارش </label>
                    <div class="input-group input-group-sm">
                           <input type="text" class="form-control" placeholder="کد سفارش را وارد کنید" name="codepro" value="{{old('codepro')}}" >
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-info btn-flat">جستجو</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-xs-4">
            <div class="box" style="padding: 30px ">
                <form action="{{route('userCodeSearch')}}" method="get">
                    @csrf
                    <label style="display: inline-flex !important; ">جستجو براساس کد کاربری </label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="کد کاربر را وارد کنید" name="code" value="{{old('code')}}" >
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-info btn-flat">جستجو</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <div class="row" id="app">
        <div class="col-xs-12">
            <div class="box">
        <div class="box-header">
            <h3 class="box-title">لیست سفارشات</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <form action="{{route('back.products.delete.all')}}" method="post" class="form-inline">
                {{csrf_field()}}
                {{@method_field('delete')}}
                <div class="form-group">
                    <select name="checkBoxArray" class="form-control">
                        <option value="delete">حذف گروهی</option>
                    </select>
                    <input class="btn btn-sm btn-primary" type="submit" name="submit" value="اعمال">
                </div>
                     @include('back.massages')
                     <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
                        <table id="example2" class="table table-responsive table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" >
                                    <input type="checkbox" id="options">
                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">

                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    تصویر
                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    عنوان
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    شناسه کاربر
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    امتیاز کاربر
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                 کد سفارش
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  خلاصه شرح سفارش
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    دسته بندی
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  تعداد سفارش
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  نوع منبع یابی
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                   مبلغ پرداختی/منبع یابی
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  وضعیت
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    تاریخ ایجاد
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    تاریخ بروزرسانی
                                </th>
{{--                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">--}}
{{--                                    تاریخ پرداخت منبع یابی--}}
{{--                                </th>--}}
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  مديريت
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                @if($product->user)
                                <tr role="row" class="odd">
                                    <td><input type="checkbox" id="options" name="checkBoxArray[]" value="{{$product->id}}"></td>
                                    <td dir="ltr">{{$product->id}}</td>


                                    @if($product->photos->pluck('path')->first())
                                        <td class="text-center">
                                            <img src="{{$product->photos->pluck('path')->first()}}" style="border-radius: 10px; width:50px;     height: 50px;" >
                                        </td>
                                    @else
                                        <td class="text-center">
                                            <i class="fa fa-window-close" style="color: #f39c12;"></i>
                                        </td>
                                    @endif
                                    <td class="text-center"><a href="{{route('back.products.show',$product->id)}}">{!! mb_substr($product->title,0,10).'..'!!} </a></td>

                                     <td class="text-center" dir="ltr">
                                         @if(isset($product->user))
                                                {{$product->user->code}}
                                             @endif
                                     </td>
                                     <td>
                                         @if(isset($product->user))
                                         {{$product->user->rate}}
                                         @endif
                                     </td>

                                    <td class="text-center">{{$product->codepro}} </td>
                                    <td class="text-center">{!! mb_substr($product->description,0,50).'..'!!}</td>

                                    <td class="text-center">
                                        @foreach(@$product->catorder()->pluck('title') as $catorder)
                                            <span  class="  btn btn-sm btn-default" >{{$catorder}}</span><br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">{{$product->number}}</td>
                                    <td class="text-center">
                                        @foreach(@$product->pack()->pluck('title') as $pack)
                                            @if($pack == 'طلایی')
                                            <span  class="label pull-center bg-yellow-gradient" >{{$pack}}</span><br>
                                            @elseif($pack == 'نقره ای')
                                            <span  class="label pull-center bg-green-gradient" >{{$pack}}</span><br>
                                            @elseif($pack == 'برنزی')
                                            <span  class="label pull-center bg-maroon-gradient" >{{$pack}}</span><br>
                                            @endif
                                        @endforeach
                                    </td>
                                        <td class="text-center">{{$product->amount}}</td>
                                        <td class="text-center">
                                        @if($product['status']==0)
                                            <a  class="label pull-center bg-maroon" >در انتظار پرداخت هزینه منبع یابی</a>
                                        @elseif($product['status']==1)
                                            <a  class="label pull-center bg-navy" >کوپن تخفیف خود را استفاده کرد</a>
                                        @elseif($product['status']==2)
                                            <a  class="label pull-center bg-olive" >هزینه منبع یابی پرداخت شد</a>
                                        @elseif($product['status']==3)
                                            <a class="label pull-center bg-orange">سفارش حاضر شده در انتظار پرداخت</a>
                                        @elseif($product['status']==4)
                                            <a  class="label pull-center bg-purple" >پرداخت نهایی انجام شد</a>
                                            @elseif($product['status']==5)
                                                <a  class="label pull-center bg-teal" >در دست اقدام</a>
                                            @elseif($product['status']==6)
                                                <a  class="label pull-center bg-blue-active" >درخواست مجدد</a>
                                            @elseif($product['status']==7)
                                                <a  class="label pull-center bg-fuchsia" >ترجمه شد</a>
                                            @elseif($product->status==8)
                                                <a  class="label pull-center bg-yellow-gradient" >هزینه خرید کالا پرداخت شد</a>
                                            @elseif($product->status==9)
                                                <a  class="label pull-center bg-green-gradient" >هزینه ترخیص کالا پرداخت شد</a>
                                            @elseif($product->status==10)
                                                <a  class="label pull-center bg-blue-gradient" >هزینه ترخیص کالا تعیین شد</a>
                                            @elseif($product->status==11)
                                                <a  class="label pull-center bg-olive" >اطلاعات سفارش تکمیل شد</a>
                                            @elseif($product->status==12)
                                                <a  class="label pull-center bg-olive" >در انتظار تکمیل اطلاعات سفارش</a>
                                            @elseif($product->status==13)
                                                <a  class="label pull-center bg-olive" >کاربر انصراف داد</a>
                                            @elseif($product->status==14)
                                                <a  class="label pull-center bg-blue-gradient" >سفارش حاضر است</a>
                                            @elseif($product->status==15)
                                                <a  class="label pull-center bg-orange" >حذف شده توسط کاربر(لغو)</a>
                                            @elseif($product->status==16)
                                                <a  class="label pull-center bg-green-gradient" >تایید الکترونیکی انجام شد</a>
                                        @endif
                                        </td>
                                        <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($product->created_at)}}</td>
                                        <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($product->updated_at)}}</td>
{{--                                        <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($product->timepayment)}}</td>--}}
                                        <td class="text-center" style="width: 180px;">
                                        <a class=" label pull-center bg-green" href="{{route('back.products.show',$product->id)}}">نمایش</a>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.products.edit',$product->id)}}">ویرایش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.products.destroy',$product->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$products->links()}}
        </div>
            </form>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
    </div>
</section>
@endsection
