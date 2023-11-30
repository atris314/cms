@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">فرم ویرایش سفارش حاضر شده به کاربر</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.presents.update',$present->id)}}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">زمان تحویل سفارش (عادی): </label>
                        <input type="text" class="form-control @error('deliverytime') is-invalid @enderror" id="exampleInputEmail1" name="deliverytime" value="{{$present->deliverytime}}" placeholder="مثال : 30 روز کاری">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">  هزینه خرید کالا از کشور مبدا: </label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="exampleInputEmail1" name="price" value="{{$present->price}}" placeholder="هزینه خرید کالا از کشور مبدا را وارد نمایید">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">  هزینه ترخیص (عادی) کالا (در صورت نامشخص بودن هزینه مورد نظر، این فیلد را خالی بگذارید) : </label>
                        <input type="text" class="form-control @error('releaseprice') is-invalid @enderror" id="exampleInputEmail1" name="releaseprice" value="{{$present->releaseprice}}" placeholder="هزینه ترخیص کالا را وارد نمایید">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">  زمان ترخیص فوری: </label>
                        <input type="text" class="form-control @error('quick') is-invalid @enderror" id="exampleInputEmail1" name="quick" value="{{$present->quick}}" placeholder="اگر این کالا امکان ترخیص فوری دارد زمان آن را وارد نمایید">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">  هزینه ترخیص فوری کالا(داده را به صورت عددی وارد نمایید) : </label>
                        <input type="text" class="form-control @error('quickprice') is-invalid @enderror" id="exampleInputEmail1" name="quickprice" value="{{$present->quickprice}}" placeholder="اگر این کالا امکان ترخیص فوری دارد هزینه آن را وارد نمایید">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">واحد پول:</label>
                        <select class="form-control" name="currency" >
                            <option value="0"  <?php if($present->currency==0) echo 'selected' ; ?>>ریال</option>
                            <option value="1"  <?php if($present->currency==1) echo 'selected' ; ?>>دلار</option>
                            <option value="2"  <?php if($present->currency==2) echo 'selected' ; ?>>یورو</option>
                            <option value="3"  <?php if($present->currency==3) echo 'selected' ; ?>>یوان</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">توضیحات سفارش: </label>
                        <textarea id="editor"  type="text" class="form-control @error('description') is-invalid @enderror" name="description" >{{$present->description}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">آپلود فایل :</label>
                        <input type="file" name="photo_id" id="exampleInputFile">
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" onclick="productGallery()" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection
