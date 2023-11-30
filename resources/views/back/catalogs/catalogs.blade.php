@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
          کاتالوگ

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">کاتالوگ</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست کاتالوگ ها</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('back.catalogs.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
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
                                    تصویر
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    عنوان
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    لینک
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    مبلغ
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  توضیحات
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                   دسته بندی
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
                            @foreach($catalogs as $catalog)
                                <tr role="row" class="odd">
                                    @if(isset($catalog->photo_id))
                                        <td class="text-center"><img src="{{$catalog->photo['path']}}" style="border-radius: 10px; width:50px;     height: 50px;" ></td>
                                    @else
                                        <td class="text-center"><img src="{{url('back/dist/img/placeholder.jpg')}}" style="border-radius: 10px; width:50px;     height: 50px;"></td>
                                    @endif
                                    <td class="sorting_1"><a href="{{route('back.catalogs.edit',$catalog->id)}}">{!! mb_substr($catalog->title,0,10).'..'!!} </a></td>
                                    <td>{{$catalog->link}}</td>
                                    <td>{{$catalog->price}}</td>
                                    <td>{!! mb_substr($catalog->body,0,80).'..'!!}</td>
                                    <td class="text-center">
                                        @foreach(@$catalog->catalogcat()->pluck('title') as $catalogcat)
                                            <span style="font-family: 'p30'; width: 100px;" class="  btn btn-sm btn-default" >{{$catalogcat}}</span><br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $url = route('back.catalogs.status',$catalog->id);
                                        if ($catalog['status']==0){
                                            echo '<a href="'.$url.'" class="label pull-center bg-green">منتشر شده </a>';
                                        }
                                        else{
                                            echo '<a href="'.$url.'" class=" label pull-center bg-yellow">منتشر نشده  </a>';
                                        }
                                        ?>
                                    </td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($catalog->created_at)}}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($catalog->updated_at)}}</td>
                                        <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.catalogs.edit',$catalog->slug)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.catalogs.destroy',$catalog->slug)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>

                                        <form action="{{route('CatalogSent',$catalog->id)}}" method="post" style="margin-top: 20px;">
                                            @csrf
                                            <input hidden>
                                            <button type="submit" class="btn bg-maroon" onclick="return confirm('آیا اطمینان دارید کاتالوگ به کاربران ارسال شود؟');">ارسال به کاربران</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$catalogs->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
