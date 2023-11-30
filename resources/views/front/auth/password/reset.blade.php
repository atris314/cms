@include('front.loglayouts.headerlog')

<main id="main">
    <div class="logbody">
        <div class="contentlog col-lg-4 col-xs-12">
            <img src="{{asset('front/assets/img/logo yabane fa bold-newcolor.png')}}" width="130px">
            <div class="text">
                فرم ایجاد رمز عبور جدید
            </div>
            @include('front.massages')
            <form action="{{ route('password.update') }}" method="post">
                {{ csrf_field() }}
                @csrf
                <input type="hidden" name="token" value="{{$token}}">
                <div class="field">
                    <input type="text" name="email" placeholder="ایمیل" value="{{old('email')}}" class="@error('email') is-invalid @enderror">
                    <span class="icofont-ui-email"></span>
                    <label for="">ایمیل</label>
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
                <button type="submit" class="buttlog"> ایجاد </button>
            </form>
        </div>
    </div>




</main><!-- End #main -->
@include('front.loglayouts.footerlog')