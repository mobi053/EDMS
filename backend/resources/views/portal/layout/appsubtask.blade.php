<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WMS</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">


    @include ('portal.layout.partials.css-subtask-links')
</head>
<body class="hold-transition sidebar-mini">
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

@include('portal.layout.partials.js-subtask-links')
@yield('script')
</body>
</html>
