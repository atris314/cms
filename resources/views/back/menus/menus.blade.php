@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
          منوها

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">منوها</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست منوها</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('back.menus.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
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
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    سرگروه
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  ترتیب نمایش
                                </th>

                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  لینک
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
                            @foreach($menus as $menu)
                                <tr role="row" class="odd">
                                    @if($menu->photo_id)
                                        <td class="text-center"><img src="{{$menu->photo->path}}" style="border-radius: 10px; width:50px;     height: 50px;" ></td>
                                    @else
                                        <td class="text-center"><img src="{{url('back/dist/img/placeholder.jpg')}}" style="border-radius: 10px; width:50px;     height: 50px;"></td>
                                    @endif
                                    <td class="sorting_1"><a href="{{route('back.menus.edit',$menu->id)}}">{{$menu->title}}</a></td>
                                    <td>
                                        @if($menu->submenu->count()>0)
                                            @foreach($menu->submenu()->pluck('title') as $submenu)
                                                {{$submenu}}
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{$menu->sort}}</td>
                                    <td>{{$menu->url}}</td>
                                    <td>
                                        <?php
                                        $url = route('back.menus.status',$menu->id);
                                        if ($menu['status']==1){
                                            echo '<a href="'.$url.'" class="label pull-center bg-green">فعال </a>';
                                        }
                                        else{
                                            echo '<a href="'.$url.'" class=" label pull-center bg-yellow">غیرفعال  </a>';
                                        }
                                        ?>
                                    </td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($menu->created_at)}}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($menu->updated_at)}}</td>
                                        <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.menus.edit',$menu->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.menus.destroy',$menu->id)}}" onclick="return confirm('منو مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$menus->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
