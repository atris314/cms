<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> پرینت سفارش |  {{$protranslate->product->title}} | {{$protranslate->subject}}</title>
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
          <i class="fa fa-globe"></i>سفارش :{{$protranslate->product->title}} | {{$protranslate->subject}}
          <small class="pull-left">{{$protranslate->created_at}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-lg-12 table-bordered table-responsive pt-5">
        <table class="table table-striped" >
          <tehead><h4> اطلاعات سفارش :</h4></tehead>
          <b class="mr-5">تصاویر| images : </b> <br>
          @foreach($protranslate->product->photos as $photo)
            <img src="{{$photo->path}}" class="img-fluid" style="border-radius: 10px; width:100px;"  alt="{{$protranslate->product->title}}">
          @endforeach
          <br>
            <p style="display: inline-block"> شناسه سفارش دهنده :</p>
            @foreach(@$protranslate->product->user()->pluck('code') as $code)
              <p style="display: inline-block; text-align: right; direction: ltr">{{$code}}</p>
            @endforeach

          <tr>
            <td>کد سفارش :</td>
            <td>تعداد سفارش :</td>
            <td>عنوان سفارش :</td>
            <td>دسته بندی سفارش  : </td>
            <td>نوع منبع یابی  :</td>
            <td>تاریخ ثبت سفارش :</td>

          </tr>
          <tr>
            <td>{{$protranslate->product->codepro}}</td>
            <td>{{$protranslate->product->number}}</td>
            <td>{{$protranslate->product->title}}</td>
            <td>{{$protranslate->product->catorder->title}}</td>
            <td>{{$protranslate->product->pack->title}}</td>
            <td>{{\Hekmatinasser\Verta\Verta::instance($protranslate->product->created_at)}}</td>
          </tr>
        </table>
        <div class="row">
          <div class="col-lg-6" style="text-align: justify">
            <p>شرح سفارش:</p>
            <p>{!! $protranslate->product->description !!}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row invoice-info">
      <div class="col-lg-12 table-bordered table-responsive pt-5">
        <table class="table table-responsive" dir="ltr" >
          <tehead dir="ltr"><h4> order information :</h4></tehead>
          <tr>
            <td><b>Order Code :</b></td>
            <td><b>Order Title:</b></td>
            <td><b>Order Cetegory:</b></td>
            <td><b>created :</b></td>
          </tr>
          <tr>
            <td>{{$protranslate->product->codepro}}</td>
            <td>{{$protranslate->subject}}</td>
            <td>{{$protranslate->category}}</td>
            <td>{{$protranslate->product->created_at}}</td>
          </tr>
        </table>
        <div class="row">
          <div class="col-lg-6" style="text-align: justify; direction: ltr">
            <p>specification:</p>
            <p>{!! $protranslate->description !!}</p>
          </div>
        </div>
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
