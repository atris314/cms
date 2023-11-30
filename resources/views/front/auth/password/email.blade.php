@include('front.loglayouts.headerlog')

<main id="main">
    <div class="logbody">
        <div class="contentlog">
            <img src="{{asset('front/assets/img/logo yabane fa bold-newcolor.png')}}" width="130px">
            <div class="text">
                فرم بازیابی رمز عبور
            </div>
            @if(session('status'))
                <div class="alert alert-success">
                    لینک بازیابی رمز عبور برای شما ارسال شد.<br>ایمیل خود را بررسی و روی لینک بازیابی رمز عبور کلیک کنید.
                </div>
            @endif
            <form action="{{ route('password.email') }}" method="post">
                @csrf
                <div class="field">
                    <input type="text" name="email" placeholder="ایمیل خود را وارد کنید" value="{{old('email')}}" class="@error('email') is-invalid @enderror">
                    <span class="icofont-ui-email"></span>
                    <label for="">ایمیل</label>
                </div>
                <button type="submit" class="buttlog"> بازیابی رمز عبور</button>
            </form>
        </div>
    </div>




</main><!-- End #main -->
@include('front.loglayouts.footerlog')