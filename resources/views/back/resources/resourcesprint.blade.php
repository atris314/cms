<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> پرینت درخواست همکاری به عنوان منبع |  {{$addsource->lastname}}</title>
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
          <i class="fa fa-globe"></i>نام خانوادگی درخواست دهنده :{{$addsource->lastname}}
          <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($addsource->created_at)}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-lg-8 table-bordered table-responsive">
        <table class="table table-striped" >
          <tehead><h4 style="background: #da5a6b;color: white;padding: 15px;"><b>اطلاعات درخواست دهنده همکاری به عنوان منبع :</b>  </h4></tehead>
          <tr>
            <td>نام و نام خانوادگی :</td>
            <td>{{$addsource->name}}-{{$addsource->lastname}}</td>
          </tr>
          <tr>
            <td>شماره موبایل :</td>
            <td>{{$addsource->mobile}}</td>
          </tr>
          <tr>
            <td>آدرس ایمیل :</td>
            <td>{{$addsource->email}}</td>
          </tr>

          <tr>
            <td> استان/شهر : </td>
            <td>{{$addsource->province->name}}/{{$addsource->city->name}}</td>
          </tr>
          <tr>
            <td>نام شرکت/نام برند :</td>
            <td>{{$addsource->brandname}}</td>

          </tr>
          <tr>
            <td>سمت کاری :</td>
            <td>{{$addsource->job}}</td>
          </tr>
          <tr>
            <td>آدرس وب سایت :</td>
            <td>{{$addsource->website}}</td>
          </tr>
          <tr>
            <td>آدرس و مشخصات دقیق محل کار و متراژ :</td>
            <td>{{$addsource->address}}</td>
          </tr>
          <tr>
            <td>زمینه کاری :</td>
            <td>{{$addsource->catorder->title}}</td>
          </tr>
          <tr>
            <td>مدت زمان فعالیت در این حوزه :</td>
            <td>{{$addsource->activitytime}}</td>
          </tr>
          <tr>
            <td>در چه زمینه ای و به چه صورت قصد همکاری با یابانه را دارید لطفا توضیح دهید :</td>
            <td>{!! $addsource->description !!}</td>
          </tr>
          <tr>
            <td>تاریخ ارسال :</td>
            <td>{{\Hekmatinasser\Verta\Verta::instance($addsource->created_at)}}</td>
          </tr>
        </table>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
