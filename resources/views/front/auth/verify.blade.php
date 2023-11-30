@include('front.loglayouts.headerlog')

<main id="main">
    <div class="logbody">
        <div class="contentlog col-lg-4 col-xs-12">
            <img src="{{asset('front/assets/img/logo yabane fa bold-newcolor.png')}}" width="130px">
            <div class="text">
                فعال سازی حساب کاربری
            </div>
            @if(session('resent'))
                <div class="alert alert-success">
                    لینک فعال سازی حساب کاربری برای شما ارسال شد.<br>ایمیل خود را بررسی و روی لینک فعال سازی حساب کاربری کلیک کنید.<br> در صورت عدم دریافت ایمیل فعالسازی در پوشه inbox ایمیلتان، پوشه اسپم را چک بفرمایید.
                </div>
            @endif
            <form action="{{route('verification.resend')}}" method="post">
                @include('front.massages')
                @csrf
                <button type="submit" class="buttlog"> ارسال ایمیل فعال سازی</button>
            </form>
        </div>
    </div>




</main><!-- End #main -->
@include('front.loglayouts.footerlog')