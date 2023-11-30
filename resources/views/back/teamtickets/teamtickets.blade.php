@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
          تیکت های همکاران

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="{{route('back.teamtickets')}}">تیکت های همکاران </a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست تیکت ها</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('back.teamtickets.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
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

                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                   عنوان
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                   نام همکار
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                بخش پشتیبانی
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                 شناسه تیکت
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                 خلاصه پیام
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    وضعیت
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    تاریخ ایجاد
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    تاریخ بروزرسانی
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  مديريت
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teamtickets as $teamticket)
                                <tr role="row" class="odd">
                                    <td>{{$teamticket->id}}</td>
                                    <td class="sorting_1"><a href="{{route('back.teamtickets.edit',$teamticket->id)}}">{!! mb_substr($teamticket->title,0,10).'..'!!} </a></td>
                                    @if(isset($teamticket->user_id))
                                        <td>{{$teamticket->user['name']}}</td>
                                    @endif

                                    <td>
                                        @foreach(@$teamticket->catorder()->pluck('title') as $catorder)
                                            <span  class="  btn btn-sm btn-default" >{{$catorder}}</span><br>
                                        @endforeach
                                    </td>
                                    <td>{{$teamticket->ticket_id}}</td>
{{--                                    @if($teamticket->subticket)--}}
{{--                                        @foreach($teamticket->subticket()->pluck('reply') as $parent)--}}
{{--                                          <td>{{$parent}}</td>--}}
{{--                                        @endforeach--}}
{{--                                        @else--}}
{{--                                        <td></td>--}}
{{--                                    @endif--}}
                                    <td>{!! mb_substr($teamticket->message,0,50).'...'!!}</td>
                                    <td class="text-center">
                                        @if($teamticket['status']==0)
                                            <a class="btn btn-sm btn-info">بسته شده  </a>
                                            @elseif($teamticket['status']==1)
                                            <a class="btn btn-sm btn-success">فعال </a>
                                            @elseif($teamticket['status']==2)
                                            <a class="btn btn-sm btn-danger">پاسخ داده شده </a>
                                        @endif
                                    </td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($teamticket->created_at)}}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($teamticket->updated_at)}}</td>
                                        <td width="100px">
                                        <a class=" label pull-center bg-aqua" href="{{route('back.teamtickets.show',$teamticket->id)}}">نمایش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.teamtickets.destroy',$teamticket->id)}}" onclick="return confirm('تیکت مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$teamtickets->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
