<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WMS</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">


    @include ('portal.layout.partials.css-links')

    <style>
        /* Loader CSS */
        #loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('{{ url('/portal/dist/img/ajax-spinner.gif') }}') 50% 50% no-repeat rgb(249,249,249);
            opacity: .8;
        }
    </style>    
</head>
<body class="hold-transition sidebar-mini">
<div id="loader"></div>
<!-- Site wrapper -->
<div class="wrapper">
  @include('portal.layout.partials.nav')
  @include('portal.layout.partials.sidebar')

  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 2.0
    </div>
    <strong>Copyright &copy; 2024 <a href="#">{{env('APP_NAME')}}</a>.</strong> All rights reserved.
  </footer>

  
</div>
<!-- ./wrapper -->
<script>
        // JavaScript to hide loader
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("loader").style.display = "none";
        });

        // Show loader on page navigation
        window.addEventListener("beforeunload", function() {
            document.getElementById("loader").style.display = "block";
        });

        // Hide loader when navigating back
        window.addEventListener("pageshow", function(event) {
            if (event.persisted) {
                document.getElementById("loader").style.display = "none";
            }
        });
    </script>
@include('portal.layout.partials.js-links')
@yield('script')
</body>
</html>
