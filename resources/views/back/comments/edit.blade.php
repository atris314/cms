@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش كامنت: {!! mb_substr($comment->description,0,30).'..'!!}</h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.comments.update',$comment->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">متن كامنت: </label>
                            <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="exampleInputEmail1"name="description">{{$comment->description}} </textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">ايميل:</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" value="{{$comment->email}}" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">وضعيت:</label>
                            <select class="form-control" name="status" >
                                <option value="0">غير فعال</option>
                                <option value="1"  <?php if($comment->status==1) echo 'selected' ; ?>>فعال</option>
                            </select>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.comments')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
