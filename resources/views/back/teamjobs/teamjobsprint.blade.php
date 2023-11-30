<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> پرینت گزارش فعالیت کارشناس |  {{$teammate->user->name}} | {{$teammate->user->code}}</title>
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
          <i class="fa fa-globe"></i> پرینت گزارش فعالیت کارشناس :  {{$teammate->user->name}} | {{$teammate->user->code}}
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-lg-12 table-bordered table-responsive pt-5">
        <table class="table table-striped" >
          <tehead><h4> اطلاعات کارشناس :</h4></tehead>
          <tr>
            <td>کد کاربری:</td>
            <td>نام کاربری کارشناس :</td>
            <td>نام و نام خانوادگی :</td>
            <td> امتیاز: </td>
            <td>تعداد ترجمه ها :</td>
            <td>فعالیت :</td>

          </tr>
          <tr>
            <td>{{$teammate->user->code}}</td>
            <td>{{$teammate->user->name}}</td>
            <td>{{$teammate->user->lastname}}</td>
            <td>{{$teammate->rate}}</td>
            <td>{{$teammate->count}}</td>
            <td>{{$teammate->activity}}</td>
          </tr>
        </table>
      </div>
    </div>
    <div class="row invoice-info">
      <div class="col-lg-12 table-bordered table-responsive pt-5">
        <table class="table table-striped table-bordered" >
          @if($protranslate)
            <tr>
              <td>شناسه ترجمه شده ها :</td>
              <td>عنوان ترجمه شده ها :</td>
              <td>مدت زمان ترجمه :</td>
            </tr>
            @foreach($protranslate as $pro)
            <tr>
               <td class=" protraslate">{{$pro->product->codepro}}</td>
               <td class=" protraslate">{{$pro->product->title}}</td>
               <td class="protraslate">{{$pro->time}}</td>
            </tr>
            @endforeach
          @endif
        </table>
        {{$protranslate->links()}}
      </div>
    </div>
    <!-- /.row -->

    <!-- Table row -->

    <div class="row">
      <div class="col-xs-12 table-responsive">
      </div>
      <!-- /.col -->
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
