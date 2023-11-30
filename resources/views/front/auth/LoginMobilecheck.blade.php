@include('front.layouts.head')
@section('js')
    <script type="text/javascript">
        var myDiv    = document.getElementById('result');
        function countDown(){
            if(myDiv.textContent<=0){
                $(".mobile-check-btn").css('display','block');
                clearInterval(myTime);
            }else{
                myDiv.textContent = myDiv.textContent -1;
            }
        }
        var myTime = setInterval(countDown,1000);
    </script>
@endsection
<main id="main">
    <div class="logbody">
        <div class="contentlog col-lg-4 col-xs-12">
            <label class="col-sm-12 control-label" for="input-coupon">کد تایید ارسال شده را وارد کنید</label>
            @include('front.massages')
            <div class="col-lg-12 input-group-lg">
                <form id="coupon-form" method="post" action="{{route('LoginMobileCheckOutUser')}}">
                    @csrf
                    <div class="field">
                        <input type="text" name="checkid" value="{{old('checkid')}}">
                        <span class="icofont-check-circled"></span>
                        <label for="">کد تایید</label>
                    </div>
                    <div class="row">
                    <div class="col-lg-4" style="margin-top: 28px;">
                        <span style="font-weight: bold;font-size: 9pt;"> زمان باقیمانده :</span>
                        <span id="result">120 </span><span> ثانیه </span>
                    </div>
                    <div class="col-lg-5">
                        <button type="submit" class="buttlog" style="width: 100%">تایید<i class="icofont-ui-password mr-3"></i></button>
                    </div>
                    <div class="col-lg-3">
                        <a href="{{route('login')}}" class="buttsubmit mobile-check-btn" style="display: none;padding: 0; width: 100%;font-size: 9pt;">ارسال مجدد</a>
                    </div>
                    </div>
                </form>
            </div>
            <div class="row my-3">

                <div class="col-lg-6">
{{--                    <form action="{{route('LoginMobileCheckResentUser')}}" method="post">--}}
{{--                        @csrf--}}
{{--                        <div class="col-md-8 justify-content-center offset-2 ">--}}
{{--                            <input type="text" value="" name="user" hidden>--}}
{{--                            <button id="submit" type="submit"  class="mobile-check-btn mt-1" style="display: none;height: 50px; width: 100%">ارسال مجدد</button>--}}
{{--                        </div>--}}
{{--                    </form>--}}

                </div>
            </div>
            @if(isset(Auth::user()->mobileverified))
                <div class="row my-5 mx-1">
                    <div class="col-lg-6 col-xs-12">
                        <a href="{{route('profile')}}"  class="button-6 btn-green">داشبورد کاربری  <i class='bx bx-list-plus'></i></a>
                    </div>
                    <div class="col-lg-6 col-xs-12">
                        <a href="{{route('home')}}"  class="button-6 btn-blue">خانه <i class='bx bx-list-ul' ></i></a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</main><!-- End #main -->

@include('front.layouts.script')
