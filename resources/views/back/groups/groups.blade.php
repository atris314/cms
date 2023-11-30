@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
          دسته بندي سفارشات

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">گروه بندی  </a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست گروه بندی</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('back.groups.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
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
                                    id
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                   عنوان
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                 دسته بندی
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  مديريت
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($groups as $group)
                                <tr role="row" class="odd">
                                    <td>{{$group->id}}</td>
                                    <td class="sorting_1"><a href="{{route('back.catorders.edit',$group->id)}}">{{$group->title}} </a></td>
                                    <td>
                                        @foreach(@$group->catorder()->pluck('title') as $catorder)
                                            <span  class="  btn btn-sm btn-default" >{{$catorder}}</span><br>
                                        @endforeach
                                    </td>
                                        <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.groups.edit',$group->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.groups.destroy',$group->id)}}" onclick="return confirm('گروه مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$groups->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
