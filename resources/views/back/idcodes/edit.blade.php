@extends('back.index')
@section('content')
    <div class="row">
        <div class="col-md-9 justify-content-md-center">

            <div class="box box-success col-md-9  justify-content-md-center">
                <div class="box-header with-border">
                    <h3 class="box-title">ویرایش کد معرف: {{$idcode->idcode}} </h3>
                </div>
            @include('back.massages')
            <!-- /.box-header -->
                <!-- form start -->
                <form role="form" action="{{route('back.idcodes.update',$idcode->id)}}" method="post">
                    @method('put')
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">کد معرف:</label>
                            <input type="text" class="form-control @error('idcode') is-invalid @enderror" id="exampleInputEmail1" name="idcode" value="{{$idcode->idcode}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">تعداد یابانه کوین:</label>
                            <input type="text" class="form-control @error('numbercoin') is-invalid @enderror" id="exampleInputEmail1" name="numbercoin" value="{{$idcode->numbercoin}}">
                        </div>

                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">بروزرسانی</button>
                        <a href="{{route('back.idcodes')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

