@include('front.layouts.head')
<main id="main">
    <div class="logbody">
        <div class="contentlog col-lg-4 col-xs-12">
            <img src="{{asset('front/assets/img/logo-fariaweb-pallet.png')}}" width="130px">
            <div class="text">
                فرم ورود به سایت
            </div>
            <form action="{{route('login')}}" method="post">
                @include('front.massages')
                @csrf

{{--                <div class="field">--}}
{{--                    <input type="text" name="mobile" placeholder="شماره موبایل" value="{{old('mobile')}}" class="@error('mobile') is-invalid @enderror">--}}
{{--                    <span class="icofont-phone-circle"></span>--}}
{{--                    <label for="">شماره موبایل</label>--}}
{{--                </div>--}}
                <div class="field">
                    <input type="text" name="email" placeholder="آدرس ایمیل" value="{{old('email')}}" class="@error('email') is-invalid @enderror">
                    <span class="icofont-phone-circle"></span>
                    <label for="">آدرس ایمیل</label>
                </div>
                <div class="field">
                    <input type="password" name="password" placeholder="رمز عبور" class="@error('password') is-invalid @enderror">
                    <span class="icofont-lock"></span>
                    <label for="">رمز عبور</label>
                </div>


{{--                    {!! ArCaptcha::getWidget() !!}--}}
{{--                <div class="capcha text-right rtl py-3">--}}
{{--                    @arcaptchaWidget--}}
{{--                </div>--}}
                <div class="forgot-pass">
                    <label for="">مرا به خاطر بسپار</label>
                    <input type="checkbox" class="form-check-input" name="remember">
                    <span class="icofont-lock"></span>
                </div>

                <div class="forgot-pass">
                    <a href="{{route('password.request')}}">رمز عبور خود را فراموش کرده اید؟</a>
                </div>
                <button type="submit" class="buttlog"> ورود</button>
                <a class="buttsubmit" href="{{route('register')}}"> ثبت نام</a>
            </form>
        </div>
    </div>
</main><!-- End #main -->
@include('front.layouts.script')
