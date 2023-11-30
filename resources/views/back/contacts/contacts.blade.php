@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
            تماس كاربران

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">تماس كاربران</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست تماس های كاربران</h3>
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
                                    خلاصه پیام
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                   نام
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    ایمیل
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    شماره تماس
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  تاريخ ثبت
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
                            @foreach($contacts as $contact)
                                <tr role="row" class="odd">
                                    <td class="sorting_1"><a href="{{route('back.contacts.edit',$contact->id)}}">{!! mb_substr($contact->body,0,30).'..'!!} </a></td>
                                    <td>{{$contact->name}}</td>
                                    <td>{{$contact->email}}</td>
                                    <td>{{$contact->mobile}}</td>
                                    <td>{{\Hekmatinasser\Verta\Verta::instance($contact->created_at)}}</td>
                                    <td>
                                        <?php
                                        $url = route('back.contacts.status',$contact->id);
                                        if ($contact['status']==1){
                                            echo '<a href="'.$url.'" class="label pull-center bg-green">تاييد </a>';
                                        }
                                        else{
                                            echo '<a href="'.$url.'" class=" label pull-center bg-yellow">تاييد نشده </a>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.contacts.edit',$contact->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.contacts.destroy',$contact->id)}}" onclick="return confirm('تماس كاربر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$contacts->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
