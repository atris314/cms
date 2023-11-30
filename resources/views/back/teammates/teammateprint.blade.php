<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> پرینت درخواست همکاری کاربر |  {{$teammate->user->lastname}}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('back/dist/css/bootstrap-theme.css')}}">
  <!-- Bootstrap rtl -->
  <link rel="stylesheet" href="{{asset('back/dist/css/rtl.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('back/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('back/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('back/dist/css/AdminLTE.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i>نام کاربر درخواست دهنده :{{$teammate->user->lastname}}
          <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($teammate->created_at)}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-lg-8 table-bordered table-responsive">
        <table class="table table-striped" >
          <tehead><h4> اطلاعات کاربر :</h4></tehead>
          <tr>
            <td>نام و نام خانوادگی :</td>
            <td>{{$teammate->user->lastname}}</td>
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
      <div class="col-lg-8 table-bordered table-responsive pt-5">
        <table class="table table-striped" >
          <tehead><h4> اطلاعات شغلی و تحصیلی :</h4></tehead>
          <tr>
            <td>شناسه کاربر :</td>
            <td>#{{$teammate->id}}</td>
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
            @if($teammate->lasteducaion == 0)
              <td>دیپلم </td>
            @elseif($teammate->lasteducaion == 1)
              <td>کاردانی </td>
            @elseif($teammate->lasteducaion == 2)
              <td>کارشناسی </td>
            @elseif($teammate->lasteducaion == 3)
              <td>کارشناسی - ارشد </td>
            @elseif($teammate->lasteducaion == 4)
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
              <td> <button class="btn btn-light" >تایید نشده </button></td>
            @elseif($teammate['status']==1)
              <td> <button class="btn btn-success" >تایید شده </button></td>
            @elseif($teammate['status']==2)
              <td> <a  class="label pull-center bg-black">مسدود شده </a></td>
            @elseif($teammate['status']==3)
              <td> <a  class=" label pull-center bg-maroon">تایید و تکمیل شده  </a></td>
            @endif
          </tr>

          <tr>
            <td> توضیحات:</td>
            <td style="width:560px; text-align: justify;" >{{$teammate->description}}</td>
          </tr>
        </table>
      </div>
    </div>
    <!-- /.row -->

    <!-- Table row -->

    <div class="row">
      <div class="col-xs-12 table-responsive">
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
