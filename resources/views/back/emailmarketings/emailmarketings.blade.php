@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
         ایمیل مارکتینگ

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">ایمیل مارکتینگ</a></li>

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
                        <a href="{{route('back.emailmarketings.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
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
                                    موضوع
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    نام ارسال کننده ایمیل
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    آدرس ایمیل
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    عنوان
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    خلاصه متن ایمیل
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
                            @foreach($emailmarketings as $emailmarketing)
                                <tr role="row" class="odd">
                                    @if($emailmarketing->photo_id)
                                        <td><img src="{{$emailmarketing->photo->path}}" style="border-radius: 50%; width:50px;     height: 50px;" ></td>
                                    @else
                                        <td><img src="{{url('back/dist/img/placeholder.jpg')}}" style="border-radius: 50%; width:50px;     height: 50px;"></td>
                                    @endif
                                    <td>{{$emailmarketing->subject}}</td>
                                    <td>{{$emailmarketing->fromname}}</td>
                                        <td>{!! mb_substr($emailmarketing->emailaddress,0,100).'...'!!}</td>
                                    <td class="sorting_1"><a href="{{route('back.emailmarketings.edit',$emailmarketing->id)}}">{{$emailmarketing->title}}</a></td>
                                    <td>{!! mb_substr($emailmarketing->body,0,100).'...'!!}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($emailmarketing->created_at)}}</td>
                                        <td style="font-size:10px;">{{\Hekmatinasser\Verta\Verta::instance($emailmarketing->updated_at)}}</td>
                                        <td class="text-center">
                                            <form action="{{route('back.emailmarketings.sent',$emailmarketing->id)}}" method="post" style="margin: 10px;">
                                                @csrf
                                                <button type="submit" class="btn bg-maroon" onclick="return confirm('آیا اطمینان دارید که ایمیل تبلیغاتی به سمت کاربران ارسال شود؟');">ارسال به کاربران</button>
                                            </form>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.emailmarketings.edit',$emailmarketing->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.emailmarketings.destroy',$emailmarketing->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$emailmarketings->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
