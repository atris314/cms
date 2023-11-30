@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
           لیست فعالیت همکاران

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">فعالیت همکاران</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
        <div class="box-header">
            <h3 class="box-title">لیست فعالیت همکاران</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('back.massages')
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">
                                    شناسه همکار
                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">
                                    نام همکار
                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">
                                    امتیاز
                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">
                                    فعالیت ها
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    تعداد ترجمه ها
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  مديريت
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teammates as $teammate)
                                <tr role="row" class="odd">
                                    <td dir="ltr">
                                        {{$teammate->user->code}}
                                    </td>
                                    <td>
                                        {{$teammate->user->lastname}}
                                    </td>

                                    <td class="text-center">{{$teammate->rate}}</td>
                                    <td class="text-center" >{{$teammate->activity}}</td>
                                    <td class="text-center" >{{$teammate->count}}</td>
                                    <td class="text-center">
                                        <a class=" label pull-center bg-aqua" href="{{route('back.teamjobs.show',$teammate->id)}}">نمایش</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$teammates->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
