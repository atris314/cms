@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
          دسته بندي نوع همکاری

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">دسته بندي نوع همکاری</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست دسته بندي </h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('back.catworks.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
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
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    نام مستعار
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    سرگروه
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
                            @foreach($catworks as $catwork)
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><a href="{{route('back.catworks.edit',$catwork->id)}}">{!! mb_substr($catwork->title,0,10).'..'!!} </a></td>
                                    <td>{{$catwork->slug}}</td>
                                    <td>
                                        @if($catwork->sumcatwork->count()>0)
                                            @foreach($catwork->sumcatwork()->pluck('title') as $submenu)
                                                {{$submenu}}
                                            @endforeach
                                        @endif
                                    </td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($catwork->created_at)}}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($catwork->updated_at)}}</td>
                                        <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.catworks.edit',$catwork->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.catworks.destroy',$catwork->id)}}" onclick="return confirm('دسته بندي مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$catworks->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
