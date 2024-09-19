@extends('portal.layout.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1 class="m-0">Dashboard </h1>
                <form action="{{ route('by_datedashboard') }}" method="GET" >
                <label for="start_date">Start Date</label>
                    <input type="datetime-local" id="start_date" name="start_date" placeholder="Enter Start Date" value="{{ $startDate ?? now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i')}}" required>
                    <label for="end_date">End Date</label>
                    <input type="datetime-local" id="end_date" name="end_date" placeholder="Enter End Date" value="{{ $endDate ?? now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i')}}"  required>
                    <select class="form-control d-inline-block col-2 mr-1" name="dept" id="dept"  onchange="updateuser()">
                        <option value="">Select Dept.</option>
                        @foreach($department as $dept)
                        <option value="{{ $dept->id }}" @if($depart == $dept->id) selected @endif>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                    <select class="form-control d-inline-block col-2 mr-1 modalsearch" name="user" id="user">
                        <option value="">Select Users</option>
                        @foreach($alluser as $user)
                        <option value="{{ $user->name }}" @if($userName == $user->name) selected @endif>{{ $user->name }}</option>
                        @endforeach
                    </select>
                  
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
                       

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
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                <div class="inner">
                    
                         <h3>{{ $tasks->count() }}</h3>
                       
                        <p>All Tasks</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-tasks"></i>
                    </div>
                </div>
            </div>
             <!-- ./col -->
             <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                <div class="inner">
                        <h3>{{ $subtasks->count() }}</h3>
                      
                        <p>All SubTasks</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                   
                </div>
            </div>
            <!-- ./col -->
            <!-- ./col -->
            <div class="col-lg-3 col-6">
                <!-- small box -->
               

                        <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $ctasks->count() }}</h3>
                        <p>Completed Tasks</p>
                        </div>
                    <div class="icon">
                        <i class="fa fa-check-circle"></i>
                    </div>
                </div>
  
                </div>       
            <div class="col-lg-3 col-6">
                <!-- small box -->
                

                        <div class="small-box bg-danger">
                    <div class="inner">
                        <h3> {{ $itasks->count() }}</h3>
                        <p>In Progress Tasks</p>
                        </div>
                    <div class="icon">
                        <i class="fa fa-list-ul"></i>
                    </div>
                </div>

            </div>
            <!-- ./col -->
        </div>

        <!-- /.row -->

    </div><!-- /.container-fluid -->

    <div class="card card-info card-outline">
         <!---total duration black box---->
         <div class="row justify-content-center">
            <div class="col-12">
                <h3 class=text-center style="padding-top: 15px;;">Total Duration</h3>
            </div>
            <div class="col-md-6 col-xl-3 col-xxl-3">
                <div class="clock-container justify-content-center bg-info">
                    <!-- <div class="clock-col">
                            <p class="clock-day clock-timer">
                            </p>
                            <p class="clock-label">
                            Days
                            </p>
                        </div> -->
                    <div class="clock-col">
                        <p class="clock-hours clock-timer">
                        </p>
                        <p class="clock-label">
                            Hours
                        </p>
                    </div>
                    <div class="clock-col">
                        <p class="clock-minutes clock-timer">
                        </p>
                        <p class="clock-label">
                            Minutes
                        </p>
                    </div>
                
                </div>
            </div>
        </div>
        <!---end total duration---->
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    <h4>All SubTasks</h4>
                </div>

                <div class="col-6 text-right">

                    
                
       
      
            <!--for admin to show all tasks in filter--->
            <select class="form-control d-inline-block col-2 mr-1" id="taskFilter" onchange="updateSubtaskOptions()">
    <option value="">All Tasks</option>
    @foreach($tasks as $task)
        <option value="{{ $task->title }}">{{ $task->title }}</option>
    @endforeach
</select>

<select class="form-control d-inline-block col-2 mr-1" id="subtaskFilter">
    <option value="">All Subtasks</option>
   
        @foreach($subtasks as $subtask)
            <option value="{{ $subtask->name }}" data-task="{{ $subtask->name }}">
                {{ $subtask->name }}
            </option>
        @endforeach
    
</select>

            <select class="form-control d-inline-block col-2 mr-1" id="SubtaskStatus">
                <option value="">Sub Tasks Status</option>

                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
                <option value="Not Started Yet">Not Started Yet</option>
                <option value="On Hold">On Hold</option>
                <option value="Cancelled">Cancelled</option>
            </select>
      
                    
                </div>
            </div>
            <!-- Add these input fields within the Add Activity Modal in your view -->
        </div>
        <div class="card-body">

            <div class="table-responsive">
            <table class="table table-bordered" id="subtaskTable">
                    <thead>
                    <tr>
                            <th>Task Name</th>
                            <th>SubTask Name</th>
                            <th>Task Due Date</th>
                            <th class="d-none">Start Time</th>
                            <th>Estimated Time (hrs)</th>
                            <th>Time Spent (hrs)</th>
                            <th class="d-none">SubTask Created At</th>
                            <th>Subtask Creator</th>
                            <th>SubTask Status</th>
                            <th class="d-none">Department</th>
                            <th>Actions</th>
                           
                           
                        </tr>
                    </thead>
                    <tbody>

                        <!-- //It is for Admin like MD to view all subtasks -->                        
                        @foreach($tasks as $task)
                        @foreach($task->subtasks as $subtask)
                        <tr data-user-id="{{$subtask->sub_task_creator->id}}" @if($subtask->status==4) style="background-color: #999; color:#fff" @elseif($task->duedate <now()) style="background-color: #ffcccc;" @endif>
                        <td> <a @if($subtask->status==4) style="background-color: #999; color:#fff" @endif href="{{ route('task.subtask_list', ['id' => $task->id]) }}"> {{$task->title}} </a></td>
                        <td> <a @if($subtask->status==4) style="color:#fff"  @endif href="{{ route('task.activity', ['id' => $subtask->id]) }}"> {{$subtask->name}} </a></td>
                            <td>{{$task->duedate}}</td>
                            <td class="d-none">{{$subtask->start_datetime}}</td>
                            <td>{{$subtask->estimated_time}}</td>   
                            <td>
                                @php
                                    $sumofActivitiesDuration = 0;
                                    foreach($subtask->activities as $activity) {
                                        $sumofActivitiesDuration += $activity->duration;
                                    }
                                    // Check if there are any activities, if not, set duration to null
                                    $sumofActivitiesDuration = $sumofActivitiesDuration > 0 ? $sumofActivitiesDuration : null;
                                    $timespenthr = number_format($sumofActivitiesDuration / 60, 1);

             
                                @endphp
                                {{$timespenthr}}
                            </td>
                            <td class="d-none">{{$subtask->created_at}}</td>
                            <td>
                                {{$subtask->sub_task_creator->name}} | {{$subtask->sub_task_creator->designation}}
                            </td>
                            <td>@if($subtask->status==1) Completed @elseif($subtask->status==0) In Progress @elseif($subtask->status==2) On Hold @elseif($subtask->status==3) Not Started Yet @elseif($subtask->status==4) Cancelled   @endif</td>
                            <td class="d-none">{{$task->department->name ?? ''}}</td>
                            <td>
                              <!-- Add actions/buttons for the new column doolar-subtask->sub_task_creator->id -->
                                <a href="{{ route('task.activity', ['id' => $subtask->id]) }}" class="mr-1 text-blue" title="View"><i class="fa fa-eye"></i> </a>
                                                                                                                              
                                @can('edit_subtask', $subtask)
                                @if(auth()->user()->id==$subtask->sub_task_creator->id)
                                <a href="{{ route('subtask.edit', ['id' => $subtask->id]) }}" class="mr-1 text-info" title="Edit Subtask"><i class="fa fa-edit"></i> </a>
                                @endif
                                @endcan
                                @can('delete_subtask', $subtask)
                                @if(auth()->user()->id==$subtask->sub_task_creator->id)
                                <a href="#" class="mr-1 text-danger delete-subtask" data-subtask-id="{{ $subtask->id }}"> <i class="fa fa-times"></i>
                                    </a>

                                </a>
                                @endif
                                @endcan                              
                            </td>
                        </tr>

                        @endforeach
                        @endforeach
                      
                        <!------end datatable----->
                   
                  
                        
                    </tbody>
                </table>
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




<script>
    $(document).ready(function() {

        // Add click event handler for delete buttons with class 'delete-subtask'
        $('#subtaskTable').on('click', '.delete-subtask', function(event) {
            event.preventDefault(); // Prevent the default behavior (e.g., navigating to the delete URL)
            var subtaskId = $(this).data('subtask-id');
            // Show a confirmation alert
            if (confirm('Are you sure you want to Cancel this SubTask?')) {
                // If the user clicks 'OK', proceed with the deletion
                window.location.href = "{{ url('/admin/subtask/delete') }}/" + subtaskId;
            }
        });
        $('#subtaskTable').on('click', '.delete-activity', function(event) {
            event.preventDefault(); // Prevent the default behavior (e.g., navigating to the delete URL)
            var subtaskId = $(this).data('act-id');
            // Show a confirmation alert
            if (confirm('Are you sure you want to delete this Activity?')) {
                // If the user clicks 'OK', proceed with the deletion
                window.location.href = "{{ url('/admin/subtask/deleteactivity') }}/" + subtaskId;
            }
        });

        // Calculate and update the sum of the "Duration" column
        function updateTotalDuration() {
            //var totalDurationMinutes = 0;
            var table = $('#subtaskTable').DataTable();
            table.rows().every(function(rowIdx, tableLoop, rowLoop) {
                //console.log(table.row(rowIdx).data()[5])
            });
            let minutes = table.column(5, {
                order: 'current',
                search: 'applied'
            }).data() // array
            let totalDurationMinutes = 0;
            minutes.map(min => {
                //min = parseInt(min)
                if (typeof min === 'number' || (typeof min === 'string' && min.trim() !== '' && !isNaN(min))) {
                    totalDurationMinutes = totalDurationMinutes + parseInt(min)
                }
            })



            var totalDurationHours = Math.floor(totalDurationMinutes);
            var remainingMinutes = totalDurationMinutes % 60;
            var seconds = 0;

            // Update the total duration in the new div
            document.documentElement.style.setProperty('--timer-hours', `"${totalDurationHours}"`);
            document.documentElement.style.setProperty('--timer-minutes', `"${remainingMinutes}"`);
            document.documentElement.style.setProperty('--timer-seconds', `"${seconds}"`);

        }

        // Initialize DataTables
        var table = $('#subtaskTable').DataTable({

            "columnDefs": [{
                "targets": -1, // Targets the last column (Actions)
                //  "orderable": false, // Make the column not sortable
                "render": function(data, type, row) {
                    // Customize the content of the Actions column
                    var subtaskId = row[0]; // Assuming the subtask ID is in the first column
                    // return '<a href="{{ route("subtask.edit", ["id" => "/"]) }}/' + subtaskId + '">' + data + '</a>';
                    return  data ;
                    // Add more buttons or HTML content as needed
                }
            }],
            "order": [
                [6, 'desc'] // Set the default order of the first column (change [0, 'asc'] to the desired column index)
            ]
        });
        // Initial update
        updateTotalDuration();

     

        var currentProgress = 0; // Initialize with the default value

        // Event listener for task select dropdown
        $('#taskSelect').on('change', function() {
            var taskId = $(this).val();

            // Fetch progress value based on the selected task from the server
            $.ajax({
                url: '{{ route("subtask.getTaskProgress") }}',
                method: 'GET',
                data: {
                    taskId: taskId
                },
                success: function(response) {
                    // Store the current progress value
                    currentProgress = response.progress;

                    // Update the progress slider with the fetched progress value
                    $('#progressSliderModal').slider('setValue', currentProgress);
                },
                error: function(error) {
                    console.error('Error fetching task progress:', error);
                }
            });
        });

        // Event listener for progress slider
     


       

        // Task filter change event handler
        $('#taskFilter').on('change', function() {
            var selectedUserId = $(this).val();

            // Show all rows if no user is selected
            if (selectedUserId === '') {
                table.columns(0).search('').draw();
            } else {
                // Filter the table based on the selected user's ID
                table.columns(0).search(selectedUserId).draw();
            }
            // Update total duration
            updateTotalDuration();
        });
        
        $('#subtaskFilter').on('change', function() {
            var selectedUserId = $(this).val();

            // Show all rows if no user is selected
            if (selectedUserId === '') {
                table.columns(1).search('').draw();
            } else {
                // Filter the table based on the selected user's ID
                table.columns(1).search(selectedUserId).draw();
            }
            // Update total duration
            updateTotalDuration();
        });

        $('#departmentFilter').on('change', function() {
            var filterValue = $(this).val();
            table.column(9).search(filterValue).draw();
        });

        $('#SubtaskStatus').on('change', function() {
            var filterValue = $(this).val();
            table.column(8).search(filterValue).draw();
        });


        // DataTables date range filtering function
   

        // Initialize date pickers
    
        

        // Initialize progress slider for the modal
       
    });
</script>

<script>
    function updateSubtaskOptions() {
        var taskFilter = document.getElementById("taskFilter").value;
        var subtaskFilter = document.getElementById("subtaskFilter");
        var subtaskOptions = subtaskFilter.querySelectorAll("option");

        // Clear existing options
        subtaskOptions.forEach(function(option) {
            subtaskFilter.removeChild(option);
        });

        // Add "All Subtasks" option
        var allSubtasksOption = document.createElement("option");
        allSubtasksOption.value = "";
        allSubtasksOption.textContent = "All Subtasks";
        subtaskFilter.appendChild(allSubtasksOption);

        // Add subtask options for the selected task
        @foreach($tasks as $task)
            if ("{{ $task->title }}" === taskFilter || taskFilter === "") {
                @foreach($task->subtasks as $subtask)
                    var option = document.createElement("option");
                    option.value = "{{ $subtask->name }}";
                    option.textContent = "{{ $subtask->name }}";
                    option.setAttribute("data-task", "{{ $task->title }}");
                    subtaskFilter.appendChild(option);
                @endforeach
            }
        @endforeach
    }

    function updateuser() {
    var dept = document.getElementById("dept").value;
    var userSelect = document.getElementById("user");
    userSelect.innerHTML = ''; // Clear existing options

    // Add default option
    var defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Select Users";
    userSelect.appendChild(defaultOption);

    // Add users for the selected department
    @foreach($department as $dept)
        if ("{{ $dept->id }}" === dept || dept === "") {
            @foreach($dept->users as $user)
                var option = document.createElement("option");
                option.value = "{{ $user->name }}";
                option.textContent = "{{ $user->name }}";
                userSelect.appendChild(option);
            @endforeach
        }
    @endforeach
}

</script>
<script>
    function updatetaskOptions() {
        var departmentFilter = document.getElementById("departmentFilter");
        var taskFilter = document.getElementById("taskFilter");
        var department = departmentFilter.value;

        // Clear existing options
        taskFilter.innerHTML = "<option value=''>All Tasks</option>";

        // Add tasks corresponding to the selected department
        @foreach($department as $departments)
            if ("{{ $departments->name }}" === department || department === "") {
                @foreach($departments->tasks as $task)
                    var option = document.createElement("option");
                    option.value = "{{ $task->title }}";
                    option.textContent = "{{ $task->title }}";
                    taskFilter.appendChild(option);
                @endforeach
            }
        @endforeach
    }
</script>
@endsection