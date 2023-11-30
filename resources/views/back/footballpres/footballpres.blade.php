@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
         پیش بینی بازی ها

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">پیش بینی بازی ها </a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست </h3>
                        </div>
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
                                    تیم
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    تیم رقیب
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    تاریخ و ساعت شروع بازی
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    کد کاربر
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    نام کاربر
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    پیش بینی کاربر
                                </th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($footballpres as $footballpre)
                                <tr role="row" class="odd">
                                    <td class="sorting_1">ایران</td>
                                    <td class="sorting_1">{{$footballpre->football->teamname}}</td>
                                    <td>{{$footballpre->football->time}} - {{$footballpre->football->date}}</td>
                                    <td style="direction: ltr; text-align:center;  ">{{$footballpre->user->code}}</td>
                                    <td>{{$footballpre->user->name}} {{$footballpre->user->lastname}}</td>
                                    <td>{{$footballpre->answer}}</td>
                                    <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.footballpres.edit',$footballpre->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.footballpres.destroy',$footballpre->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$footballpres->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
