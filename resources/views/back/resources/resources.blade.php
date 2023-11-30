@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
            درخواست همکاری های به عنوان منبع

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="{{route('back.resources')}}">درخواست همکاری به عنوان منبع</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست درخواست های همکاری به عنوان منبع</h3>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    @include('back.massages')
                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
                                <table id="example2" class="table table-bordered table-responsive  table-hover dataTable" role="grid" aria-describedby="example2_info">
                                    <thead>
                                    <tr role="row">
                                        <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                            نام و نام خانوادگی
                                        </th>
                                        <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                            شماره موبایل
                                        </th>
                                        <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                           نام شرکت/نام برند
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                           سمت کاری
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                            زمینه کاری
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                            استان/شهر
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                            تاریخ ارسال
                                        </th>
                                        <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                            مديريت
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-responsive">
                                    @foreach($resources as $resource)
                                        <tr role="row" class="odd">
                                            <td class="text-center">{{$resource->name}}-{{$resource->lastname}}</td>
                                            <td class="text-center">{{$resource->mobile}}</td>
                                            <td class="text-center"> {{$resource->brandname}}</td>
                                            <td class="text-center"> {{$resource->job}}</td>
                                            <td class="text-center">{{$resource->catorder->title}}</td>
                                            <td class="text-center">{{$resource->province->name}}-{{$resource->city->name}}</td>
                                            <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($resource->created_at)}}</td>
                                            <td class="text-center">
                                                <a class=" label pull-center bg-aqua" href="{{route('back.resources.show',$resource->id)}}">نمایش</a>
{{--                                                <a class=" label pull-center bg-green" href="{{route('back.resources.edit',$resource->id)}}">ویرایش</a>--}}
                                                <a class=" label pull-center bg-red" href="{{route('back.resources.destroy',$resource->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>

                                </table>
                            </div>
                        </div>
                        {{$resources->links()}}
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
@endsection
