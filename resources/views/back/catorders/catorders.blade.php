@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
          دسته بندي سفارشات

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">دسته بندي سفارشات</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست دسته بندي سفارشات</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('back.catorders.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
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
                                    نام مستعار
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    سرگروه
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    متاي توضيحات
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                 متاي برچسب ها
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
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
                            @foreach($catorders as $catorder)
                                <tr role="row" class="odd">
                                    @if($catorder->photo_id)
                                        <td><img src="{{$catorder->photo->path}}" style="border-radius: 50%; width:50px;     height: 50px;" ></td>
                                    @else
                                        <td><img src="{{url('back/dist/img/placeholder.jpg')}}" style="border-radius: 50%; width:50px;     height: 50px;"></td>
                                    @endif
                                    <td class="sorting_1"><a href="{{route('back.catorders.edit',$catorder->id)}}">{!! mb_substr($catorder->title,0,10).'..'!!} </a></td>
                                    <td>{{$catorder->slug}}</td>
                                    <td>
                                        @if($catorder->sumcatorder->count()>0)
                                            @foreach($catorder->sumcatorder()->pluck('title') as $submenu)
                                                {{$submenu}}
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{!! mb_substr($catorder->meta_description,0,30).'..'!!}</td>
                                    <td>{!! mb_substr($catorder->meta_keywords,0,30).'..'!!}</td>
                                        <td class="text-center">
                                            <?php
                                            $url = route('back.catorders.status',$catorder->id);
                                            if ($catorder['status']==0){
                                                echo '<a href="'.$url.'" class="label pull-center bg-green">منتشر شود </a>';
                                            }
                                            else{
                                                echo '<a href="'.$url.'" class=" label pull-center bg-yellow">منتشر نشود  </a>';
                                            }
                                            ?>
                                        </td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($catorder->created_at)}}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($catorder->updated_at)}}</td>
                                        <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.catorders.edit',$catorder->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.catorders.destroy',$catorder->id)}}" onclick="return confirm('دسته بندي مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$catorders->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
