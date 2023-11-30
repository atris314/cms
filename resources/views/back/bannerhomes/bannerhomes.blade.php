@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
         بنر هدر

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">بنر هدر</a></li>

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
                        <a href="{{route('back.bannerhomes.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
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
                                    alt بنر
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                   متن دکمه
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                   لینک دکمه
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
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
                            @foreach($bannerhomes as $bannerhome)
                                <tr role="row" class="odd">
                                    @if($bannerhome->photo_id)
                                        <td class="text-center"><img src="{{$bannerhome->photo->path}}" style="border-radius: 30px; width:100px;     height: 50px;" ></td>
                                    @else
                                        <td class="text-center"><img src="{{url('back/dist/img/placeholder.jpg')}}" style="border-radius: 50%; width:50px;     height: 50px;"></td>
                                    @endif
                                    <td class="sorting_1"><a href="{{route('back.bannerhomes.edit',$bannerhome->id)}}">{{$bannerhome->alt}}</a></td>
                                    <td class="sorting_1">{{$bannerhome->button}}</td>
                                    <td class="sorting_1">{{$bannerhome->link}}</td>
                                        <td class="text-center">
                                            <?php
                                            $url = route('back.bannerhomes.status',$bannerhome->id);
                                            if ($bannerhome['status']==0){
                                                echo '<a href="'.$url.'" class="label pull-center bg-green">نمایش داده شود </a>';
                                            }
                                            else{
                                                echo '<a href="'.$url.'" class=" label pull-center bg-yellow">نمایش داده نشود  </a>';
                                            }
                                            ?>
                                        </td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($bannerhome->created_at)}}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($bannerhome->updated_at)}}</td>
                                        <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.bannerhomes.edit',$bannerhome->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.bannerhomes.destroy',$bannerhome->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$bannerhomes->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
