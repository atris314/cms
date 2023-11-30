@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">نمایش درخواست تبلیغات: {{$adsform->name}} </h3>
                </div>

                <div class="col-lg-12 table-bordered table-responsive">
                    <tehead><h4> اطلاعات درخواست کننده :</h4></tehead><table class="table table-striped">

                        <tbody><tr>
                            <td>نام و نام  خانوادگی :</td>
                            <td>{{$adsform->name}}</td>
                        </tr>
                        <tr>
                            <td>تلفن تماس :</td>
                            <td>{{$adsform->phone}}</td>
                        </tr>
                        <tr>
                            <td>آدرس ایمیل :</td>
                            <td>{{$adsform->email}}</td>
                        </tr>
                        <tr>
                            <td>موضوع:</td>
                            <td>{{$adsform->subject}}</td>
                        </tr>
                        <tr>
                            <td>توضیحات:</td>
                            <td>{{$adsform->description}}</td>
                        </tr>
                        </tbody></table>
                </div>

            </div>
            <div class="box-footer">
                <a href="{{route('back.adsforms')}}" class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
            </div>
        </div>
    </div>
@endsection
