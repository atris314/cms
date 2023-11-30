<footer id="footer">
    <div class="footer-top">
        <div class="container-fluid">
            <div class="row">

                <div class="col-lg-3 col-md-6">
                    <div class="footer-info">
                        <h3><img class="footer-logo-img" src="{{$settings->photo->path}}"> </h3>
                        <p>
                            {!! $settings->address !!}<br><br>
                            <strong>تلفن تماس:</strong> <div style="direction: ltr;">{{$settings->phone}}</div><br>
                            <strong>نشانی ایمیل:</strong> {{$settings->email}}<br>
                        </p>
                    </div>
                </div>

                <div class="col-lg-1 col-md-6 footer-links">
                    <h4>دسترسی سریع</h4>
                    <ul>
                        <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="{{route('home')}}">خانه</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="{{route('contacts')}}">تماس با ما</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="http://yabane.cod/#services">خدمات</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="{{route('front.faq')}}">سوالات متداول</a></li>
                        <li><i class="bx bx-chevron-right"></i> <a target="_blank" href="{{route('product')}}">ثبت سفارش</a></li>
                    </ul>
                </div>

                <div class="col-lg-4 px-5 col-md-6 footer-links">
                    <h6 class="pb-3">درباره یابانه</h6>
                    <p>
                        تیم یابانه بیش از ۱۵ سال است که در زمینه واردات قطعات و کالا در تمام رشته های فنی مهندسی فعالیت کرده است و اکنون با راه اندازی خدمات آنلاین یابانه قصد دارد تا تجربه‌ای سودمند در زمینه منبع یابی ، خرید و ارسال قطعات نایاب و کمیاب برای شما عزیزان به ارمغان بیاورد.
                    </p>
                </div>

                <div class="col-lg-3 col-md-6 footer-newsletter">
{{--                    <h4>اطلاع از تخفیف&zwnj;ها و فروش ویژه </h4>--}}
                    <h4>جهت اطلاع از تخفیف&zwnj;ها و فروش ویژه یابانه شماره تماس خود را وارد کنید </h4>
{{--                    <p>برای دریافت اخبار یابانه روی عضویت کلیک کنید.</p>--}}
                    @include('front.massages')
                    <form action="{{route('newsletter.store')}}" method="post">
                        @csrf
                        <input type="mobile" name="mobile" placeholder="شماره موبایل خود را وارد کنید" class="@error('title') is-invalid @enderror form-control">
                        <input type="submit" value="ارسال">
                    </form>
                    <div class="enamad text-center">
                        <a  referrerpolicy="origin" target="_blank" href="https://trustseal.enamad.ir/?id=236842&amp;Code=YRzamGLXt5SJTtd8Yroz">
{{--                            <img referrerpolicy="origin" src="https://trustseal.enamad.ir/Content/Images/Star/star1.png?v=5.0.0.47" alt="" style="cursor:pointer" id="YRzamGLXt5SJTtd8Yroz">--}}
                            <img src="https://trustseal.enamad.ir/Content/Images/Star2/81.png?v=5.0.0.3777"  alt="enamad" style="width:120px;height: 161px;">
                        </a>
                        <style>#nextpay{margin:auto; display: inline-block;} #nextpay img {width: 120px;}</style> <div id="nextpay"> <script src="https://nextpay.org/nx/js-trust/43425" type="text/javascript"></script> </div>
                    </div>
                    <h6 class="my-3">ما را در شبکه&zwnj;های اجتماعی دنبال کنید</h6>
                    <div class="social-links mt-3">
                        <a href="{{$settings->twitter}}" class="twitter"><i class="bx bxl-twitter"></i></a>
                        <a href="{{$settings->facebook}}" class="facebook"><i class="bx bxl-facebook"></i></a>
                        <a href="{{$settings->instagram}}" class="instagram"><i class="bx bxl-instagram"></i></a>
                        <a href="{{$settings->skype}}" class="google-plus"><i class="bx bxl-skype"></i></a>
                        <a href="{{$settings->linkedin}}" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        <a href="{{$settings->telegram}}" class="c"><i class="bx bxl-telegram"></i></a>
                        <a href="{{$settings->whatsapp}}" class="whatsapp"><i class="bx bxl-whatsapp"></i></a>
                        <a href="https://www.aparat.com/yabane.ir" class="aparat" style="position: absolute;"><img src="{{asset('front/assets/img/aparat.png')}}" width="30"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container footer-bottom">
        <div class="copyright"><a href="https://fariaweb.com/" target="_blank" style="color: white !important;">
            &copy;  <strong><span><script LANGUAGE="JavaScript">
                                        today=new Date();
                                        year=today.getFullYear();
                                        document.write(year);
                                    </script></span></strong>      تمامی حقوق مادی و معنوی متعلق به یابانه است.
            </a>
        </div>

        <div class="credits">
            طراحی شده با <i class="bx bx-heart"></i> توسط<a href="http://atris24.ir" target="_blank">{{$settings->copyright}}</a>
        </div>
    </div>
</footer>
