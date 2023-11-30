@include('front.loglayouts.headerlog')
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
                <form id="coupon-form" method="post" action="{{route('MobileCheckOutUser')}}">
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
        </div>
    </div>
</main><!-- End #main -->

@include('front.loglayouts.footerlog')
