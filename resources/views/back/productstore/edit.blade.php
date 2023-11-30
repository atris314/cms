@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @if($product->photo_id)
                <td><img src="{{$product->photo->path}}" class="img-fluid" style="border-radius: 10px; width:350px;" ></td>
            @else
                <td><img src="{{url('back/dist/img/pattern.png')}}" class="img-fluid" style="border-radius: 10px; width:350px;"></td>
            @endif
        </div>
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش سفارش: {{$product->title}} </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.productstore.update',$product->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <h4>اطلاعات کاربر</h4>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> کد کاربری: </label>
                            <input type="text" class="text-right form-control @error('code') is-invalid @enderror" dir="ltr" id="exampleInputEmail1" name="code" value="{{$product->user->code}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">نام شرکت: </label>
                            <input type="text" class="form-control @error('companyname') is-invalid @enderror" id="exampleInputEmail1" name="companyname" value="{{$product->user->companyname}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">آدرس:</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="exampleInputEmail1" name="address" value="{{$product->user->address}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">شماره موبایل:</label>
                                <input type="text" class="form-control @error('mobile') is-invalid @enderror" id="exampleInputEmail1" name="mobile" value="{{$product->user->mobile}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">شماره تلفن :</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="exampleInputEmail1" name="phone" value="{{$product->user->phone}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> ایمیل: </label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="exampleInputEmail1" name="email" value="{{$product->user->email}}" readonly>

                        </div>
                        <h4>اطلاعات سفارش</h4>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> کد سفارش: </label>
                            <input type="text" class="form-control @error('codepro') is-invalid @enderror" id="exampleInputEmail1" name="codepro" value="{{$product->codepro}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> عنوان سفارش: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$product->title}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> عنوان سفارش: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$product->title}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> تعداد سفارش: </label>
                            <input type="text" class="form-control @error('number') is-invalid @enderror" id="exampleInputEmail1" name="number" value="{{$product->number}}" readonly>
                        </div>
                        <div class="form-group">
                            <lable for="exampleInputEmail1">شماره قطعه یا شماره سریال :</lable>
                            <input type="text" class="form-control @error('partnumber') is-invalid @enderror" id="exampleInputEmail1" name="partnumber" value="{{$product->partnumber}}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> نوع منبع یابی: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$product->pack->title}}" readonly>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">آخرین مدرک تحصیلی:</label>
                            <select class="form-control" name="status" style="height: 50px;">

                                <option  value="0">ثبت شده </option>
                                <option  value="1" <?php if($product->status==1) echo 'selected' ; ?>>کوپن تخفیف خود را استفاده کرده</option>
                                <option  value="2" <?php if($product->status==2) echo 'selected' ; ?>>پرداخت اولیه</option>
                                <option  value="3" <?php if($product->status==3) echo 'selected' ; ?>>تایید نهایی در انتظار پرداخت</option>
                                <option  value="4" <?php if($product->status==4) echo 'selected' ; ?>>پرداخت نهایی انجام شد</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <lable for="exampleInputEmail1">توضیحات  :</lable>
                            <textarea id="editor" type="text" class="form-control @error('description') is-invalid @enderror" name="description"  >{!! $product->description !!}</textarea>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.productstore')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
