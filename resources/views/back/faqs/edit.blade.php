@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش پرسش و پاسخ </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.faqs.update',$faq->id)}}" method="post">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">پرسش: </label>
                            <textarea type="text" class="form-control @error('question') is-invalid @enderror" name="question" >{{$faq->question}}</textarea>
                        </div>
                        <div class="form-group">
                            <lable for="exampleInputEmail1"> پاسخ:</lable>
                            <textarea type="text" class="form-control @error('answer') is-invalid @enderror" name="answer" >{{$faq->answer}}</textarea>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.faqs')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

