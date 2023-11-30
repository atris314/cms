@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @if($protranslate->photo_id)
                <td><img src="{{$protranslate->photo->path}}" class="img-fluid" style="border-radius: 10px; width:350px;" ></td>
            @else
                <td><img src="{{url('back/dist/img/pattern.png')}}" class="img-fluid" style="border-radius: 10px; width:350px;"></td>
            @endif
            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                    <tr role="row" class="odd">
                        <td>عنوان سفارش</td>
                        <td>{{$protranslate->product->title}}</td>
                    </tr>
                    <tr role="row" class="odd">
                        <td>کد پیگیری سفارش</td>
                        <td>{{$protranslate->product->codepro}}</td>
                    </tr>
                    <tr role="row" class="odd">
                        <td>تعداد</td>
                        <td>{{$protranslate->product->number}}</td>
                    </tr>
                    <tr role="row" class="odd">
                        <td>دسته بندی</td>
                        <td>@foreach(@$protranslate->product->catorder()->pluck('title') as $catorder)
                                <span  class="  btn btn-sm btn-default" >{{$catorder}}</span><br>
                            @endforeach</td>
                    </tr>
                </table>
        </div>
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش ترجمه: {{$protranslate->title}} </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.protranslates.update',$protranslate->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <h4>اطلاعات کاربر</h4>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> subject: </label>
                            <input type="text" class="text-right form-control @error('subject') is-invalid @enderror" dir="ltr" id="exampleInputEmail1" name="subject" value="{{$protranslate->subject}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">category: </label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror" id="exampleInputEmail1" name="category" value="{{$protranslate->category}}">
                        </div>
                        <div class="form-group">
                            <lable for="exampleInputEmail1">description  :</lable>
                            <textarea id="editor" type="text" class="form-control @error('description') is-invalid @enderror" name="description"  >{!! $protranslate->description !!}</textarea>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.protranslates')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
