<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{csrf_token()}}">
  <title>پنل مدیریت</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{url('back/dist/css/bootstrap-theme.css')}}">
  <!-- Bootstrap rtl -->
  <link rel="stylesheet" href="{{url('back/dist/css/rtl.css')}}">
  <!-- persian Date Picker -->
  <link rel="stylesheet" href="{{url('back/dist/css/persian-datepicker-0.4.5.min')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('back/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('back/bower_components/Ionicons/css/ionicons.min.css')}}">
  <link href="{{asset('front/assets/vendor/icofont/icofont.min.css')}}" rel="stylesheet">
  <link href="{{asset('front/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('back/dist/css/AdminLTE.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{url('back/dist/css/skins/_all-skins.min.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{url('back/bower_components/morris.js/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{url('back/bower_components/jvectormap/jquery-jvectormap.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('back/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{url('back/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

    <link rel="stylesheet" href="{{url('back/chosen/chosen.css')}}"/>
    <link rel="stylesheet" href="{{url('back/chosen/chosen.css/chosen.min.css')}}"/>
    <link rel="stylesheet" href="{{url('back/dist/css/dropzone.min.css')}}">

  <link rel="stylesheet" href="{{asset('back/dist/css/persian-datepicker-0.4.5.min.css')}}" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('back/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{asset('back/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{asset('back/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{asset('back/plugins/iCheck/all.css')}}">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="{{asset('back/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{asset('back/plugins/timepicker/bootstrap-timepicker.min.css')}}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('back/bower_components/select2/dist/css/select2.min.css')}}">

  <link rel="stylesheet" href="{{asset('front/assets/src/jquery.md.bootstrap.datetimepicker.style.css')}}" />
  <link rel="stylesheet" href="{{asset('front/assets/dist/jquery.md.bootstrap.datetimepicker.style.css')}}" />
  <link href="{{asset('front/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script
          src="https://code.jquery.com/jquery-3.6.0.min.js"
          integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
          crossorigin="anonymous"></script>

  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->


  <link rel="stylesheet" href="{{asset('back/assets/src/jquery.md.bootstrap.datetimepicker.style.css')}}" />
  <link rel="stylesheet" href="{{asset('back/assets/dist/jquery.md.bootstrap.datetimepicker.style.css')}}" />


  <script src="https://cdn.tiny.cloud/1/ct8sqly92m42vvaaapw3r3u5r4v134klm36z2unbur5lac27/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>
    tinymce.init({
      selector: 'textarea#editor',
      height: 300,
      dirctionality : "rtl",
      plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste imagetools wordcount',
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
      ],
      toolbar: 'rtl ltr |insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
      content_style: 'body { font-family: Vazir,Helvetica,Arial,sans-serif; font-size:14px }'
    });

  </script>

  <script>
    var useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;

    tinymce.init({
      selector: 'textarea#full-featured',
      plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
      imagetools_cors_hosts: ['picsum.photos'],
      menubar: 'file edit view insert format tools table help',
      toolbar: 'rtl ltr |undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
      toolbar_sticky: true,
      autosave_ask_before_unload: true,
      autosave_interval: '30s',
      autosave_prefix: '{path}{query}-{id}-',
      autosave_restore_when_empty: false,
      dirctionality : "rtl",
      autosave_retention: '2m',
      image_advtab: true,
      link_list: [
        { title: 'My page 1', value: 'https://www.tiny.cloud' },
        { title: 'My page 2', value: 'http://www.moxiecode.com' }
      ],
      image_list: [
        { title: 'My page 1', value: 'https://www.tiny.cloud' },
        { title: 'My page 2', value: 'http://www.moxiecode.com' }
      ],
      image_class_list: [
        { title: 'None', value: '' },
        { title: 'Some class', value: 'class-name' }
      ],
      importcss_append: true,
      file_picker_callback: function (callback, value, meta) {
        /* Provide file and text for the link dialog */
        if (meta.filetype === 'file') {
          callback('https://www.google.com/logos/google.jpg', { text: 'My text' });
        }

        /* Provide image and alt text for the image dialog */
        if (meta.filetype === 'image') {
          callback('https://www.google.com/logos/google.jpg', { alt: 'My alt text' });
        }

        /* Provide alternative source and posted for the media dialog */
        if (meta.filetype === 'media') {
          callback('movie.mp4', { source2: 'alt.ogg', poster: 'https://www.google.com/logos/google.jpg' });
        }
      },
      templates: [
        { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
        { title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
        { title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
      ],
      template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
      template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
      height: 600,
      image_caption: true,
      quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
      noneditable_noneditable_class: 'mceNonEditable',
      toolbar_mode: 'sliding',
      contextmenu: 'link image imagetools table',
      skin: useDarkMode ? 'oxide-dark' : 'oxide',
      content_css: useDarkMode ? 'dark' : 'default',
      content_style: 'body { font-family:Vazir,Helvetica,Arial,sans-serif; font-size:14px }'
    });
  </script>


</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

@include('back.layouts.header')

  @include('back.layouts.mainsidebar')

  <div class="content-wrapper">
        @yield('content')
  </div>
  @include('back.layouts.controlsidebar')
</div>
@include('back.layouts.footer')

<script src="{{url('/js/app.js')}}"></script>

<script src="{{url('back/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url('back/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url('back/dist/js/dropzone.min.js')}}"></script>
<script src="{{url('back/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{url('back/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{url('back/bower_components/morris.js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{url('back/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{url('back/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{url('back/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('back/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{url('back/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{url('back/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{url('back/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{url('back/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{url('back/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{url('back/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('back/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('back/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('back/dist/js/demo.js')}}"></script>
<script src="{{url('back/chosen/chosen.jquery.js')}}"></script>
<script src="{{url('back/chosen/chosen.jquery.js/chosen.jquery.min.js')}}"></script>
@yield('js')
{{--<script src="{{url('back/assets/dist/jquery.md.bootstrap.datetimepicker.js')}}"></script>--}}
{{--<script src="{{url('back/assets/src/jquery.md.bootstrap.datetimepicker.js')}}" type="text/javascript"></script>--}}

<script src="{{url('front/assets/dist/jquery.md.bootstrap.datetimepicker.js')}}"></script>
<script src="{{url('front/assets/src/jquery.md.bootstrap.datetimepicker.js')}}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<script type="text/javascript" src="{{asset('back/dist/js/tableToExcel.js')}}"></script>

<script type="text/javascript">
  $('#date3').MdPersianDateTimePicker({
    targetTextSelector: '#inputDate3',
    monthsToShow: [1, 1]
  });
  $('#date6').MdPersianDateTimePicker({
    targetTextSelector: '#inputDate6',
    targetDateSelector: '#inputDate7',
    inLine: true,
    enableTimePicker: true,
    fromDate: true,
    groupId: 'date6-7-range'
  });

</script>

<script>
  $(function () {
    $('[data-toggle="popover"]').popover()
  });
</script>

<script>
  var photosGallery = []
  var drop = new Dropzone('#photo' , {
    addRemoveLinks : true,
    url : "{{route('back.photos.upload')}}",
    sending : function (file ,xhr ,formData) {
      formData.append("_token" , "{{csrf_token()}}")
    },
    success: function (file, response){
      photosGallery.push(response.photos)
    }
  });
  productGallery = function () {
    document.getElementById('pro-photo').value = photosGallery
  }
</script>
<script>
  function getTodos(){
    axios({
      method: 'get',
      url:'https://api.accessban.com/v1/widget/v2',
    })
       .then(res => showOutput(res))
       .catch(err =>console.error(err));
  }
  document.getElementById('accessban').addEventListener('click',getTodos);
</script>
<script>
$('#export-to-excel').click(function() {
  TableToExcel.convert(document.getElementById("tableID"), {
    name: "users-table.xlsx",
    sheet: {
      name: "users table"
    }
  });
});
$('#present-export-to-excel').click(function() {
  TableToExcel.convert(document.getElementById("tableID"), {
    name: "present-table.xlsx",
    sheet: {
      name: "present table"
    }
  });
});
</script>
{{--<script>--}}
{{--  function exportTableToExcel(tableID, filename = 'users-table'){--}}
{{--    var downloadLink;--}}
{{--    var dataType = 'application/vnd.ms-excel';--}}
{{--    var tableSelect = document.getElementById(tableID);--}}
{{--    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');--}}

{{--    // Specify file name--}}
{{--    filename = filename?filename+'.xls':'excel_data.xls';--}}

{{--    // Create download link element--}}
{{--    downloadLink = document.createElement("a");--}}

{{--    document.body.appendChild(downloadLink);--}}

{{--    if(navigator.msSaveOrOpenBlob){--}}
{{--      var blob = new Blob(['\ufeff', tableHTML], {--}}
{{--        type: dataType--}}
{{--      });--}}
{{--      navigator.msSaveOrOpenBlob( blob, filename);--}}
{{--    }else{--}}
{{--      // Create a link to the file--}}
{{--      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;--}}

{{--      // Setting the file name--}}
{{--      downloadLink.download = filename;--}}

{{--      //triggering the function--}}
{{--      downloadLink.click();--}}
{{--    }--}}
{{--  }--}}
{{--</script>--}}
</body>
</html>
