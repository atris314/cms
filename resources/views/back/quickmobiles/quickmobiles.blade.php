@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
            شماره موبایل جهت دریافت مشاوره
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">شماره موبایل جهت دریافت مشاوره</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست شماره ها</h3>
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
                                   شماره موبایل
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  تاريخ ثبت
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  مديريت
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($quickmobiles as $quickmobile)
                                <tr role="row" class="odd">
                                    <td>{{$quickmobile->mobile}}</td>
                                    <td>{{\Hekmatinasser\Verta\Verta::instance($quickmobile->created_at)}}</td>
                                    <td>
                                        <a class=" label pull-center bg-red" href="{{route('back.quickmobiles.destroy',$quickmobile->id)}}" onclick="return confirm('تماس كاربر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$quickmobiles->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
