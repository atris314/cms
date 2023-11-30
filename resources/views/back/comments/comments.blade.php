@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
            نظرات كاربران

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">نظرات كاربران</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box">
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="box-header">
                                <h3 class="box-title">لیست نظرات كاربران</h3>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <a href="{{route('back.comments.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
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
                                   شناسه id
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    خلاصه نظر
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                   نام
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    ایمیل
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                 کامنتی که پاسخ دریافت کرده
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  براي پست
                                </th>

                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  تاريخ ثبت نظر
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                   وضعیت
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  مديريت
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr role="row" class="odd">
                                    <td>{{$comment->id}}</td>
                                    <td class="sorting_1"><a href="{{route('back.comments.edit',$comment->id)}}">{!! mb_substr($comment->description,0,100).'..'!!} </a></td>
                                    <td>{{$comment->name}}</td>
                                    <td>{{$comment->email}}</td>
                                    <td>
                                    @if($comment->subcomment)
                                        @foreach($comment->subcomment()->pluck('description') as $parent)
                                            {{$parent}}
                                        @endforeach
                                    @endif
                                    </td>
                                    @if($comment->post)
                                        <td>{{$comment->post->title}}</td>
                                    @endif

{{--                                    <td>{{\Hekmatinasser\Verta\Verta::instance($user->created_at)->formatDifference(\Hekmatinasser\Verta\Verta::today($user->created_at))}}</td>--}}
                                    <td>{{\Hekmatinasser\Verta\Verta::instance($comment->created_at)}}</td>
                                    <td>
                                        <?php
                                        $url = route('back.comments.status',$comment->id);
                                        if ($comment['status']==1){
                                            echo '<a href="'.$url.'" class="label pull-center bg-green">تاييد </a>';
                                        }
                                        else{
                                            echo '<a href="'.$url.'" class=" label pull-center bg-yellow">تاييد نشده </a>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.comments.edit',$comment->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.comments.destroy',$comment->id)}}" onclick="return confirm('كامنت كاربر مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$comments->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
