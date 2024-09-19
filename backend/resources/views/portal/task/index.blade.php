@extends('portal.layout.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tasks</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('task.index')}}">Task</a></li>
                  
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="card card-info card-outline"></div>

    <div class="card-header d-flex justify-content-end ">
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

            <select class="form-control d-inline-block col-1 mr-1 select2 " id="userFilter">
                <option value="">Assigned To</option>
                <?php $displayed = []; ?>
                @foreach($usertask as $task)
                    @if(!in_array($task->task_manager->name, $displayed))
                        <option value="{{ $task->task_manager->id }}">{{ $task->task_manager->name }}({{ $task->task_manager->designation }})</option>
                        <?php $displayed[] = $task->task_manager->name; ?>
                    @endif
                @endforeach
            </select>

            <select class="form-control d-inline-block col-1 mr-1 select2 " id="taskFilter">
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
    <div class="modal fade" id="addTaskModal" tabindex="" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">`
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('task.store')}}" method="POST" enctype="multipart/form-data" id="AddTaskForm">


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
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" id="Title" placeholder="Title" required oninput="restrictSpecialChars(this)">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="Description">Description*</label>
                                <textarea class="form-control @error('Description') is-invalid @enderror" rows="3" name="Description" id="Description" placeholder="Description" required oninput="restrictSpecialChars(this)">{{ old('Description') }}</textarea>
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
                                <input type="number" class="form-control" name="estimated_time" id="estimated_time" placeholder="Estimated Time (hrs)" required max="4000">
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
                                    <option value="999">Global</option>


                                </select>
                            </div>
                        @if(auth()->user()->department_type==1)
                            <div class="form-group">
                                <label>Department</label>
                                <select name="deptops" class="form-control" required>
                                <option value="" >Please select the Department </option>
                                    @foreach($departmentops as $departmentop)
                                    <option value="{{$departmentop->id}}">{{$departmentop->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Access Level</label>
                                <select name="deptops_global" class="form-control" required>
                                <option value="" >Please choose access level</option>
                                    <option value="1">All departments</option>
                                    <option value="2">Selected department only</option>
                                </select>
                            </div>
                        @endif
                            <div class="form-group">
                                <label>Assigned to</label>
                                <select name="assigned_to" class="form-control select2" required>
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
                        <button type="submit" class="btn btn-primary" id="addTaskButton">Add </button>
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


        $('.select2').select2();

$('.usersearch').select2({
    placeholder: "Please Select the User"
});
$('.collaboratorsearch').select2({
    placeholder: "Please Select the Collaborator"
});


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
            option.value = "{{ $task->title }}";
            option.textContent = "{{ $task->title }}";
            taskFilter.appendChild(option);
        @endforeach
    }
    @endforeach
}
</script>








@endsection