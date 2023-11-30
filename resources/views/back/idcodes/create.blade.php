@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">ایجاد کد معرف</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.idcodes.store')}}" method="post">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">کد معرف:</label>
                        <input type="text" class="form-control @error('idcode') is-invalid @enderror" id="exampleInputEmail1" name="idcode" value="{{old('idcode')}}" placeholder="کد معرف ">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">تعداد یابانه کوین:</label>
                        <input type="text" class="form-control @error('numbercoin') is-invalid @enderror" id="exampleInputEmail1" name="numbercoin" value="{{old('numbercoin')}}" placeholder="تعداد یابانه کوین  ">
                    </div>
                </div>
                <!-- /.box-body -->
                

                <div class="box-footer">
                    <button type="submit" class="btn btn-lg btn-primary label pull-center bg-green" style="padding: 10px;">ذخيره</button>
                    <a href="{{route('back.idcodes')}}"  class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection

