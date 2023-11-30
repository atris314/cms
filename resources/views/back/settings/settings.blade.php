@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
           تنظیمات

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="{{route('back.settings')}}">تنظیمات</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست تنظیمات سایت</h3>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('back.settings.create')}}" type="button" class="btn btn-block btn-default btn-lg">ایجاد<i class="fa fa-plus-square"></i></a>
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
                                    لوگو
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    آدرس
                                </th>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                                    تلفن
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="مرورگر: activate to sort column ascending">
                                    ایمیل
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  کپی رایت
                                </th>

                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  شبکه های اجتماعی
                                </th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="سیستم عامل: activate to sort column ascending">
                                  مديريت
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($settings as $setting)
                                <tr role="row" class="odd">
                                    @if($setting->photo_id)
                                        <td><img src="{{$setting->photo->path}}" style="border-radius: 50%; width:50px;     height: 50px;" ></td>
                                    @else
                                        <td><img src="{{url('back/dist/img/avatar-default.png')}}" style="border-radius: 50%; width:50px;     height: 50px;"></td>
                                    @endif
                                    <td class="sorting_1">{!! mb_substr($setting->address,0,10).'..'!!}</td>
                                    <td>{{$setting->phone}}</td>
                                    <td>{{$setting->email}}</td>
                                    <td>{{$setting->copyright}}</td>
                                    <td class="text-center">
                                        <span style=" width: 100px;" class=" btn btn-sm btn-default" > {{$setting->instagram}} </span><br>
                                        <span style=" width: 100px;"  class=" btn btn-sm btn-default" >  {{$setting->twitter}}</span><br>
                                        <span style=" width: 100px;"  class=" btn btn-sm btn-default" > {{$setting->skype}}</span><br>
                                        <span style=" width: 100px;"  class=" btn btn-sm btn-default" >  {{$setting->telegram}}</span><br>
                                        <span style=" width: 100px;"  class=" btn btn-sm btn-default" >  {{$setting->whatsapp}}</span><br>
                                        <span style=" width: 100px;"  class=" btn btn-sm btn-default" >  {{$setting->facebook}}</span><br>
                                        <span style=" width: 100px;"  class=" btn btn-sm btn-default" >  {{$setting->linkedin}}</span><br>

                                    </td>

                                    <td>
                                        <a class=" label pull-center bg-aqua" href="{{route('back.settings.edit',$setting->id)}}">ويرايش</a>
                                        <a class=" label pull-center bg-red" href="{{route('back.settings.destroy',$setting->id)}}" onclick="return confirm('آیتم مورد نظر حذف شود؟');">حذف</a>
                                    </td>
                                </tr>
                            @endforeach
                           </tbody>

                        </table>
                    </div>
                </div>
                {{$settings->links()}}
        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
