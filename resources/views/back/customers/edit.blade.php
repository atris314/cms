@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @if($customer->photo_id)
                <td><img src="{{$customer->photo->path}}" class="img-fluid" style="border-radius: 50%; width:250px;     height: 250px;" ></td>
            @else
                <td><img src="{{url('back/dist/img/avatar-default.png')}}" class="img-fluid" style="border-radius: 50%; width:250px;     height: 250px;"></td>
            @endif
        </div>
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش : </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.customers.update',$customer->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">نام: </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="exampleInputEmail1" name="name" value="{{$customer->name}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">سمت شغلی: </label>
                            <input type="text" class="form-control @error('job') is-invalid @enderror" id="exampleInputEmail1" name="job" value="{{$customer->job}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">متن پیغام: </label>
                            <textarea id="full-featured" type="text" class="form-control @error('comment') is-invalid @enderror" name="comment" >{{$customer->comment}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">تصویر شاخص</label>
                            <input type="file" name="photo_id" id="exampleInputFile">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.customers')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
