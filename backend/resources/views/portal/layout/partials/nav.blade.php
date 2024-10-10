<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">




        <li class="nav-item dropdown show" id="notificationIcon">
            <a class="nav-link" href="#" aria-expanded="true">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge">007</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</nav>
<!-- Add this modal at the end of your Blade view -->
<div class="modal" tabindex="-1" role="dialog" id="notificationModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Notifications </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                    <!-- <h6 >You have been assigned the following subtask(s):</h6> -->
                  
                <h6>No Task has been assigned</h6>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger">View All Tasks</a> 
                <!-- Add additional buttons or actions as needed --->
            </div>
        </div>
    </div>
</div>


<!-- /.navbar -->