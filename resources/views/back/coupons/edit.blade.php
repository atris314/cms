@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش کد تخفیف: {{$coupon->name}} </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.coupons.update',$coupon->id)}}" method="post">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">عنوان: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$coupon->title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">کدتخفیف:</label>
                            <input type="text" class="form-control @error('code') is-invalid @enderror" id="exampleInputEmail1" name="code" value="{{$coupon->code}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">درصد تخفیف:(فقط عدد درصد را وارد کنید)</label>
                            <input type="text" class="form-control @error('price') is-invalid @enderror" id="exampleInputEmail1" name="price" value="{{$coupon->price}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">وضعيت:</label>
                            <select class="form-control" name="status" >
                                <option value="0"> منقضی شده</option>
                                <option value="1"  <?php if($coupon->status==1) echo 'selected' ; ?>>منقضی نشده </option>
                            </select>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.coupons')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

