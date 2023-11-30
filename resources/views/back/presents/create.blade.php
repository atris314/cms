@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border" style="background: #f39d1480;">
                <h3 class="box-title">فرم ارسال سفارش حاضر شده به کاربر :</h3>
            </div>
            <table  class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                <thead>
                <tr role="row">
                    <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">
                        شناسه کاربر
                    </th>
                    <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">
                        نام کاربری
                    </th>
                    <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending">
                        نام و نام خانوادگی
                    </th>
                    <th class="sorting_asc text-center" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="موتور رندر: activate to sort column descending">
                        شماره موبایل
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr role="row" class="odd">
                    <td dir="ltr" class="text-center">{{$user->code}}</td>
                    <td class="text-center">{{$user->username}}</td>
                    <td class="text-center">{{$user->name}} {{$user->lastname}}</td>
                    <td class="text-center">{{$user->mobile}}</td>
                </tr>
                </tbody>

            </table>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.presents.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="box-header with-border" style="background: #f39d1480;">
                        <h3 class="box-title">اطلاعات مربوط به خرید کالا</h3>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">  هزینه خرید کالا از کشور مبدا: </label>
                        <input type="text" class="form-control @error('price') is-invalid @enderror" id="exampleInputEmail1" name="price" value="{{old('price')}}" placeholder="هزینه خرید کالا از کشور مبدا را وارد نمایید">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">واحد پول :</label>
                        <select class="form-control" name="currency" >
                            <option value="0">ریال</option>
                            <option value="1">دلار</option>
                            <option value="2">یورو</option>
                            <option value="3">یوان</option>
                        </select>
                    </div>
                    <div class="box-header with-border" style="background: #f39d1480;">
                        <h3 class="box-title">اطلاعات مربوط به ارسال و ترخیص</h3>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">  هزینه ترخیص (عادی) کالا (داده را به صورت عددی وارد نمایید و در صورت نامشخص بودن هزینه مورد نظر، این فیلد را خالی بگذارید) : </label>
                        <input type="text" class="form-control @error('releaseprice') is-invalid @enderror" id="exampleInputEmail1" name="releaseprice" value="{{old('releaseprice')}}" placeholder="هزینه ترخیص کالا را وارد نمایید">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">زمان تحویل سفارش (عادی): </label>
                        <input type="text" class="form-control @error('deliverytime') is-invalid @enderror" id="exampleInputEmail1" name="deliverytime" value="{{old('deliverytime')}}" placeholder="مثال : 30 روز کاری">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">  زمان ترخیص فوری: </label>
                        <input type="text" class="form-control @error('quick') is-invalid @enderror" id="exampleInputEmail1" name="quick" value="{{old('quick')}}" placeholder="اگر این کالا امکان ترخیص فوری دارد زمان آن را وارد نمایید">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">  هزینه ترخیص فوری کالا(داده را به صورت عددی وارد نمایید): </label>
                        <input type="text" class="form-control @error('quickprice') is-invalid @enderror" id="exampleInputEmail1" name="quickprice" value="{{old('quickprice')}}" placeholder="اگر این کالا امکان ترخیص فوری دارد هزینه آن را وارد نمایید">
                    </div>
                    <div class="box-header with-border" style="background: #f39d1480;">
                        <h3 class="box-title">توضیحات سفارش</h3>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">توضیحات سفارش: </label>
                        <textarea id="editor"  type="text" class="form-control @error('description') is-invalid @enderror" name="description" >{{old('description')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">کد سفارش:</label>
                        <span>کد سفارش محصول مورد نظر را وارد کنید.</span>
                        <input type="text" class="form-control @error('productcode') is-invalid @enderror" id="exampleInputEmail1" name="productcode" value="{{$codpro}}" readonly>
                        <input type="text" class="form-control @error('product_id') is-invalid @enderror hidden" id="exampleInputEmail1" name="product_id" value="{{$product_id}}" hidden>

{{--                        <select class="form-control" name="productcode">--}}
{{--                            @foreach($products as $products_id => $products_name)--}}
{{--                                <option value="{{$products_id}}">{{$codpro}}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
                    </div>

                    <div class="form-group">
                        <label for="pro-photo">تصاویر محصول :</label>
                        <div class="col-sm-12">
                            <input type="hidden" name="photos[]" id="pro-photo">
                            <div id="photo" class="dropzone"></div>
                        </div>
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
