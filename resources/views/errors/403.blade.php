<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>پنل مدیریت اختصاصی</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{asset('front/assets/img/favicon-ad.png')}}" rel="icon">
    <link href="{{asset('front/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{asset('front/assets/vendor/bootstrap/css/bootstrap.rtl.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/vendor/bootstrap/css/bootstrap.rtl.min.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/vendor/venobox/venobox.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/vendor/owl.carousel/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/vendor/aos/aos.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('back/chosen/chosen.css')}}"/>
    <link rel="stylesheet" href="{{url('back/chosen/chosen.css/chosen.min.css')}}"/>

    <!-- Template Main CSS File -->
    <link href="{{asset('front/assets/css/style.css')}}" rel="stylesheet">
</head>
<body dir="rtl" class="body403">
<!-- ======= Top Bar ======= -->
<main id="main">
    <section class="">
             <div class="container errorcard">
                <div class="erroricon">
                   <h5>خطایی رخ داده است شما دسترسی ندارید
                       لطفا به صفحه اصلی بازگردید</h5><br>
                    <a class="btn404" href="{{route('home')}}" >بازگشت به سایت</a>
                </div>
            </div>
    </section>
</main><!-- End #main -->
<!-- Vendor JS Files -->
<script src="{{asset('front/assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('front/assets/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('front/assets/vendor/php-email-form/validate.js')}}"></script>
<script src="{{asset('front/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('front/assets/vendor/venobox/venobox.min.js')}}"></script>
<script src="{{asset('front/assets/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('front/assets/vendor/aos/aos.js')}}"></script>

<!-- Template Main JS File -->
<script src="{{asset('front/assets/js/main.js')}}"></script>

<script src="{{url('back/chosen/chosen.jquery.js')}}"></script>
<script src="{{url('back/chosen/chosen.jquery.js/chosen.jquery.min.js')}}"></script>
@yield('js')

</body>

</html>
