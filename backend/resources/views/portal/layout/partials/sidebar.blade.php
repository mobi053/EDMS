<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="{{url('/portal')}}/dist/img/psca-logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">WMS</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{url('/portal')}}/dist/img/user.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <div style="color: #ccc;">#</div>
      </div>
    </div>



    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
    
       
     
      
     



        <li class="nav-item">
          <a href="{{ route('users.index') }}" class="nav-link">
            <i class="nav-icon fa fa-users text-info"></i>
            <p> Users</p>
          </a>
        </li>




      

        <!--- menu-is-opening--->
       






        


    
     
   
     

        <li class="nav-item">
          <a href="{{route('permission.index')}}" class="nav-link">
            <i class="nav-icon fa fa-eye text-blue"></i>
            <p>Permissions</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-cog text-green"></i>
            <p>Reset User Password</p>
          </a>
        </li>



        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-cog text-purple"></i>
            <p>Reset Password</p>
          </a>
        </li>


      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>