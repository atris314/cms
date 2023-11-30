@extends('back.index')
@section('content')
    {{--    <div id="app">--}}
    {{--        <example-component></example-component>--}}
    {{--    </div>--}}
    <section >
        <section class="content-header">
            <h1>
                سفارشات دارای امضای الکترونیکی

            </h1>
            <ol class="breadcrumb">
                <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
                <li><a href="#">سفارشات دارای امضای الکترونیکی</a></li>

            </ol>
        </section>
        <div class="row" id="app">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">لیست </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @include('back.massages')
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
                                    <table id="example2" class="table table-responsive table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                        <thead>
                                        <tr role="row">
                                            <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">

                                            </th>
                                            <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                                تصویر
                                            </th>
                                            <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                                عنوان سفارش
                                            </th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                                شناسه کاربر
                                            </th>
                                            <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                                کد سفارش
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
                                        @foreach($confirmations as $confirmation)
                                            @if($confirmation->user)
                                                <tr role="row" class="odd">
                                                    <td dir="ltr">{{$confirmation->id}}</td>
                                                    @if($confirmation->product_id)
                                                        <td class="text-center">
                                                            @if($confirmation->product->photos)
                                                            <img src="{{$confirmation->product->photos->pluck('path')->first()}}" style="border-radius: 10px; width:50px;     height: 50px;" >
                                                            @endif
                                                        </td>
                                                    @else
                                                        <td class="text-center">
                                                            <i class="fa fa-window-close" style="color: #f39c12;"></i>
                                                        </td>
                                                    @endif
                                                    <td class="text-center"><a href="{{route('back.confirmations.show',$confirmation->id)}}">{!! mb_substr($confirmation->protitle,0,10).'..'!!} </a></td>
                                                    <td class="text-center" dir="ltr">
                                                        @if(isset($confirmation->user))
                                                            {{$confirmation->user->code}}
                                                        @endif
                                                    </td>
                                                    <td class="text-center">{{$confirmation->product->codepro}} </td>
                                                    <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($confirmation->created_at)}}</td>
                                                    <td class="text-center" style="width: 180px;">
                                                        <a class=" label pull-center bg-green" href="{{route('back.confirmations.show',$confirmation->id)}}">نمایش</a>
                                                        <a class=" label pull-center bg-red" href="{{route('back.confirmations.destroy',$confirmation->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            {{$confirmations->links()}}
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
