@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش كامنت: {!! mb_substr($contact->body,0,30).'..'!!}</h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.contacts.update',$contact->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">متن تماس: </label>
                            <textarea type="text" class="form-control @error('body') is-invalid @enderror" id="exampleInputEmail1" name="body">{{$contact->body}} </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">ايميل:</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" value="{{$contact->email}}" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">وضعيت:</label>
                            <select class="form-control" name="status" >
                                <option value="0">غير فعال</option>
                                <option value="1"  <?php if($contact->status==1) echo 'selected' ; ?>>فعال</option>
                            </select>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.contacts')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
