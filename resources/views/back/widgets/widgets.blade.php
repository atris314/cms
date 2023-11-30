@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
         توضحات نمایندگی

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">توضحات نمایندگی</a></li>

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
                    <div class="col-lg-3">
                        <a href="{{route('back.widgets.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
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
                                    عنوان
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    توضیحات
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
                            @foreach($widgets as $widget)
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><a href="{{route('back.widgets.edit',$widget->id)}}">{{$widget->title}}</a></td>
                                    <td>{!! mb_substr($widget->description,0,100).'..'!!}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($widget->created_at)}}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($widget->updated_at)}}</td>
                                        <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.widgets.edit',$widget->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.widgets.destroy',$widget->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$widgets->links()}}
        </div>
        <!-- /.box-body -->
    </div>
            </div>
        </div>
    </div>
@endsection
