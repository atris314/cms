@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
            تراکنش ها|پرداخت های اولیه

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">تراکنش ها|پرداخت ها</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">لیست تراکنش ها|پرداخت ها</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('back.massages')
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
                                <table id="example2" class="table table-responsive table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                            شناسه کاربری
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                            مبلغ پرداختی
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                            وضعیت
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
                                    @foreach($transactions as $transaction)
                                        <tr role="row" class="odd">
                                            <td class="text-center" dir="ltr">{{$transaction->user->code}}</td>
                                            <td class="text-center">{{$transaction->paid}} تومان </td>
                                            <td class="text-center">
                                                @if($transaction['status']==0)
                                                    <a  class="label pull-center bg-maroon" >تراکنش ناموفق</a>
                                                @elseif($transaction['status']==1)
                                                    <a  class="label pull-center bg-navy" >تراکنش نامشخص در حال انجام</a>
                                                @elseif($transaction['status']==2)
                                                    <a  class="label pull-center bg-olive" >تراکنش موفق</a>
                                                @endif
                                            </td>
                                            <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($transaction->created_at)}}</td>
                                            <td class="text-center" style="width: 180px;">
                                                <a class=" label pull-center bg-aqua" href="{{route('back.productpurchases.show',$transaction->id)}}">جزئیات تراکنش</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        {{$transactions->links()}}
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
@endsection
