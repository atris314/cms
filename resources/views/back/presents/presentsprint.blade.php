<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> پرینت سفارش |  {{$present->product->title}}</title>
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
          <i class="fa fa-globe"></i>سفارش :{{$present->product->title}}
          <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($present->product->created_at)}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-lg-12 table-bordered table-responsive pt-5">

        <table class="table table-striped" >
          <tehead><h4> اطلاعات سفارش :</h4></tehead>
          <b>تصاویر| images : </b><br>
          @foreach($present->photos as $photo)
            <img src="{{$photo->path}}" class="img-fluid" style="border-radius: 10px; width:100px;"  alt="{{$present->title}}">
          @endforeach
          <br>
            <p style="display: inline-block"> شناسه سفارش دهنده :</p>
            @foreach(@$present->product->user()->pluck('code') as $code)
              <p style="display: inline-block; text-align: right; direction: ltr">{{$code}}</p>
            @endforeach

          <tr>
            <td>کد سفارش :</td>
            <td>عنوان سفارش :</td>
            <td>دسته بندی سفارش  : </td>
            <td>نوع منبع یابی  :</td>
            <td>تاریخ ثبت سفارش :</td>

          </tr>
          <tr>

            <td>{{$present->product->codepro}}</td>
            <td>{{$present->product->title}}</td>
            <td>{{$present->product->catorder->title}}</td>
            <td>{{$present->product->pack->title}}</td>
            <td>{{\Hekmatinasser\Verta\Verta::instance($present->product->created_at)}}</td>
          </tr>
        </table>
        <div class="row">
          <div class="col-lg-6" style="text-align: justify">
            <p>شرح سفارش:</p>
            <p>{!! $present->product->description !!}</p>
          </div>
        </div>
      </div>
    </div>
    <div class="row invoice-info">
      <div class="col-lg-12 table-bordered table-responsive pt-5">
        <table class="table table-responsive" >
          <tehead><h4> اطلاعات سفارش آماده شده :</h4></tehead>
          <tr>
            <td><b>کد سفارش:</b></td>
            <td><b>زمان تحویل سفارش:</b></td>
            <td><b>هزینه خرید کالا:</b></td>
            <td><b>هزینه ترخیص کالا:</b></td>
            <td><b>هزینه منبع یابی :</b></td>
            <td><b>مبلغ قابل پرداخت  :</b></td>
            <td><b>تاریخ ثبت سفارش آماده :</b></td>
            <td><b>تایید کاربر :</b></td>

          </tr>
          <tr>
            <td>{{$present->productcode}}</td>
            <td>{{$present->deliverytime}}</td>
            <td>{{$present->price}}</td>
            <td>@if(isset($present->releaseprice)) {{$present->releaseprice}} تومان  @else نامشخص @endif  </td>
            <td>{{$packprice}}</td>
            <td>بعد از اعمال محاسبات توسط کاربر مشخص می شود</td>
            <td>{{\Hekmatinasser\Verta\Verta::instance($present->created_at)}}</td>
            @if(isset($present->confirm))
              <td><b>کاربر، اطلاعات سفارش و منبع یابی را تایید کرد<i class="fa fa-check-square-o" style="color: #24c39e;font-size: 14pt;" aria-hidden="true"></i></b></td>
            @endif
          </tr>
        </table>
        <div class="row">
          <div class="col-lg-6" style="text-align: justify;">
            <p>توضیحات:</p>
            <p>{!! $present->description !!}</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6" style="text-align: justify;">
            <p>آخرین وضعیت سفارش:</p>
            @if($present['status'] == 0)
              <td style="width:560px; text-align: justify;" class="label pull-center bg-yellow-gradient mt-5"  >در انتظار پرداخت</td>
            @elseif($present['status']== 1)
              <td style="width:560px; text-align: justify;" class="label pull-center bg-green-gradient mt-5" >پرداخت شده</td>
            @elseif($present['status'] == 2 )
              <td style="width:560px; text-align: justify;" class="label pull-center bg-navy mt-5" >انصراف توسط کاربر</td>
            @elseif($present->status==3)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-blue-gradient mt-5" >در انتظار پرداخت هزینه ترخیص</td>
            @elseif($present->status==4)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-blue-gradient mt-5" >هزینه خرید کالا پرداخت شد</td>
            @elseif($present->status==5)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-blue-gradient mt-5" >هزینه ترخیص کالا پرداخت شد</td>
            @endif
          </div>
          <div class="col-lg-6" style="text-align: justify;">
            <p>آخرین وضعیت سفارش:</p>
            @if($present->product->status==0)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-maroon" >ثبت شد</td>
            @elseif($present->product->status==1)
              <td style="width:560px; text-align: justify;" class="label pull-center bg-navy" >کوپن تخفیف خود را استفاده کرد</td>
            @elseif($present->product->status==2)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-olive" >پرداخت منبع یابی</td>
            @elseif($present->product->status==3)
              <td style="width:560px; text-align: justify;" class="label pull-center bg-orange">سفارش حاضر شده در انتظار پرداخت</td>
            @elseif($present->product->status==4)
              <td style="width:560px; text-align: justify;" class="label pull-center bg-purple" >پرداخت نهایی انجام شد</td>
            @elseif($present->product->status==5)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-teal" >در دست اقدام</td>
            @elseif($present->product->status==6)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-blue-active" >درخواست مجدد</td>
            @elseif($present->product->status==7)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-fuchsia" >ترجمه شد</td>
            @elseif($present->product->status==8)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-yellow-gradient" >هزینه خرید کالا پرداخت شد</td>
            @elseif($present->product->status==9)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-green-gradient" >هزینه ترخیص کالا پرداخت شد</td>
            @elseif($present->product->status==10)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-blue-gradient" >هزینه ترخیص کالا تعیین شد</td>
            @elseif($present->product->status==11)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-olive" >اطلاعات سفارش تکمیل شد</td>
            @elseif($present->product->status==12)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-olive" >در انتظار تکمیل اطلاعات سفارش</td>
            @elseif($present->product->status==13)
              <td style="width:560px; text-align: justify;"  class="label pull-center bg-olive" >کاربر انصراف داد</td>
            @elseif($present->product->status==14)
              <td style="width:560px; text-align: justify;" class="label pull-center bg-blue-gradient" >سفارش حاضر است</td>
            @elseif($present->product->status==15)
              <td style="width:560px; text-align: justify;" class="label pull-center bg-orange" >حذف شده توسط کاربر(لغو)</td>
            @elseif($present->product->status==16)
              <td style="width:560px; text-align: justify;" class="label pull-center bg-green-gradient" >تایید الکترونیکی انجام شد</td>
            @endif
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
