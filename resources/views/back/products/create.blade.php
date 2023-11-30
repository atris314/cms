@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">فرم ثبت سفارش</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.products.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">عنوان سفارش: </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{old('title')}}" placeholder="مثال : صفحه نمایش موبایل">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">کاربر مورد نظر:</label>
                        <select class="form-control" name="user_id">
                            @foreach($users as $user)
                                <option class="option-customize" value="{{$user->id}}"
                                @if (old('user_id') == $user->id) {{ 'selected' }} @endif>
                                    {{$user->code}} - {{$user->name}} {{$user->lastname}} - {{$user->username}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">دسته بندی:</label>
                        <select class="form-control" name="catorder_id">
                            @foreach($catorders as $catorder_id => $catorder_name)
                                <option class="option-customize" value="{{$catorder_id}}"
                                @if (old('catorder_id') == $catorder_id) {{ 'selected' }} @endif>
                                    {{$catorder_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">نوع منبع یابی:</label>
                        <select class="form-control" name="pack_id">
                            @foreach($packs as $pack)
                                @if($pack->status==0)<option value="{{$pack->id}}" @if (old('pack_id') == $pack->id) {{ 'selected' }} @endif >{{$pack->title}} - {{$pack->price/1000}}     هزارتومان {!! $pack->description!!}</option>@endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">  تعداد سفارش: </label>
                        <input type="text" class="form-control @error('number') is-invalid @enderror" id="exampleInputEmail1" name="number" value="{{old('number')}}" placeholder="مثال: 10 یا ده عدد">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">  شماره قطعه (part number) :(اختیاری) </label>
                        <input type="text" class="form-control @error('partnumber') is-invalid @enderror" id="exampleInputEmail1" name="partnumber" value="{{old('partnumber')}}" placeholder="شماره قطعه یا شماره سریال">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">توضیحات سفارش: </label>
                        <textarea id="editor"  type="text" class="form-control @error('description') is-invalid @enderror" name="description" >{{old('description')}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="pro-photo">تصاویر محصول :</label>
                        <div class="col-sm-12">
                            <input type="hidden" name="photos[]" id="pro-photo">
                            <div id="photo" class="dropzone"></div>
                        </div>
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

