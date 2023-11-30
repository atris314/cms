@extends('back.index')
@section('content')
    <div class="container">
        <div class="row">
    <div class="col-md-10 offset-md-1 justify-content-md-center">
        <div class="box box-warning col-md-10 offset-md-1">
            <div class="box-header with-border">
                <h3 class="box-title">ایجاد</h3>
            </div>
            @include('back.massages')
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{route('back.galleries.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="box-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">عنوان: </label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="exampleInputEmail1" name="title" value="{{old('title')}}" placeholder="عنوان">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">تصویر  :</label>
                        <input type="file" name="photo_id" id="exampleInputFile">
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
                    <a href="{{route('back.galleries')}}"   class="btn btn-lg btn-primary label pull-center bg-yellow" style="padding: 6px;">بازگشت</a>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    @endsection
@section('js')
    <script>
        var photosGallery = []
        var drop = new Dropzone('#photo' , {
            addRemoveLinks : true,
            url : "{{route('back.photos.upload')}}",
            sending : function (file ,xhr ,formData) {
                formData.append("_token" , "{{csrf_token()}}")
            },
            success: function (file, response){
                photosGallery.push(response.photos)
            }
        });
        productGallery = function () {
            document.getElementById('pro-photo').value = photosGallery
        }
    </script>
@endsection
