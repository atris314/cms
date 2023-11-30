@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
          تراکنش ها/پرداخت ها

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#"> تراکنش ها/پرداخت ها</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست  تراکنش ها/پرداخت ها</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">

                    </div>
                </div>
                <hr>

        <!-- /.box-header -->
        <div class="box-body">
            @include('back.massages')
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    شناسه محصول
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    شناسه کاربر
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    ایمیل
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    عنوان محصول
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    مبلغ پرداخت
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    عنوان پرداخت
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                   شماره فاکتور
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    تاریخ پرداخت
                                </th>
{{--                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">--}}
{{--                                    تاریخ بروزرسانی--}}
{{--                                </th>--}}
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  مديريت
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($nextpayments as $payment)
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><a href="{{route('back.nextpayments.show',$payment->id)}}">@if($payment->product){{$payment->product->codepro}} @endif</a></td>
                                    <td>@if($payment->user){{$payment->user->code}}@endif</td>
                                    <td>@if($payment->user){{$payment->user->email}}@endif</td>
                                    <td>@if($payment->product){{$payment->product->title}}@endif</td>
                                    <td>{{$payment->amount}}</td>
                                    <td>{{$payment->ordernextpay->payer_desc}}</td>
                                    <td>{{$payment->order_id}}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($payment->created_at)}}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($payment->updated_at)}}</td>
                                        <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.nextpayments.show',$payment->id)}}">مشاهده فاکتور</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$nextpayments->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
