@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>
                    {{$error}}
                </li>
            @endforeach
        </ul>
    </div>
@endif

<!--نمایش پیغام دسته بندی جدید -->
@if(session('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
@endif

@if(session('warning'))
    <div class="alert alert-danger">
        پیغام : {{session('warning')}}
    </div>
@endif
@if(session('info'))
    <div class="alert alert-danger">
        ثبت سفارش با خطا مواجه شد! لطفا دوباره تلاش کنید  {{session('info')}}
    </div>
@endif

@if(session('status'))
    <div class="alert alert-warning">
        یک خطا رخ داده است  {{session('status')}}
    </div>
@endif

@if(session('danger'))
    <div class="alert alert-warning">
         {{session('danger')}}
    </div>
@endif
@if(session('news'))
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
       خطا!
    </button>

    <!-- Modal -->
    <div class="modal fade" id="news" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{session('news')}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="icofont-close-squared-alt"></i></button>
                </div>
            </div>
        </div>
    </div>
{{--    <div class="alert alert-warning">--}}
{{--        {{session('news')}}--}}
{{--    </div>--}}
@endif
@section('js')
<script>
    $(window).on('load', function() {
        var modelShown = sessionStorage.getItem('modelShown');
        if(modelShown != 'YES'){
            $('#news').modal('show');
            sessionStorage.setItem('modelShown', 'YES');
        }
    });
</script>
    @endsection
