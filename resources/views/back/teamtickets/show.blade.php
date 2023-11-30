@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">تیکت: {{$teamticket->title}} </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                    <div class="box-body">
                        <section class="invoice">
                            <!-- title row -->

                            <!-- info row -->
                            <div class="box-body no-padding">
                                <div class="mailbox-read-info" style="background: #e0e0e0;">
                                    <h5>نام و نام خانوادگی:{{$teamticket->user->lastname}}</h5><br>
                                    <h5>نام کاربری :{{$teamticket->user->name}} <br><br>ایمیل : {{$teamticket->user->email}} <br>
                                    <span class="mailbox-read-time pull-left">{{\Hekmatinasser\Verta\Verta::instance($teamticket->created_at)}}</span></h5>
                                </div>
                                <div class="mailbox-read-info">
                                    <h3>شناسه تیکت : {{$teamticket->ticket_id}}</h3><br>
                                    <h5>عنوان :{{$teamticket->title}}<br><br>دسته بندی پشتیبان : {{$teamticket->catorder->title}} </h5>
                                </div>
                                <div class="mailbox-read-message">
                                    <p>
                                        {!! $teamticket->message !!}
                                    </p>
                                </div>
                                <!-- /.mailbox-read-message -->
                            </div>


                            <!-- /.row -->
                            <br><br><br>

                            @if($ticketreplies)
                                @foreach($ticketreplies as $ticketreply)
                                <div class="box-body no-padding">
                                    <div class="mailbox-read-info" style="background: #e0e0e0; color: #f39c12;">
                                        <h5 style="display: inline-block">پاسخ داده شده توسط: {{$ticketreply->user->lastname}}</h5><br>
                                        <a style="display: inline-block" class=" label pull-center bg-red" href="{{route('back.ticketreplys.destroy',$ticketreply->id)}}" onclick="return confirm('تیکت مورد نظر حذف شود؟');">حذف</a>
                                            <span class="mailbox-read-time pull-left">{{\Hekmatinasser\Verta\Verta::instance($ticketreply->created_at)}}</span></h5>
                                    </div>
                                    <div class="mailbox-read-info">
                                        <h6>شناسه تیکت : {{$ticketreply->ticket_id}}</h6>
                                        <h6>عنوان :{{$ticketreply->title}}<br><br>  </h6>
                                    </div>
                                    <div class="mailbox-read-message">
                                        <p>
                                            {!! $ticketreply->message !!}
                                        </p>
                                    </div>
                                    <!-- /.mailbox-read-message -->
                                </div>
                                    <br>
                                @endforeach
                            @endif
                        </section>
                        <section class="invoice">
                            <form method="post" action="{{route('back.teammateticket.reply',$teamticket->id)}}">
                                @csrf
                                <input name="title" hidden class="form-control hidden" value="{{$teamticket->title}}">
                                <input name="user_id" hidden class="form-control hidden" value="{{$user->lastname}}">
                                <input name="ticket_id" hidden class="form-control hidden" value="{{$teamticket->ticket_id}}">
                                <input name="catorder_id" hidden class="form-control hidden" value="{{$teamticket->catorder_id}}">
                                <input name="priority" hidden class="form-control hidden" value="{{$teamticket->priority}}">
                                <textarea  name="message" hidden  class="form-control hidden" rows="3" >{{$teamticket->message}}</textarea>

                                <textarea id="editor" name="message"  class="form-control" rows="5" >{{old('message')}}</textarea>
                                <br>
                                <button class="btn btn-sm btn-secondary" type="submit">ارسال پاسخ</button>
                            </form>
                        </section>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <a href="{{route('back.teamtickets')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
            </div>
        </div>
    </div>
@endsection
