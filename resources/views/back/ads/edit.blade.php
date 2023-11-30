@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-3">
            @if($ad->photo_id)
                <td><img src="{{$ad->photo->path}}" class="img-fluid" style="border-radius: 50%; width:250px;     height: 250px;" ></td>
            @else
                <td><img src="{{url('back/dist/img/avatar-default.png')}}" class="img-fluid" style="border-radius: 50%; width:250px;     height: 250px;"></td>
            @endif
        </div>
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش تبلیغات: </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.ads.update',$ad->id)}}" method="post" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">عنوان: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$ad->title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">عنوان: </label>
                            <input type="text" class="form-control @error('link') is-invalid @enderror" id="exampleInputEmail1" name="link" value="{{$ad->link}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">دسته بندي پشتیبانی:</label>
                            <select class="form-control" name="catorder_id" style="height: 50px;" >

                                @foreach($catorders as $cat_id => $cat_name)

                                    <option value="{{$cat_id}}"
                                    <?php
                                        if (
                                        in_array($cat_id,$ad->catorder()->pluck('id')->toArray())
                                        )
                                            echo 'selected';
                                        ?>

                                    >{{$cat_name}}
                                    </option>

                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">توضیحات: </label>
                            <textarea id="full-featured" type="text" class="form-control @error('description') is-invalid @enderror" name="description" style="font-family: 'vazir';" >{{$ad->description}}</textarea>

                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">تصویر</label>
                            <input type="file" name="photo_id" id="exampleInputFile">
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.ads')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
