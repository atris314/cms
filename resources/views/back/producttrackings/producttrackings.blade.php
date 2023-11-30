@extends('back.index')
@section('content')
    {{--    <div id="app">--}}
    {{--        <example-component></example-component>--}}
    {{--    </div>--}}
    <section >
        <section class="content-header">
            <h1>
                کد رهگیری مرسولات

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
                <li><a href="#">کد رهگیری مرسولات</a></li>

            </ol>
        </section>

        <div class="row" id="app">
            <div class="col-xs-12">
                <div class="box">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست کد رهگیری مرسولات</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('back.producttrackings.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                        @include('back.massages')
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
                                    <table id="example2" class="table table-responsive table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                                کد رهگیری مرسوله
                                            </th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                                شناسه کاربر
                                            </th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                کد  پیگیری سفارش
                                            </th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                تاریخ ایجاد
                                            </th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                تاریخ بروزرسانی
                                            </th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                مديريت
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($producttrackings as $producttracking)
                                            @if($producttracking->product->user)
                                                <tr role="row" class="odd">
                                                    <td class="text-center">{{$producttracking->trackcode}}</td>
                                                    <td class="text-center" dir="ltr">
                                                        @if(isset($producttracking->product->user))
                                                            {{$producttracking->product->user->code}}
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{$producttracking->productcode}}</td>

                                                    <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($producttracking->created_at)}}</td>
                                                    <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($producttracking->updated_at)}}</td>
                                                    <td class="text-center" style="width: 180px;">
                                                        <a class=" label pull-center bg-green" href="{{route('back.producttrackings.show',$producttracking->id)}}">نمایش</a>
                                                        <a class=" label pull-center bg-aqua" href="{{route('back.producttrackings.edit',$producttracking->id)}}">ویرایش</a>
                                                        <a class=" label pull-center bg-red" href="{{route('back.producttrackings.destroy',$producttracking->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            {{$producttrackings->links()}}
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
