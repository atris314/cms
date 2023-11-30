@include('front.layouts.head')
<main id="main">
    <div class="logbody">
        <div class="contentlog col-lg-4 col-xs-12">
            <img src="{{asset('front/assets/img/logo-fariaweb-pallet.png')}}" width="130px">
            <div class="text">
                فرم ثبت نام
            </div>
            <form action="{{route('register')}}" method="post">
                @include('front.massages')
                @csrf
                <div class="field">
                    <input type="text" name="name" placeholder="نام" value="{{old('name')}}" class="@error('name') is-invalid @enderror">
                    <span class="icofont-user"></span>
                    <label for="">نام</label>
                </div>
                <div class="field">
                    <input type="text" name="lastname" placeholder="نام خانوادگی" value="{{old('lastname')}}" class="@error('lastname') is-invalid @enderror">
                    <span class="icofont-user"></span>
                    <label for="">نام خانوادگی</label>
                </div>
{{--                <div class="field">--}}
{{--                    <input type="text" name="jobs" placeholder="حیطه کاری خود را بنویسید" value="{{old('jobs')}}">--}}
{{--                    <span class="icofont-search-job"></span>--}}
{{--                    <label for="">حیطه کاری خود را بنویسید</label>--}}
{{--                </div>--}}
                <div class="field">
                    <input type="text" name="email" placeholder="ایمیل" value="{{old('email')}}" class="@error('email') is-invalid @enderror">
                    <span class="icofont-ui-email"></span>
                    <label for="">حیطه کاری خود را بنویسید</label>
                </div>
                <div class="field">
                    <input type="text" name="mobile" placeholder="شماره موبایل" value="{{old('mobile')}}" class="@error('mobile') is-invalid @enderror">
                    <span class="icofont-phone"></span>
                    <label for="">شماره موبایل خود را وارد کنید</label>
                </div>
                <div class="field">
                    <input type="text" name="idcodes" placeholder="در صورت داشتن کد معرف آن را وارد نمایید(اختیاری) " value="{{old('idcodes')}}" class="@error('idcodes') is-invalid @enderror">
                    <span class="icofont-qr-code"></span>
                    <label for="">کد معرف </label>
                </div>
                <div class="field">
                    <input type="password" name="password" placeholder="رمز عبور" class="@error('password') is-invalid @enderror">
                    <span class="icofont-lock"></span>
                    <label for="">رمز عبور</label>
                </div>
                <div class="field">
                    <input type="password" name="password_confirmation" placeholder="تکرار رمز عبور" class="@error('password_confirmation') is-invalid @enderror">
                    <span class="icofont-lock"></span>
                    <label for=""> تکرار رمز عبور</label>
                </div>
{{--                <div class="capcha py-3">--}}
{{--                    {!! htmlFormSnippet() !!}--}}
{{--                    @arcaptchaWidget--}}
{{--                </div>--}}
                <button type="submit" class="buttlog">ثبت نام   </button>
                <a class="buttsubmit" href="{{route('login')}}"> ورود </a>
    </form>
        </div>
    </div>



</main><!-- End #main -->
@include('front.layouts.script')
