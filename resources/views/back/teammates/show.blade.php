@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-8 offset-2 justify-content-md-center">
            <div class="box box-success col-md-12  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">درخواست همکاری: {{$teammate->user->lastname}} </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                    <div class="box-body">
                        <section class="invoice">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-xs-12">
                                    <h2 class="page-header">
                                        <tr>
                                            @if($teammate->user->photo_id)
                                                <td><img src="{{$teammate->user->photo->path}}" style="height: 150px; width: 150px;"></td>
                                            @else
                                                <td><i class="fa fa-globe"></i></td>
                                            @endif
                                        </tr>


                                        <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($teammate->created_at)}}  </small>
                                    </h2>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-lg-12 table-bordered table-responsive">
                                    <table class="table table-striped" >
                                        <tehead><h4><b>اطلاعات کاربر :</b>  </h4></tehead>
                                        <tr>
                                            <td>فایل رزومه کاربر:</td>
                                            @if($teammate->photo_id)
                                                <td><a href="{{$teammate->photo->path}}"> دانلود رزومه</a></td>
                                            @else
                                                <td>روزمه ارسال نشده</td>
                                            @endif
                                        </tr>
                                        <tr>

                                            <td>نام و نام خانوادگی :</td>
                                            @if($teammate->user->lastname)
                                            <td>{{$teammate->user->lastname}}</td>
                                                @else
                                            <td>وارد نشده</td>
                                                @endif
                                        </tr>
                                        <tr>
                                            <td>نام پدر :</td>
                                            <td>{{$teammate->fathername}}</td>
                                        </tr>
                                        <tr>
                                            <td>تاریخ تولد :</td>
                                            <td>{{\Hekmatinasser\Verta\Verta::instance($teammate->borndate)}}</td>
                                        </tr>
                                        <tr>
                                            <td>کد ملی :</td>
                                            <td>{{$teammate->codemeli}}</td>
                                        </tr>
                                        <tr>
                                            <td>وضعیت تاهل  : </td>
                                            @if($teammate->maritalstatus == 0)
                                                <td>مجرد </td>
                                            @elseif($teammate->maritalstatus == 1)
                                                <td>متاهل </td>
                                                @endif
                                        </tr>
                                        <tr>
                                            <td> آدرس : </td>
                                            @if($teammate->address)
                                                <td>{{$teammate->address}}</td>
                                                @else
                                                <td>{{$teammate->user->address}}</td>
                                                @endif
                                        </tr>
                                        <tr>
                                            <td>تلفن تماس :</td>
                                            @if($teammate->phone)
                                                <td>{{$teammate->phone}}</td>
                                                @else
                                                <td>{{$teammate->user->phone}}</td>
                                                @endif
                                        </tr>
                                        <tr>
                                            <td>تلفن همراه :</td>
                                            @if($teammate->mobile)
                                                <td>{{$teammate->mobile}}</td>
                                            @else
                                            <td>{{$teammate->user->mobile}}</td>
                                                @endif
                                        </tr>
                                        <tr>
                                            <td>ایمیل :</td>
                                            <td>{{$teammate->user->email}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-lg-12 table-bordered table-responsive pt-5">
                                    <table class="table table-striped" >
                                        <tehead><h4><b> اطلاعات شغلی و تحصیلی :</b></h4></tehead>
                                        <tr>
                                            <td>شناسه کاربر :</td>
                                            <td style="direction: ltr;text-align: right">{{$teammate->user->code}}</td>
                                        </tr>
                                        <tr>
                                            <td>رشته تحصیلی :</td>
                                            <td>{{$teammate->major}}</td>
                                        </tr>
                                        <tr>
                                            <td> میزان تحصیلات :</td>
                                            <td>{{$teammate->education}} </td>
                                        </tr>
                                        <tr>
                                            <td>آخرین مدرک تحصیلی  :</td>
                                            @if($teammate['lasteducation'] == 0)
                                            <td>دیپلم </td>
                                            @elseif($teammate['lasteducation'] == 1)
                                                <td>کاردانی </td>
                                            @elseif($teammate['lasteducation'] == 2)
                                                <td>کارشناسی </td>
                                            @elseif($teammate['lasteducation'] == 3)
                                                <td>کارشناسی - ارشد </td>
                                            @elseif($teammate['lasteducation'] == 4)
                                                <td>دکتری </td>
                                            @endif
                                        </tr>
                                        <tr>
                                            <td>سوابق کاری :</td>
                                            <td>{{$teammate->resume}} </td>
                                        </tr>
                                        <tr>
                                            <td>مهارت ها :</td>
                                            <td>{{$teammate->skill}} </td>
                                        </tr>
                                        <tr>
                                            <td>دسته بندی نوع همکاری  : </td>
                                            <td>{{$teammate->catwork->title}}</td>
                                        </tr>
{{--                                        <tr>--}}
{{--                                            <td>دسته بندی پشتیبانی  : </td>--}}
{{--                                            <td>{{$teammate->catorder->title}}</td>--}}
{{--                                        </tr>--}}
                                        <tr>
                                            <td>گروه همکاری: </td>
                                            <td>
                                            @foreach(@$teammate->groups->pluck('title') as $group)
                                                <span  class="  btn btn-sm btn-default" >{{$group}}</span><br>
                                            @endforeach
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>گروه منبع یابی: </td>
                                            <td>
                                            @foreach(@$teammate->packs->pluck('title') as $packs)
                                                <span  class="  btn btn-sm btn-default" >{{$packs}}</span><br>
                                            @endforeach
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>تاریخ ارسال :</td>
                                            <td>{{\Hekmatinasser\Verta\Verta::instance($teammate->created_at)}}</td>
                                        </tr>
                                        <tr>
                                            <td>وضعیت درخواست همکاری :</td>
                                            @if($teammate['status']==0)
                                              <td> <a  class=" label pull-center bg-yellow">تایید نشده  </a></td>
                                            @elseif($teammate['status']==1)
                                               <td> <a  class="label pull-center bg-green">تایید شده </a></td>
                                            @elseif($teammate['status']==2)
                                               <td> <a  class="label pull-center bg-black">مسدود شده </a></td>
                                            @elseif($teammate['status']==3)
                                               <td> <a  class=" label pull-center bg-maroon">تایید و تکمیل شده  </a></td>
                                            @endif
                                        </tr>

                                        <tr>
                                            <td> توضیحات:</td>
                                            <td style="width:560px; text-align: justify;" >{!! $teammate->description !!}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <br><br><br>
                            <!-- this row will not appear when printing -->
                            <div class="row no-print mt-5">
                                <div class="col-xs-12">
                                    <a href="{{route('back.teammateprint',$teammate->id)}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> پرینت</a>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{route('back.teammates')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
