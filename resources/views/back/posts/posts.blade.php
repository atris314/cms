@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
           مطالب/پست ها

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">مطالب</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست مطالب</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('back.posts.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
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
                                    نویسنده
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  توضیحات|محتوا
                                </th>

                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                   دسته بندی
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                   وضعیت مطلب
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
                            @foreach($posts as $post)
                                <tr role="row" class="odd">
                                    @if(isset($post->photo_id))
                                        <td class="text-center"><img src="{{$post->photo['path']}}" style="border-radius: 10px; width:50px;     height: 50px;" ></td>
                                    @else
                                        <td class="text-center"><img src="{{url('back/dist/img/placeholder.jpg')}}" style="border-radius: 10px; width:50px;     height: 50px;"></td>
                                    @endif
                                    <td class="sorting_1"><a href="{{route('back.posts.edit',$post->id)}}">{!! mb_substr($post->title,0,10).'..'!!} </a></td>
                                        @if($post->user_id)
                                            <td>{{$post->user['name']}}</td>
                                        @else
                                            <td> کاربری که این مطلب را نوشته حذف شده</td>
                                        @endif
{{--                                    <td>{{!empty($post->user_id) ? $post->user->name:''}}</td>--}}

                                    <td>{!! mb_substr($post->description,0,80).'..'!!}</td>
                                    <td class="text-center">
                                        @foreach(@$post->categories()->pluck('title') as $category)
                                            <span style="font-family: 'p30'; width: 100px;" class="  btn btn-sm btn-default" >{{$category}}</span><br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $url = route('back.posts.status',$post->id);
                                        if ($post['status']==0){
                                            echo '<a href="'.$url.'" class="label pull-center bg-green">منتشر شده </a>';
                                        }
                                        else{
                                            echo '<a href="'.$url.'" class=" label pull-center bg-yellow">منتشر نشده  </a>';
                                        }
                                        ?>
                                    </td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($post->created_at)}}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($post->updated_at)}}</td>
                                        <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.posts.edit',$post->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.posts.destroy',$post->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$posts->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
