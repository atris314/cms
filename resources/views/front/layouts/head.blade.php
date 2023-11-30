<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>پنل مدیریت اختصاصی</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicons -->
    <link href="{{asset('front/assets/img/favicon-ad.png')}}" rel="icon">
    <link href="{{asset('front/assets/img/appleicon.png')}}" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link href="{{asset('front/assets/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
    <link href="{{asset('front/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{url('back/dist/css/dropzone.min.css')}}">
    @yield('style')

    <link href="{{asset('front/css/app.css')}}" rel="stylesheet">

    <script src="https://cdn.tiny.cloud/1/ct8sqly92m42vvaaapw3r3u5r4v134klm36z2unbur5lac27/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea#editor2',
            height: 200,
            dirctionality : "rtl",
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount',
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern"
            ],
            toolbar: 'rtl ltr |undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>
    <!-- Google recaptcha -->
    {!! htmlScriptTagJsApi(['lang'=>'fa']) !!}
    @arcaptchaScript
</head>
