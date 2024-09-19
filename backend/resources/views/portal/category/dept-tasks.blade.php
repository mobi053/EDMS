@extends('portal.layout.app')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                @foreach($department as $dept)
                <h1>{{$dept->name}} </h1>
                @endforeach
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <!-- <li class="breadcrumb-item"><a href="#">Projects</a></li> -->
                    <li class="breadcrumb-item active">Department</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $department_wise_tasks->count() }}</h3>
                    <p>All Tasks</p>
                </div>
                <div class="icon">
                    <i class="fa fa-tasks"></i>
                </div>
                <!-- <a href="{{route('task.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $completedtask_department_wise->count() }}</h3>
                    <p>Completed Tasks</p>
                </div>
                <div class="icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <!-- <a href="{{route('task.completed')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{$incompletetask_department_wise->count()}}</h3>
                    <p>In-Progress Tasks</p>
                </div>
                <div class="icon">
                    <i class="fa fa-list-ul"></i>
                </div>
                <!-- <a href="{{route('subtask.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
        <!-- ./col -->
        <!-- ./col --> 
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $department_wise_duetasks->count() }}</h3>
                    <p>Due Date Exceeded Tasks</p>
                </div>
                <div class="icon">
                    <i class="fa fa-clock"></i>
                </div>
                <!-- <a href="{{route('task.completed')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
            </div>
        </div>
    </div>
      
        <div class="card card-info card-outline">

            <div class="card-header d-flex justify-content-end">
                <!-- <label for="userFilter">Filter by User:</label> -->


                <!-- <select class="form-control d-inline-block col-1 mr-1" id="userFilter">
                    <option value="">Assigned To</option>
                    @php
                    $uniqueManagers = collect(); // Create a collection to store unique task manager names
                    @endphp

                    @foreach($tasks as $task)
                    @php
                    $manager = $task->task_manager; // Retrieve the task manager
                    @endphp
                    @if($manager && !$uniqueManagers->contains($manager->name))
                    @php
                    $uniqueManagers->push($manager->name); // Add the manager name to the collection if it's not already present
                    @endphp
                    <option value="{{ $manager->name }}">{{ $manager->name }}</option>
                    @endif
                    @endforeach

                </select> -->


            <select class="form-control d-inline-block col-1 mr-1" id="projectFilter">
                <option value="">All Projects</option>
                @foreach($projects as $proj)
                <option value="{{ $proj->name }}">{{ $proj->name }}</option>
                @endforeach
            </select>
            <select class="form-control d-inline-block col-1 mr-1" id="taskFilter">
                        <option value="">All Tasks</option>
                        @foreach($department_wise_tasks as $task)
                        <option value="{{ $task->title }}">{{ $task->title }}</option>
                        @endforeach
                    </select>
            <select class="form-control d-inline-block col-1 mr-1" id="priorityFilter">
                <option value="">Priority</option>
                <option value="High">High</option>
                <option value="Medium">Medium</option>
            </select>
            <select class="form-control d-inline-block col-1 mr-1" id="SubtaskStatus">
                <option value="">Status</option>

                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
                <option value="Not Started Yet">Not Started Yet</option>
                <option value="On Hold">On Hold</option>
                <option value="Cancelled">Cancelled</option>
            </select>

            <select class="form-control d-inline-block col-1 mr-1" id="userFilter">
                <option value="">Assigned To</option>
                <?php $displayed = []; ?>
                @foreach($tasks as $task)
                    @if(!in_array($task->task_manager->name, $displayed))
                        <option value="{{ $task->task_manager->name }}">{{ $task->task_manager->name }}</option>
                        <?php $displayed[] = $task->task_manager->name; ?>
                    @endif
                @endforeach
            </select>
          

          



                  

                <button type="button" class="btn btn-default  mr-1" id="daterange-btn">
                    <i class="far fa-calendar-alt"></i>
                    <span>Filters</span>
                    <i class="fas fa-caret-down"></i>
                </button>

            </div>
            <div class="card-body">
                <table class="table table-bordered" id="taskTable">
                    <thead>
                    <tr>
                        <th> Sr. </th>
                        <th> Project </th>
                        <th> Task Name </th>
                        <th> Due Date </th>
                        <th style="display: none;"> Description </th>
                        <th> Priority </th>
                        <th class="d-none"> Progress </th>
                       
                        <th class="d-none"> Created At </th>
                        <th> Assigned to </th>
                       
                    
                        <th>Estimated Duration (hrs)</th>
                        <th>Time Spent (hrs)</th>
                        <th class="d-none">Department</th>
                        <th>Status</th>
                        <th> Actions </th>
                    </tr>
                    </thead>
                    <tbody>

                    @php
                    $serialNumber = 1;
                    $totalProgress = 0;
                    @endphp
                        @foreach($tasks as $task)

                        <tr data-user-id="{{$task->task_creator->id}}" @if($task->status==4) style="background-color: #999; color:#fff" @elseif($task->duedate <now()) style="background-color: #ffcccc;" @endif>
                        <td>{{$serialNumber++}}</td>
                        <td>   <a href="{{ route('project.task_list', ['id' => $task->task_project->id]) }}" class="mr-1 text-blue" title="View Project">{{$task->task_project->name}}</a></td>
                        <td> <a @if($task->status==4) style="background-color: #999; color:#fff" @elseif($task->duedate <now()) style="background-color: #ffcccc;" @endif href="{{ route('task.subtask_list', ['id' => $task->id]) }}"> {{$task->title}} </a></td>
                        <td>{{$task->duedate}}</td>
                        <td style="display: none;">{{$task->description}}</td>
                        <td>{{$task->priority}}</td>
                        <td class="d-none">
                            @foreach($task->subtasks as $subtask)
                                @if($subtask->status == 1)
                                    @php
                                        $totalProgress += $subtask->progress;
                                    @endphp
                                @endif
                            @endforeach
                            {{$totalProgress ?? ''}}
                        </td>
                        

                        <td class="d-none">{{$task->created_at}}</td>
                        <td>{{$task->task_manager->name ?? ''}} | {{$task->task_manager->designation ?? ''}}</td>
                      
                      
                        <td>{{$task->estimated_time}}</td>
                        <td>
    @php
        $subtaskDurations = [];
    @endphp

    @foreach($task->subtasks as $subtask)
        @php
            $subtaskDurations[] = $subtask->duration;
        @endphp
    @endforeach

    {{ array_sum($subtaskDurations) }}
</td>

                        <td class="d-none">{{$task->department->name ?? ''}}</td>
                        <td>@if($task->status==1) Completed @elseif($task->status==0) In Progress @elseif($task->status==3) On Hold @elseif($task->status==4) Cancelled   @endif</td>
                        <td>
                            <!-- Add actions/buttons for the new column -->

                            

                            <a href="{{ route('task.subtask_list', ['id' => $task->id]) }}" class="mr-1 text-blue" title="View"><i class="fa fa-eye"></i> </a>
                           

                          
                        </td>
                    </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>


            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="d-flex justify-content-center">
                </div>
            </div>
        </div>
        <!-- /.card -->

</section>

@endsection



@section('script')
<!-- Ensure to include necessary libraries for DataTables, Date Picker, and Slider -->
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
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
        var table = $('#taskTable').DataTable({
            columnDefs: [{
                    targets: [1, 2, 3, 4, 5, 6, 7, 8, 9],
                    orderable: false
                } // Set orderable to false for all columns except the 1st column
            ]
        });


        // Apply filter when user selects a value from the userFilter dropdown
        $('#userFilter').on('change', function() {
            var filterValue = $(this).val();
            table.column(8).search(filterValue).draw();
        });


        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var startDatetime = $('#daterange-btn').data('daterangepicker').startDate;
                var endDatetime = $('#daterange-btn').data('daterangepicker').endDate;
                var activityCreatedAt = data[7]; // Assuming Activity Created At is in the 7th column

                if (!startDatetime && !endDatetime) {
                    // No date range filter applied, return true to include all rows
                    return true;
                }

                var activityDate = moment(activityCreatedAt, 'YYYY-MM-DD HH:mm:ss');

                if ((!startDatetime || activityDate.isSameOrAfter(startDatetime, 'day')) &&
                    (!endDatetime || activityDate.isSameOrBefore(endDatetime, 'day'))) {
                    // Activity date is within the specified range
                    return true;
                }

                return false;
            }
        );

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

        // Initialize date pickers
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
                    format: 'DD-MM-YYYY hh:mm A'
                },
                showDropdowns: true,
                timePicker: true,
            },
            function(start, end) {
                $("#daterange-btn span").html(start.format('DD-MM-YYYY hh:mm:ss A') + " to " + end.format('DD-MM-YYYY hh:mm:ss A'))
                table.draw();
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
        $('#SubtaskStatus').on('change', function() {
            var filterValue = $(this).val();
            table.column(12).search(filterValue).draw();
        });
        $('#departmentFilter').on('change', function() {
            var filterValue = $(this).val();
            table.column(11).search(filterValue).draw();
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