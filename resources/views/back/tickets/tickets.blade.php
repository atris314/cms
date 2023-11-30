@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
          تیکت ها

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="{{route('back.tickets')}}">تیکت ها </a></li>

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
                        <a href="{{route('back.tickets.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
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
                                   شناسه کاربر
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                 پشتیبان مورد نظر
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
                            @foreach($tickets as $ticket)
                                <tr role="row" class="odd">
                                    <td>{{$ticket->id}}</td>
                                    <td class="sorting_1"><a href="{{route('back.tickets.edit',$ticket->id)}}">{!! mb_substr($ticket->title,0,10).'..'!!} </a></td>
                                    @if(isset($ticket->user_id))
                                        <td dir="ltr">{{$ticket->user->code}}</td>
                                    @endif

                                    <td class="text-center">
                                        @foreach(@$ticket->catorder()->pluck('title') as $catorder)
                                            <span  class="  btn btn-sm btn-default" >{{$catorder}}</span><br>
                                        @endforeach
                                    </td>
                                    <td>{{$ticket->ticket_id}}</td>
                                    <td>{!! mb_substr($ticket->message,0,50).'...'!!} </td>
                                    <td class="text-center">
                                        @if($ticket['status']==0)
                                            <a class="btn btn-sm btn-info">بسته شده  </a>
                                        @elseif($ticket['status']==1)
                                            <a class="btn btn-sm btn-success">فعال </a>
                                        @elseif($ticket['status']==2)
                                            <a class="btn btn-sm btn-danger">پاسخ داده شده </a>
                                        @endif
                                    </td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($ticket->created_at)}}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($ticket->updated_at)}}</td>
                                        <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.tickets.show',$ticket->id)}}">نمایش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.tickets.destroy',$ticket->id)}}" onclick="return confirm('تیکت مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$tickets->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
