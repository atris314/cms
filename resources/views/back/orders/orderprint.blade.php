<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> پرینت سفارش |  {{$payment->title}}</title>
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
          <i class="fa fa-globe"></i>شرکت/سازمان/ارگان :{{$payment->user->companyname}}
          <small class="pull-left">{{\Hekmatinasser\Verta\Verta::instance($payment->product->created_at)}}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-lg-12 table-bordered table-responsive">
        <table class="table table-striped" >
          <tr>
            <td>شماره فاکتور :</td>
            <td>{{$payment->order_id}}</td>
          </tr>
          <tr>
            <td>مبلغ پرداخت : </td>
            <td>{{$payment->amount}} ریال </td>
          </tr>
          <tr>
            <td>عنوان پرداخت :</td>
            <td>{{$payment->order->desc}}</td>
          </tr>
        </table>
      </div>
      <div class="col-lg-12 table-bordered table-responsive">
        <table class="table table-striped" >
          <tr>
            <td>نام شرکت :</td>
            <td>{{$payment->user->companyname}}</td>
          </tr>
          <tr>
            <td>به آدرس : </td>
            <td>{{$payment->user->address}}</td>
          </tr>
          <tr>
            <td>تلفن تماس :</td>
            <td>{{$payment->user->phone}}</td>
          </tr>
          <tr>
            <td>تلفن همراه :</td>
            <td>{{$payment->user->mobile}}</td>
          </tr>
          <tr>
            <td>ایمیل :</td>
            <td>{{$payment->user->email}}</td>
          </tr>
          <tr>
            <td>کدپستی :</td>
            <td>{{$payment->user->postcode}}</td>
          </tr>
        </table>
      </div>
      <div class="col-lg-12 table-bordered table-responsive pt-5">
        <table class="table table-striped" >
          <tehead><h4>
              اطلاعات سفارش :
              @if($payment->product['status']==0)
                <a  class="btn btn-light" >ثبت شده</a>
              @elseif($payment->product['status']==1)
                <a  class="btn btn-dark" >کوپن تخفیف خود را استفاده کرده</a>
              @elseif($payment->product['status']==2)
                <a  class="btn btn-success" >پرداخت منبع یابی</a>
              @elseif($payment->product['status']==3)
                <a class="btn btn-info" >سفارش حاضر شده در انتظار پرداخت</a>
              @elseif($payment->product['status']==4)
                <a  class="btn btn-info" >پرداخت نهایی انجام شد</a>
              @elseif($payment->product['status']==5)
                <a  class="label pull-center bg-teal" >در دست اقدام</a>
              @elseif($payment->product['status']==6)
                <a  class="label pull-center bg-blue-active" >درخواست مجدد</a>
              @elseif($payment->product['status']==7)
                <a  class="label pull-center bg-fuchsia" >ترجمه شده</a>
              @elseif($payment->product->status==8)
                <a  class="label pull-center bg-yellow-gradient" >هزینه خرید کالا پرداخت شد</a>
              @elseif($payment->product->status==9)
                <a  class="label pull-center bg-green-gradient" >هزینه ترخیص کالا پرداخت شد</a>
              @elseif($payment->product->status==10)
                <a  class="label pull-center bg-blue-gradient" >هزینه ترخیص کالا تعیین شد</a>
              @elseif($payment->product->status==11)
                <a  class="label pull-center bg-olive" >اطلاعات سفارش تکمیل شد</a>
              @elseif($payment->product->status==12)
                <a  class="label pull-center bg-olive" >در انتظار تکمیل اطلاعات سفارش</a>
              @elseif($payment->product->status==13)
                <a  class="label pull-center bg-olive" >کاربر انصراف داد</a>
              @elseif($payment->product->status==14)
                <a  class="label pull-center bg-blue-gradient" >سفارش حاضر است</a>
              @elseif($payment->product->status==15)
                <a  class="label pull-center bg-orange" >حذف شده توسط کاربر(لغو)</a>
              @elseif($payment->product->status==16)
                <a  class="label pull-center bg-green-gradient" >تایید الکترونیکی انجام شد</a>
              @endif
            </h4></tehead>
          <tr>
            <td>شناسه سفارش :</td>
            <td>{{$payment->product->codepro}}</td>
          </tr>
          <tr>
            <td>تعداد سفارش :</td>
            <td>{{$payment->product->number}}</td>
          </tr>
          <tr>
            <td>عنوان سفارش :</td>
            <td>{{$payment->product->title}}</td>
          </tr>
          <tr>
            <td>دسته بندی سفارش  : </td>
            <td>{{$payment->product->catorder->title}}</td>
          </tr>
          <tr>
            <td>نوع منبع یابی  :</td>
            <td>{{$payment->product->pack->title}}</td>
          </tr>
          <tr>
            <td>تاریخ ثبت سفارش :</td>
            <td>{{\Hekmatinasser\Verta\Verta::instance($payment->product->created_at)}}</td>
          </tr>
          <tr>
            <td> مبلغ کل :</td>
            <td>{{$payment->product->amount}} تومان</td>
          </tr>
          <tr>
            <td>مبلغ تخفیف :</td>
            <td>{{$payment->product->discountamount}} تومان</td>
          </tr>
          <tr>
            <td>قابل پرداخت:</td>
            <td>{{$payment->product->totalamount}} تومان</td>
          </tr>
          <tr>
            <td>شرح سفارش:</td>
            <td style="width:560px; text-align: justify;" >{!! $payment->product->description !!}</td>
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
