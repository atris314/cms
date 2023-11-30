@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">ایجاد کد تخفیف</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.coupons.store')}}" method="post">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">عنوان کد تخفیف: </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1"name="title" value="{{old('title')}}" placeholder="عنوان">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">کد تخفیف:</label>
                        <input type="text" class="form-control @error('code') is-invalid @enderror" id="exampleInputEmail1"name="code" value="{{old('code')}}" placeholder="کد تخفیف ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">درصد تخفیف:(فقط عدد درصد را وارد کنید)</label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="exampleInputEmail1"name="price" value="{{old('price')}}" placeholder="مبلغ تخفیف ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">وضعيت:</label>
                        <select class="form-control" name="status" >
                            <option value="0">منقضی نشده </option>
                            <option value="1">منقضی شده</option>
                        </select>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.coupons')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection

