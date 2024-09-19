@extends('portal.layout.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1 class="m-0">Dashboard </h1>
          
                @if(auth()->user()->hasPermissionTo('view_alldashboardstats'))

                <form action="{{ route('by_datedashboard') }}" method="POST" >
                @csrf
                    <label for="start_datet">Start Date</label>
                    <input type="datetime-local" id="start_datet" name="start_date" placeholder="Enter Start Date" value="{{ $startDate ??$startDate ?? now()->setTimezone('Asia/Karachi')->format('Y-m-d\T00:00') }}" required>
                    <label for="end_date">End Date</label>
                    <input type="datetime-local" id="end_date" name="end_date" placeholder="Enter End Date" value="{{$endDate ??$endDate ?? now()->setTimezone('Asia/Karachi')->format('Y-m-d\T23:59') }}" required>
                    <select class="form-control d-inline-block col-2 mr-1" name="dept" id="dept" onchange="updateuser()">
                            <option value="">Select Department</option>
                            @foreach($department as $dept)
                            @if(!empty($depart))
                            <option value="{{ $dept->id }}" @if($depart==$dept->id) selected @endif>{{ $dept->name }}</option>
                            @else
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                            @endif
                            @endforeach
                        </select>

                    <!-- <select class="form-control d-inline-block col-2 mr-1" name="user" id="user">
                        <option value="">Select Users</option>
                        @foreach($alluser as $user)
                        <option value="{{ $user->name }}">{{ $user->name }}</option>
                        @endforeach
                    </select> -->
                  
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                @endif



            </div><!-- /.col -->

            <div class="col-sm-2">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        @if(auth()->user()->hasPermissionTo('view_alldashboardstats'))
                        <h3>{{ $tasks->count() }}</h3>
                        @elseif(auth()->user()->hasPermissionTo('department_head'))
                        <h3>{{ $department_wise_tasks->count() }}</h3>
                        @elseif(auth()->user()->hasPermissionTo('supervisor_stats'))
                        <h3>{{ $charttask->count() }}</h3>
                        @else
                        <h3>{{ $charttask->count() }}</h3>
                        @endif

                        <p>All Tasks</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tasks"></i>
                    </div>

                  
                    @if(!empty($startDate) && !empty($endDate))
                    <a href="{{ route('task.index', ['depart' => $depart, 'start_date' => $startDate, 'end_date' => $endDate]) }}"  class="small-box-footer">    
                    More info <i class="fas fa-arrow-circle-right"></i></a>
                    @else
                    <a href="{{ route('task.index') }}"  class="small-box-footer">    
                    More info <i class="fas fa-arrow-circle-right"></i></a>
                @endif
                </div>
            </div>
            <!-- ./col -->
            <!-- <div class="col-lg-3 col-6">
               
                <div class="small-box bg-warning">
                    <div class="inner">
                        @if(auth()->user()->hasPermissionTo('view_alldashboardstats'))
                        <h3>{{ $tasks->count() }}</h3>
                          <h3>allsubtask</h3>
                        @elseif(auth()->user()->hasPermissionTo('department_head'))
                        <h3>department_wise_subtask->count()</h3>
                        @elseif(auth()->user()->hasPermissionTo('supervisor_stats'))
                        <h3> blade place dollar enduser_allsubtask</h3>
                        @php
                        $totalSubtaskCount = 0; // Initialize the total subtask count
                        @endphp
                        @else
                        <h3>blade place dollar enduser_allsubtask </h3>
                        @endif
                        <p>All SubTasks</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    subtaskassigned replace with tasks
                    @if($tasks->count()==0)
                    <a href="{{route('subtask.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    @else
                    <a href="{{route('subtask.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    @endif
                </div>
            </div> -->
           
            <!-- ./col -->
            <div class="col-lg-4 col-6">
                <!-- small box -->



                @if(auth()->user()->hasPermissionTo('view_alldashboardstats'))
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $completedtask->count() }}</h3>
                        <p>Completed Tasks</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
              
                    @if(!empty($startDate) && !empty($endDate))
                    <a href="{{ route('task.completed', ['depart' => $depart, 'start_date' => $startDate, 'end_date' => $endDate]) }}"  class="small-box-footer">    
                    More info <i class="fas fa-arrow-circle-right"></i></a>
                    @else
                    <a href="{{ route('task.completed') }}"  class="small-box-footer">    
                    More info <i class="fas fa-arrow-circle-right"></i></a>
                @endif
                </div>
                @elseif(auth()->user()->hasPermissionTo('department_head'))
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $completedtask_department_wise->count() }}</h3>
                        <p>Completed Tasks</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <a href="{{route('task.completed')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                @elseif(auth()->user()->hasPermissionTo('supervisor_stats'))
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3> {{ $ctask->count() }}</h3>
                        <p>Completed Tasks</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    <a href="{{route('task.completed')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                @else
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3> {{ $ctask->count() }}</h3>
                        <p>Completed Tasks</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                    
                    <a href="{{route('task.completed')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>

                @endif

            </div>
            <div class="col-lg-4 col-6">
                <!-- small box -->

                @if(auth()->user()->hasPermissionTo('view_alldashboardstats'))

                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3> {{ $inprogress->count() }}</h3>
                        <p>In Progress Tasks</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list-ul"></i>
                    </div>
                    @if(!empty($startDate) && !empty($endDate))
                    <a href="{{ route('task.incompleted', ['depart' => $depart, 'start_date' => $startDate, 'end_date' => $endDate]) }}"  class="small-box-footer">    
                    More info <i class="fas fa-arrow-circle-right"></i></a>
                    @else
                    <a href="{{ route('task.incompleted') }}"  class="small-box-footer">    
                    More info <i class="fas fa-arrow-circle-right"></i></a>
                @endif
                </div>

                @elseif(auth()->user()->hasPermissionTo('department_head'))
                <div class="small-box bg-danger">
                    <div class="inner">


                        <h3>
                            {{$incompletetask_department_wise->count()}}
                        </h3>
                        <p>In Progress Tasks</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list-ul"></i>
                    </div>
                    <a href="{{route('task.incompleted')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>


                @elseif(auth()->user()->hasPermissionTo('supervisor_stats'))
                <div class="small-box bg-danger">
                    <div class="inner">


                        <h3>
                            {{$incompletetask->count()}}
                        </h3>
                        <p>In Progress Tasks</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list-ul"></i>
                    </div>
                    <a href="{{route('task.incompleted')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>

                @else
                <div class="small-box bg-danger">
                    <div class="inner">


                        <h3>
                            {{$incompletetask->count()}}
                        </h3>
                        <p>In Progress Tasks</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-list-ul"></i>
                    </div>
                    <a href="{{route('task.incompleted')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                @endif


            </div>
            <!-- ./col -->
            @if(auth()->user()->hasPermissionTo('view_alldashboardstats'))
            <div class="col-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Department Wise Completed and In Progress Tasks</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                        <canvas id="stackedBarChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>

                </div>
            </div>
            @endif


        </div>



    </div><!-- /.container-fluid -->

    <div class="card-header d-flex justify-content-end">
            <!-- <label for="userFilter">Filter by User:</label> -->
            <!--Admin like MD--->
            @if(auth()->user()->hasPermissionTo('view_alltasks'))
            <select class="form-control d-inline-block col-1 mr-1" id="departmentFilter" onchange="updateSubtaskOptions()">
                <option value="">All Department</option>
                @foreach($department as $departments)
                <option value="{{ $departments->id }}">{{ $departments->name }}</option>
                @endforeach
            </select>

            <select class="form-control d-inline-block col-1 mr-1 select2" id="projectFilter" >
                <option value="">All Projects</option>
                @foreach($projects as $proj)
                <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                @endforeach
            </select>

            <select class="form-control d-inline-block col-1 mr-1 select2" id="taskFilter">
                <option value="">All Tasks</option>
                @foreach($tasks as $task)
                <option value="{{ $task->title }}">{{ $task->title }}</option>
                @endforeach
            </select>
            <select class="form-control d-inline-block col-1 mr-1 select2" id="userFilter">
                <option value="">Assigned To</option>
                @foreach($alluser as $user)
                <option value="{{ $user->id }}">{{ $user->name }}({{ $user->designation }})</option>
                @endforeach
            </select>
            <!--department head--->
            @elseif(auth()->user()->hasPermissionTo('department_head'))

            <select class="form-control d-inline-block col-1 mr-1" id="projectFilter">
                <option value="">All Projects</option>
                @foreach($dept_wise_project as $proj)
                <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                @endforeach
            </select>

            <select class="form-control d-inline-block col-1 mr-1 select2" id="userFilter">
                <option value="">Assigned To</option>
                <?php $displayed = []; ?>
                @foreach($department_wise_tasks as $task)
                @if(!in_array($task->task_manager->name ?? '', $displayed))
                <option value="{{ $task->task_manager->id ?? '' }}">{{ $task->task_manager->name ?? '' }}({{ $task->task_manager->designation ?? '' }})</option>
                <?php $displayed[] = $task->task_manager->name ?? ''; ?>
                @endif
                @endforeach
            </select>



            <select class="form-control d-inline-block col-1 mr-1 select2" id="taskFilter">
                <option value="">All Tasks</option>
                @foreach($department_wise_tasks as $task)
                <option value="{{ $task->title }}">{{ $task->title }}</option>
                @endforeach
            </select>

            <!--enduser filters--->
            @else

            <select class="form-control d-inline-block col-1 mr-1 " id="userFilter">
                <option value="">Assigned To</option>
                <?php $displayed = []; ?>
                @foreach($usertask as $task)
                    @if(!in_array($task->task_manager->name, $displayed))
                        <option value="{{ $task->task_manager->id }}">{{ $task->task_manager->name }}({{ $task->task_manager->designation }})</option>
                        <?php $displayed[] = $task->task_manager->name; ?>
                    @endif
                @endforeach
            </select>

            <select class="form-control d-inline-block col-1 mr-1 " id="taskFilter">
                <option value="">All Tasks</option>
                @foreach($usertask as $task)
                <option value="{{ $task->title }}">{{ $task->title }}</option>
                @endforeach
            </select>

            @endif

            <select class="form-control d-inline-block col-1 mr-1" id="priorityFilter">
                <option value="">Priority</option>

                <option value="High">High</option>
                <option value="Medium">Medium</option>
                <option value="Critical">Critical</option>
                <option value="Low">Low</option>
            </select>

            <select class="form-control d-inline-block col-1 mr-1" id="statusFilter">
                <option value="">Task Status</option>
                <option value="7">Approved</option>
                <option value="3">In Progress</option>
                <option value="5">On Hold</option>
                <option value="1">Completed</option>
                <option value="4">Blocked</option>
                <option value="2">Owned</option>
                <option value="6">Cancelled</option>
            </select>

            <button type="button" class="btn btn-default mr-1" id="daterange-btn">
                <i class="far fa-calendar-alt"></i>
                <span>Filters</span>
                <i class="fas fa-caret-down"></i>
            </button>

            @if(auth()->user()->hasPermissionTo('create_task'))
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addTaskModal">
                Add Task
            </button>
            @endif


        </div>
    <div class="card-body">
        <div class="table table-responsive">
        <table class="table table-bordered" id="taskTable">
                    <thead>
                        <tr>
                            <th> Sr. </th>
                            <th> Project </th>
                            <th> Task Name </th>
                            <th style="width:6%"> Due Date </th>                           
                            <th style="width:6%"> Priority </th>
                            <th> Assigned to </th>
                            <th style="width: 8%;">Estimated Duration (hrs)</th>
                            <th style="width: 7%;">Time Spent (hrs)</th>
                            <th style="width: 7%;">Remaining Time (hrs)</th>
                            <th>Status</th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                   <tbody>

                   </tbody>
                </table>
        </div>
    </div>

    <!-- Add Activity Modal -->
    <div class="modal fade" id="addActivityModal" tabindex="-1" role="dialog" aria-labelledby="addActivityModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addActivityModalLabel">Add Subtask</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('subtask.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="Name">Task </label>


                            <input type="text" class="form-control d-none" name="task" id="task_id">
                            <input type="text" class="form-control" name="task_title" id="task_title" readonly>


                        </div>
                        <div class="form-group">
                            <label for="Name">Subtask Name *</label>
                            <input type="text" class="form-control" required name="name" value="{{ old('name') }}" id="Name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label>Subtask Description *</label>
                            <textarea class="form-control" rows="3" required name="description" placeholder="Description">{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group d-none">
                            <label for="dueDateTime">Start Time/Date *</label>
                            <input type="datetime-local" class="form-control" name="start_datetime" id="start_datetime" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i') }}" placeholder="Start Time/Date">
                        </div>
                        <div class="form-group d-none">
                            <label for="dueDateTime">End Time/Date *</label>
                            <input type="datetime-local" class="form-control" name="end_datetime" id="end_datetime" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i') }}" placeholder="End Time/Date">
                        </div>
                        <div class="form-group">
                            <label for="duration" required>Estimated Time (hrs)</label>
                            <input type="text" class="form-control" required name="estimated_time" id="duration" placeholder="Estimated Time (hrs)">
                        </div>
                        <div class="form-group d-none">
                            <label for="due_date">Due Date</label>
                            <input type="text" class="form-control" name="due_datetime" id="due_date" placeholder="Due Date">
                        </div>



                        <div class="form-group">
                            <label>Subtask Status*</label>
                            <select class="form-control required" name="status" id="status" required>
                                <option value="0">In Progress</option>
                                <option value="6">Pending</option>
                                <!-- <option value="1">Completed</option> -->
                                <option value="2">On Hold</option>
                                <option value="3">Not Started Yet</option>
                                <option value="4">Cancelled</option>
                            </select>
                        </div>
                        <div class="form-group d-none">
                            <label>Task Status*</label>
                            <select class="form-control" name="task_status" id=" ">
                                <option value="">Please Select Task Status </option>

                                <option value="5">Approved</option>
                                <option value="1">Completed</option>

                                <option value="0">In Progress</option>
                                <option value="3">On Hold</option>
                                <option value="4">Cancelled</option>
                            </select>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input name="goodwork" class="custom-control-input custom-control-input-success" type="checkbox" id="customCheckbox4">
                            <label for="customCheckbox4" class="custom-control-label">If you consider this good work, please check the box.</label>
                        </div>
                        <div class="form-group">
                                <textarea class="form-control mt-2" rows="3" name="goodwork_description" id="goodwork_description" placeholder="Good Work Description">{{ old('goodwork_description') }}</textarea>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
                </form>

            </div>
        </div>
    </div>
    <!-- End of Add Activity Modal -->

    <!--Add Task Modal -->
    <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">`
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('task.store')}}" method="POST" enctype="multipart/form-data">


                        @csrf
                        <div class="form-group">
                            <label>Project*</label>
                            <select name="project" class="form-control" required>
                                <option value="">Please select your Project </option>
                                @foreach($dept_wise_project as $proj)
                                <option value="{{$proj->id}}">{{$proj->name}} | {{$proj->location}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Title">Task Name*</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" id="Title" placeholder="Title" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="Description">Description*</label>
                            <textarea class="form-control @error('Description') is-invalid @enderror" rows="3" name="Description" id="Description" placeholder="Description" required>{{ old('Description') }}</textarea>
                            @error('Description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" value="{{now()->setTimezone('Asia/Karachi')->format('Y-m-d') }}" required class="form-control" name="start_date" id="start_datetime" placeholder="start date">
                        </div>
                        <div class="form-group">
                            <label for="dueDate">Due Date</label>
                            <input type="date" value="{{now()->setTimezone('Asia/Karachi')->format('Y-m-d') }}" required class="form-control" name="dueDate" id="dueDatetime" placeholder="Due Date">
                        </div>
                        <div class="form-group">
                                <label>Task Type</label>
                                <select name="type" class="form-control">
                                    <option value="0" >Please select a type </option>
                                    <option value="1">Operational</option>
                                    <option value="2">Project Base</option>
                                </select>
                        </div>
                        <div class="form-group">
                            <label for="estimated_time">Estimated Time (hrs)*</label>
                            <input type="number" class="form-control" name="estimated_time" id="estimated_time" placeholder="Estimated Time (hrs)" required>
                        </div>

                        <div class="form-group">
                            <label>Priority</label>
                            <select name="priority" class="form-control">
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                                <option value="Critical">Critical</option>
                                <option value="Low">Low</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">

                                <option value="7">Approved</option>
                                <option value="3">In Progress</option>
                                <option value="5">On Hold</option>
                                <option value="1">Completed</option>
                                <option value="4">Blocked</option>
                                <option value="2">Owned</option>
                                <option value="6">Cancelled</option>

                            </select>
                        </div>

                        <div class="form-group">
                                <label>Assigned to</label>
                                <select name="assigned_to" class="form-control" required>
                                <option value="" >Please select the user </option>
                                <option value="{{auth()->user()->id}}">{{auth()->user()->name}} | {{auth()->user()->designation}} </option>
                                    @foreach($reportinguser as $userassigned)
                                    <option value="{{$userassigned->id}}">{{$userassigned->name}} | {{$userassigned->designation}}</option>
                                    @endforeach
                                </select>
                            </div>

                        <div class="form-group">
                            <label for="collaborators">Collaborators</label>
                            <select class="form-control collaboratorsearch" id="collaborators" name="collaborators[]" multiple="multiple" style="width: 100%;">
                                @foreach($reportinguser as $userassigned)
                                <option value="{{ $userassigned->id }}">{{ $userassigned->name }} | {{ $userassigned->designation }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="attach_file">Attach File</label>
                            <input type="file" class="form-control-file" name="attach_file" id="attach_file">
                            <small class="form-text text-muted">File size must be less than 5MB.</small>

                        </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add </button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Add this modal at the end of your Blade view -->



</section>
<!-- /.content -->
@endsection
@section('script')
<!-- Ensure to include necessary libraries for DataTables, Date Picker, and Slider -->
<script src="{{ url('/portal') }}/plugins/chart.js/Chart.min.js"></script>
<!-- Added for Notification -->
<script>
    // Add a click event listener to the notification icon
    $(document).ready(function() {
        $('#notificationIcon').click(function() {
            // Open the notification modal
            $('#notificationModal').modal('show');
        });
    });
</script>
<!-- Added for Notification -->


<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    // Initialize the DataTable
    let globalStartDate, globalEndDate;
    var table = $('#taskTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('task.list') }}",
            data: function(d) {
                // Default global start and end dates
                d.sDate = globalStartDate;
                d.eDate = globalEndDate;

                // Get filter values
                var departmentFilter = $('#departmentFilter').val();
                var projectFilter = $('#projectFilter').val();
                var userFilter = $('#userFilter').val();
                var taskFilter = $('#taskFilter').val();
                var priorityFilter = $('#priorityFilter').val();
                var statusFilter = $('#statusFilter').val();
                // Set filter values if they exist
                d.department = departmentFilter || "<?php if(!empty($depart)) {echo $depart;} ?>";
                d.project = projectFilter;
                d.assigned_to = userFilter;
                d.title = taskFilter;
                d.priority = priorityFilter;
                d.status = statusFilter;
                // Get PHP variables
                var phpStartDate = "<?php echo isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : ''; ?>";
                var phpEndDate = "<?php echo isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : ''; ?>";
                var phpDepartment = "<?php if(!empty($depart)) {echo $depart ? $depart : '';} ?>";

                // Set date values if filters do not have values
                if (!d.sDate) {
                    d.sDate = phpStartDate;
                }
                if (!d.eDate) {
                    d.eDate = phpEndDate;
                }

                // Logging for debugging
                console.log("Department:", d.department);
                console.log("Start Date:", d.sDate);
                console.log("End Date:", d.eDate);

//                 <?php
// $sDate=$_REQUEST['start_date'];
// $eDate=$_REQUEST['end_date'];
// $department=$_REQUEST['depart'];
// // dd($start_date);
// ?>
                // Retrieve the start and end dates separately
                // console.log("----------->", d.sDate)
            }
        },
        responsive: true,
        columns: [
            { data: 'id' },
            { data: 'project' },
            { data: 'title' },
            { data: 'duedate' },
            { data: 'priority' },
            { data: 'assigned_to' },
            { data: 'estimated_time' },
            { data: 'time_spent' },
            { data: 'remaining_time' },
            { data: 'status' },
            { data: 'action', orderable: false }
        ],
        order: [[0, 'asc']],
        rowCallback: function(row, data) {
        if (data.rowClass) {
            $(row).addClass(data.rowClass);
        }
    }
    });

    // Event listener for the custom filter
    $('#departmentFilter, #projectFilter, #userFilter, #taskFilter, #priorityFilter, #statusFilter').on('change', function() {
        table.draw();
    });

    // Date range picker
    $('#daterange-btn').daterangepicker({
        ranges: {
            'Today': [moment().format('DD-MM-YYYY'), moment()],
            'Yesterday': [moment().subtract(1, 'days').format('DD-MM-YYYY'), moment().subtract(1, 'days').endOf('day')],
            'Last 7 Days': [moment().subtract(6, 'days').format('DD-MM-YYYY'), moment().endOf('day')],
            'Last 30 Days': [moment().subtract(29, 'days').format('DD-MM-YYYY'), moment().endOf('day')],
            'This Month': [moment().startOf('month').format('DD-MM-YYYY'), moment()],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'All the Time': [moment().startOf('year'), moment()]
        },
        startDate: moment().startOf('year'),
        endDate: moment(),
        locale: {
            format: 'DD-MM-YYYY'
        },
        showDropdowns: true,
        timePicker: true,
    }, function(start, end) {
        $("#daterange-btn span").html(start.format('YYYY-MM-DD') + " to " + end.format('YYYY-MM-DD'))
        var sDate = start.format('YYYY-MM-DD')
        var eDate = end.format('YYYY-MM-DD')
        globalStartDate = sDate;
        globalEndDate = eDate;
        table.ajax.reload();
        
    });

});
</script>
<script>
    $(document).ready(function() {

        // This code is to get task data when clicked from server side data table list function
        $('#addActivityModal').on('show.bs.modal', function(event){
            var button = $(event.relatedTarget);
            var taskId = button.data('task-id');
            var taskTitle = button.data('task-title');

            var modal = $(this);
            modal.find('#task_id').val(taskId);
            modal.find('#task_title').val(taskTitle)
        });

        let iProgress = 0;

        // Handle click event of "Add Activity" button
        $('.add-activity-btn').on('click', function() {
            // Retrieve the task ID associated with the clicked button
            var taskId = $(this).data('task-id');
            var taskTitle = $(this).data('task-title');

            // Log the task ID to ensure it's correct
            console.log('Task ID:', taskId);
            console.log('Task Title:', taskTitle);

            // Set the task title in the modal input field
            $('#task_title').val(taskTitle);
            $('#title').val(taskId);
            var taskProgress = $(this).data('task-progress')
            iProgress = parseInt(taskProgress);

            $('#progressSliderModal').slider('setValue', parseInt(taskProgress));

            // Populate any necessary fields in the modal
            $('#addActivityModal input[name="task"]').val(taskId);
            $('#addActivityModal').modal('show');
        });

        // Set the task ID when a row is clicked
        $('#taskTable tbody').on('click', 'data-task-id', function() {
            // Retrieve the task ID associated with the clicked row
            var taskId = $(this).data('task-id');

            // Populate any necessary fields in the modal
            $('#addActivityModal input[name="task"]').val(taskId);

            // Open the "Add Activity" modal
            $('#addActivityModal').modal('show');
        });

        // Submit the form when the 'Add Activity' button is clicked
        $('#addActivityBtn').on('click', function() {
            $('#task-progress').val(calculatedDifference);
            $('#addActivityModal form').submit();
        });



        // Initialize progress slider for the modal
        $('#progressSliderModal').slider({
            formatter: function(value) {
                return 'Current value: ' + value;
            }
        });

        // Event listener for progress slider
        $('#progressSliderModal').on('slideStop', function(slideEvt) {

            var newProgress = parseInt(slideEvt.value);
            var difference = newProgress - iProgress; // Calculate the difference
            $('#task-progress').val(difference); // Store the difference in a hidden field

            var initialProgress = iProgress;
            // var newProgress = slideEvt.value;
            // Check if the new progress is greater than or equal to the current progress
            if (newProgress >= initialProgress) {
                // Update the current progress value
                $('#progressSliderModal').slider('setValue', newProgress);
            } else {
                // If the new progress is less than the current progress, revert to the current progress
                alert("Progress can't be decreased! ")
                $('#progressSliderModal').slider('setValue', initialProgress);
            }
        });

        // let isValid  = $("#addTaskForm").attr("data-isValid");
        // //console.log(">>>>>>>>>>>>>", typeof(isValid))
        // if(isValid==1){
        //     //alert(isValid)
        //     $("#addTaskModal").modal("show");
        //     //$("#addTaskModal").css("display","block");

        // }
        // else {
        //     $("#addTaskModal").modal("hide");
        // }

        // let isValid= $("#addTaskBtn").on("click", function(){

        //     $("#addTaskForm").submit();
        // });



        // Add click event handler for delete buttons with class 'delete-task'
        $('.delete-task').on('click', function(event) {
            event.preventDefault(); // Prevent the default behavior (e.g., navigating to the delete URL)

            var taskId = $(this).data('task-id');

            // Show a confirmation alert
            if (confirm('Are you sure you want to Cancel this task?')) {
                // If user clicks 'OK', proceed with the deletion
                window.location.href = "{{ url('/admin/task/delete') }}/" + taskId;
            }
        });

        // Initialize DataTable

        // Initialize DataTable with column-specific options
        // var table = $('#taskTable').DataTable({
        //     columnDefs: [{
        //             targets: [1, 2, 3, 4, 5, 6, 7, 8, 9],
        //             orderable: false
        //         } // Set orderable to false for all columns except the 1st column
        //     ]
        // });


        // Apply filter when user selects a value from the userFilter dropdown
        $('#userFilter').on('change', function() {
            var filterValue = $(this).val();
            table.column(8).search(filterValue).draw();
        });


 

        // Input event handler for the user search
        $('#userSearch').on('input', function() {
            var searchQuery = $(this).val().toLowerCase();

            // Filter the table based on the entered user name
            $('#taskTable tbody tr').each(function() {
                var userName = $(this).find('td').eq(8).text().toLowerCase();

                if (userName.includes(searchQuery)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Apply filter when user selects a value from the taskFilter dropdown departmentFilter
        $('#taskFilter').on('change', function() {
            var filterValue = $(this).val();
            table.column(2).search(filterValue).draw();
        });
        $('#priorityFilter').on('change', function() {
            var filterValue = $(this).val();
            table.column(5).search(filterValue).draw();
        });
        $('#departmentFilter').on('change', function() {
            var filterValue = $(this).val();
            table.column(11).search(filterValue).draw();
        });
        $('#TaskStatus').on('change', function() {
            var filterValue = $(this).val();
            table.column(13).search(filterValue).draw();
        });
        $('#projectFilter').on('change', function() {
            var filterValue = $(this).val();
            table.column(1).search(filterValue).draw();
        });

    });
</script>
<script>
    $(function() {
        $('#start_date').daterangepicker({
            singleDatePicker: true,
        })

        $('#due_date').daterangepicker({
            singleDatePicker: true,
        })


        $('#dueDate').daterangepicker({
            singleDatePicker: true,
        });
    });
</script>
<script>
    
    function updateSubtaskOptions() {
    var departmentFilter = document.getElementById("departmentFilter");
    var taskFilter = document.getElementById("taskFilter");
    var projectFilter = document.getElementById("projectFilter");
    var department = departmentFilter.value;

    projectFilter.innerHTML = "<option value=''>Projects</option>";
    @foreach($department as $departments)
    if ("{{ $departments->id }}" === department || department === "") {
        @if($departments->projects)
        @foreach($departments->projects as $proj)
                var option = document.createElement("option");
                option.value = "{{ $proj->id }}";
                option.textContent = "{{ $proj->name }}";
                projectFilter.appendChild(option);
            @endforeach
        @endif
    }
    @endforeach

    // Clear existing options
    taskFilter.innerHTML = "<option value=''>All Tasks</option>";

    // Add tasks corresponding to the selected department
    @foreach($department as $departments)
    if ("{{ $departments->id }}" === department || department === "") {
        @foreach($departments->tasks as $task)
            var option = document.createElement("option");
            option.value = "{{ $task->id }}";
            option.textContent = "{{ $task->title }}";
            taskFilter.appendChild(option);
        @endforeach
    }
    @endforeach
}
</script>


<script>
    $(document).ready(function() {
        $('.select2').select2();

        $('.usersearch').select2({
            placeholder: "Please Select the User"
        });
        $('.collaboratorsearch').select2({
            placeholder: "Please Select the Collaborator"
        });

//---------------------
    //- STACKED BAR CHART -
    //---------------------
    <?php
$labels = [];
$completedData = [];
$inProgressData = [];

foreach ($departmentsWithCI as $data) {
    $labels[] = $data->name;
    $completedData[] = $data->completed_tasks_count;
    $inProgressData[] = $data->incompleted_tasks_count;
}

// Convert PHP arrays to JSON
$labelsJson = json_encode($labels);
$completedDataJson = json_encode($completedData);
$inProgressDataJson = json_encode($inProgressData);
?>
    var barChartConfig = {
    labels: <?php echo $labelsJson; ?>,
    datasets: [
        {
            label: 'Completed',
            backgroundColor: 'rgba(60,141,188,0.9)',
            borderColor: 'rgba(60,141,188,0.8)',
            pointRadius: false,
            pointColor: '#3b8bba',
            pointStrokeColor: 'rgba(60,141,188,1)',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data: <?php echo $completedDataJson; ?>
        },
        {
            label: 'In Progress',
            backgroundColor: 'rgba(210, 214, 222, 1)',
            borderColor: 'rgba(210, 214, 222, 1)',
            pointRadius: false,
            pointColor: 'rgba(210, 214, 222, 1)',
            pointStrokeColor: '#c1c7d1',
            pointHighlightFill: '#fff',
            pointHighlightStroke: 'rgba(220,220,220,1)',
            data: <?php echo $inProgressDataJson; ?>
        },
      ]
    }
    var barChartData = $.extend(true, {}, barChartConfig)
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)

    var stackedBarChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }

    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })

    });
</script>





@endsection