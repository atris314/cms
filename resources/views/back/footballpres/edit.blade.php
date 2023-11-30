@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش بازی: </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.footballs.update',$football->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">نام تیم رقیب: </label>
                            <input type="text" class="form-control @error('teamname') is-invalid @enderror" id="exampleInputEmail1" name="teamname" value="{{$football->teamname}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">ساعت شروع بازی: </label>
                            <input type="text" class="form-control @error('time') is-invalid @enderror" id="exampleInputEmail1" name="time" value="{{$football->time}}">
                        </div>
                        <div class="form-group">
                            <label for="statictitle" class="col-form-label gray-text-color">تاریخ شروع بازی: </label>
                            <div class="input-group">
                                <input id="inputDate3" type="text" name="date" value="{{$football->date}}"
                                       aria-label="date3"
                                       aria-describedby="date3"
                                       placeholder="تاریخ شروع بازی را تعیین کنید" class="date form-control gray-text-color @error('date') is-invalid @enderror">
                                <span class="input-group-addon" id="date3" style="cursor: pointer">
                                     انتخاب
                                    </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">وضعيت بازی:</label>
                            <select class="form-control" name="status" >
                                <option value="0">فعال </option>
                                <option value="1">غیر فعال </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">نتیجه بازی: </label>
                            <input type="text" class="form-control @error('gameresult') is-invalid @enderror" id="exampleInputEmail1" name="gameresult" value="{{$football->gameresult}}">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.footballs')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
