@extends('back.index')
@section('content')
    <section class="content-header">
        <h1>
          اعلان ها

        </h1>
        <ol class="breadcrumb">
            <li><a href="{{route('admin')}}"><i class="fa fa-dashboard"></i> خانه</a></li>
            <li><a href="#">اعلان ها</a></li>

        </ol>
    </section>
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="box-header">
                            <h3 class="box-title">لیست اعلان ها</h3>
                        </div>
                    </div>

                </div>
                <hr>

        <!-- /.box-header -->
        <div class="box-body">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">اعلانات</h3>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="mailbox-controls">

                            <!-- /.pull-right -->
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped">
                                <tbody>
                                @forelse($notifications as $notification)
                                <tr>
                                    <td>
                                        <div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                                            <input type="checkbox" style="position: absolute; opacity: 0;">
                                            <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;">
                                            </ins>
                                        </div>
                                    </td>
                                    <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                    <td class="mailbox-name">
                                            @if($notification->type == 'App\Notifications\ProductAdd')
                                                سفارش جدید
                                                @elseif($notification->type == 'App\Notifications\CommentAdd')
                                                کامنت جدید
                                                @elseif($notification->type == 'App\Notifications\ProductPurchaseAdd')
                                                تراکنش جدید/پرداخت اولیه
                                                @elseif($notification->type == 'App\Notifications\PresentPurchaseAdd')
                                                تراکنش جدید/پرداخت نهایی
                                                @elseif($notification->type == 'App\Notifications\TeamRequest')
                                                درخواست همکاری
                                                @elseif($notification->type == 'App\Notifications\TicketUserAdd')
                                                تیکت کاربری
                                                @elseif($notification->type == 'App\Notifications\TicketTeamAdd')
                                                تیکت کارشناس دورکار
                                                @elseif($notification->type == 'App\Notifications\DescriptionAdd')
                                                توضیحات سفارش ناقص
                                                @elseif($notification->type == 'App\Notifications\ProTranslateAdd')
                                                ترجمه سفارش
                                                @elseif($notification->type == 'App\Notifications\ResidSent')
                                                رسید پرداخت منبع یابی
                                            @endif
                                    </td>
                                    <td class="mailbox-subject">
                                        @if($notification->type == 'App\Notifications\ProductAdd')
                                        <a href="{{route('back.productstore')}}" target="_blank"> سفارش {{$notification->data['title']}} توسط کاربر ثبت شده است.</a>
                                        @elseif($notification->type == 'App\Notifications\CommentAdd')
                                        <a href="{{route('back.comments')}}" target="_blank">کامنت جدید توسط کاربر ثبت شده است.</a>
                                        @elseif($notification->type == 'App\Notifications\ProductPurchaseAdd')
                                        <a href="{{route('back.productpurchases')}}" target="_blank">پرداخت اولیه ثبت شد.</a>
                                        @elseif($notification->type == 'App\Notifications\PresentPurchaseAdd')
                                        <a href="{{route('back.presentpurchases')}}" target="_blank">پرداخت نهایی ثبت شد.</a>
                                        @elseif($notification->type == 'App\Notifications\TeamRequest')
                                        <a href="{{route('back.teammates')}}" target="_blank">درخواست همکاری جدید ثبت شد.</a>
                                        @elseif($notification->type == 'App\Notifications\TicketUserAdd')
                                        <a href="{{route('back.tickets')}}" target="_blank">کاربر تیکت جدید ثبت کرد.</a>
                                        @elseif($notification->type == 'App\Notifications\TicketTeamAdd')
                                        <a href="{{route('back.teamtickets')}}" target="_blank"> تیکت جدید از کارشناس دورکار دریافت شد.</a>
                                        @elseif($notification->type == 'App\Notifications\ProTranslateAdd')
                                        <a href="{{route('back.protranslates')}}" target="_blank">ترجمه سفارش جدید توسط کارشناس دورکار ثبت شد.</a>
                                        @elseif($notification->type == 'App\Notifications\ResidSent')
                                        <a href="{{route('back.resids')}}" target="_blank">رسید پرداخت هزینه منبع یابی آپلود شد.</a>
                                        @endif
                                    </td>
                                    <td class="mailbox-attachment">@if($notification->read_at) خوانده شده@endif</td>
                                    <td class="mailbox-date">{{$notification->created_at}}</td>
                                </tr>
                                @empty
                                    <td> اعلان جدید ندارید</td>
                                @endforelse
                                </tbody>
                            </table>

                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer no-padding">

                </div>
                <!-- /. box -->
            </div>

        </div>
        <!-- /.box-body -->
    </div>
        </div>
    </div>
@endsection
