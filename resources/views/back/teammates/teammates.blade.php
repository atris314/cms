@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
          درخواست همکاری های ارسال شده

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="{{route('back.teammates')}}">درخواست همکاری ها</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست درخواست ها و رزومه های ارسالی</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('back.teammates.create')}}" type="button" class="btn btn-block btn-default btn-lg">اضافه کردن همکار جدید<i class="fa fa-plus-square"></i></a>
                    </div>
                </div>
        <!-- /.box-header -->
        <div class="box-body">
            @include('back.massages')
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12">
                        <table id="example2" class="table table-bordered table-responsive  table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    نام و نام خانوادگی
                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                   فایل رزومه
                                </th>
                                <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    تاریخ تولد
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                   محدوده سکونت
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                   رشته تحصیلی
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    دسته بندی نوع همکاری
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    گروه بندی پشتیبانی
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  وضعیت
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    تاریخ ارسال
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                    تاریخ بروزرسانی
                                </th>
                                <th class="sorting text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  مديريت
                                </th>
                            </tr>
                            </thead>
                            <tbody class="table-responsive">
                            @foreach($teammates as $teammate)
                                <tr role="row" class="odd">
                                    <td class="text-center">
                                        @if(empty($teammate->user->lastname))
                                            ---
                                        @else
                                        {{$teammate->user->lastname}}
                                        @endif
                                    </td>
                                    @if($teammate->photo_id)
                                        <td class="text-center"><a href="{{$teammate->photo['path']}}" >دانلود رزومه</a></td>
                                        @else
                                        <td>رزومه ارسال نشده</td>
                                        @endif

                                    <td class="text-center">{{$teammate->borndate}}</td>
                                    <td class="text-center">{{$teammate->residence}}</td>
                                    <td class="text-center"> {{$teammate->major}}</td>
                                    <td class="text-center">
                                        @foreach(@$teammate->catwork()->pluck('title') as $catwork)
                                            <span  class="  btn btn-sm btn-default" >{{$catwork}}</span><br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @foreach(@$teammate->groups->pluck('title') as $group)
                                            <span  class="  btn btn-sm btn-default" >{{$group}}</span><br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                       @if($teammate['status']==0)
                                            <a  class=" label pull-center bg-yellow">تایید نشده  </a>
                                        @elseif($teammate['status']==1)
                                            <a  class="label pull-center bg-green">تایید شده </a>
                                        @elseif($teammate['status']==2)
                                            <a  class="label pull-center bg-black">مسدود شده </a>
                                        @elseif($teammate['status']==3)
                                            <a  class=" label pull-center bg-maroon">تایید و تکمیل شده  </a>
                                        @endif

                                    </td>
                                        <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($teammate->created_at)}}</td>
                                        <td class="text-center" style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($teammate->updated_at)}}</td>
                                        <td class="text-center">
                                        <a class=" label pull-center bg-aqua" href="{{route('back.teammates.show',$teammate->id)}}">نمایش</a>
                                        <a class=" label pull-center bg-green" href="{{route('back.teammates.edit',$teammate->id)}}">ویرایش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.teammates.destroy',$teammate->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$teammates->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
