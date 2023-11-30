@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
         رسید پرداختی های مشتریان

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">رسید پرداختی های مشتریان</a></li>

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

                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    نام کاربر
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    کد کاربر
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    عنوان سفارش
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    کد سفارش
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
                            @foreach($resids as $resid)
                                @if($resid->user)
                                <tr role="row" class="odd">
                                    @if($resid->photo_id)
                                        <td><img src="{{$resid->photo->path}}" style="border-radius: 50%; width:50px;     height: 50px;" ></td>
                                    @else
                                        <td><img src="{{url('back/dist/img/placeholder.jpg')}}" style="border-radius: 50%; width:50px;     height: 50px;"></td>
                                    @endif
                                    <td class="sorting_1">{{$resid->user->name}}</td>
                                    <td class="sorting_1">{{$resid->user->code}}</td>
                                        @foreach(@$resid->product()->pluck('title') as $pro)
                                            @if(isset($pro))
                                            <td>{{$pro}}</td>
                                                @else
                                                <td></td>
                                            @endif
                                        @endforeach
                                        @foreach(@$resid->product()->pluck('codepro') as $pro)
                                            @if(isset($pro))
                                                <td>{{$pro}}</td>
                                            @else
                                                <td></td>
                                            @endif
                                        @endforeach
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($resid->created_at)}}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($resid->updated_at)}}</td>
                                        <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.resids.show',$resid->id)}}">نمایش</a>
                                            @foreach(@$resid->product()->pluck('id') as $id)
                                                <a class=" label pull-center bg-aqua" href="{{route('back.products.edit',$id)}}">ویرایش سفارش</a>
                                            @endforeach
                                        <a class=" label pull-center bg-red" href="{{route('back.resids.destroy',$resid->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$resids->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
    </div>
@endsection
