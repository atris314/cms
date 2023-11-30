@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
          کدهای معرف

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="{{route('back.idcodes')}}">کدهای معرف</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست کدهای معرف </h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('back.idcodes.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
                    </div>
                </div>
                <hr>

        <!-- /.box-header -->
        <div class="box-body">

            @include('back.massages')
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div><div class="row">
                    <div class="col-sm-12">
                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">

                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    کد معرف
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                   تعداد یابانه کوین
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
                            @foreach($idcodes as $idcode)
                                <tr role="row" class="odd">
                                    <td>{{$idcode->idcode}}</td>
                                    <td>{{$idcode->numbercoin}}</td>
                                    <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($idcode->created_at)}}</td>
                                    <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($idcode->updated_at)}}</td>
                                    <td>
                                        <a class=" label pull-center bg-green" href="{{route('back.idcodes.show',$idcode->id)}}" >نمایش</a>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.idcodes.edit',$idcode->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.idcodes.destroy',$idcode->id)}}" onclick="return confirm('کوپن مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>
                        </table>
                    </div>
                </div>
                {{$idcodes->links()}}
            </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
