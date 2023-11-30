@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش گروه: {{$group->title}} </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.groups.update',$group->id)}}" method="post">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">عنوان گروه بندی: </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{$group->title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">دسته بندی ها:</label>

                            <select class=" form-control" name="catorder_id" style="height: 50px;">
                                @foreach($catorders as $cat_id => $cat_name)

                                    <option value="{{$cat_id}}"
                                    <?php
                                        if (
                                        in_array($cat_id,$group->catorder()->pluck('id')->toArray())
                                        )
                                            echo 'selected';
                                        ?>
                                    >{{$cat_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.groups')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

