@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">گروه بندی </h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.groups.store')}}" method="post">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">عنوان گروه بندی: </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{old('title')}}" placeholder="عنوان">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">دسته بندی ها:</label>
                        <select class="form-control" name="catorder_id" style="height: 50px;">
                            @foreach($catorders as $catorder_id => $catorder_name)
                                <option value="{{$catorder_id}}">{{$catorder_name}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.groups')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection
