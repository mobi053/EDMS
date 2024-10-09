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
                @if($subtasknotifycount>0)
                <span class="badge badge-danger navbar-badge">{{$subtasknotifycount}} </span>
                @elseif($notificationcount > 0)
                <span class="badge badge-danger navbar-badge">{{ $notificationcount }}</span>
                @endif
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

                @if($subtasknotify->isNotEmpty())
                    <!-- <h6 >You have been assigned the following subtask(s):</h6> -->
                    <table class="table table-bordered table-striped table-hover d-none">
                        <thead>
                            <tr>
                                <th style="width: 10px;">Sr.</th>
                                <th>Subtask Title</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @foreach($subtasknotify as $subtask)
                                <tr>
                                    <th>{{ $loop->iteration}}.</th>
                                    <td>{{ $subtask->name }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                @elseif($notification->isNotEmpty())
                
                    <h6>You have been assigned the following task:</h6>
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 10px;">Sr.</th>
                                <th>Task Title</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @foreach($notification as $task)
                                <tr>
                                    <th>{{ $loop->iteration}}.</th>
                                    <td>{{ $task->title }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                
                    </table>
                @else 
                <h6>No Task has been assigned</h6>
                @endif
            </div>
            <div class="modal-footer">
                <a href="{{ route('task.index') }}" class="btn btn-danger">View All Tasks</a> 
                <!-- Add additional buttons or actions as needed --->
            </div>
        </div>
    </div>
</div>


<!-- /.navbar -->