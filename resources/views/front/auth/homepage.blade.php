@include('front.layouts.head')
<main id="main">
    <div class="logbody">
        <div class="contentlog col-lg-4 col-xs-12">
            <img src="{{asset('front/assets/img/logo-fariaweb-pallet.png')}}" width="130px">
            <div class="text">
                به محدوده اختصاصی مدیریت آسان وب سایت خوش آمدید
            </div>
{{--            <button type="submit" class="buttlog"> ورود</button>--}}
            @auth
            <a class="buttsubmit buttlog" href="{{route('home')}}"> پنل مدیریت</a>
{{--            <a class="buttsubmit" href="{{route('register')}}"> ثبت نام</a>--}}
            @else
                <a class="buttsubmit buttlog" href="{{route('login')}}"> ورود</a>
                <a class="buttsubmit" href="{{route('register')}}"> ثبت نام</a>
            @endauth

        </div>
    </div>
</main><!-- End #main -->
@include('front.layouts.script')
