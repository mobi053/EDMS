@extends('portal.layout.app')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Completed Tasks</h1>

            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Tasks</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->

    <div class="card card-info card-outline">

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

            <select class="form-control d-inline-block col-1 mr-1 select2" id="projectFilter" onchange="updateProjectTask()" >
                <option value="">All Projects</option>
                @foreach($projects as $proj)
                <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                @endforeach
            </select>

            <select class="form-control d-inline-block col-1 mr-1 select2" id="taskFilter">
                <option value="">All Tasks</option>
                @foreach($ctask as $task)
                <option value="{{ $task->title }}">{{ $task->title }}</option>
                @endforeach
            </select>
            
            <select class="form-control d-inline-block col-1 mr-1 select2" id="userFilter">
                <option value="">Assigned To</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
            <!--department head--->
            @elseif(auth()->user()->hasPermissionTo('department_head'))

            <select class="form-control d-inline-block col-1 mr-1" id="projectFilter">
                <option value="">All Projects</option>
                @foreach($userproject as $proj)
                <option value="{{ $proj->id }}">{{ $proj->name }}</option>
                @endforeach

            </select>

            <select class="form-control d-inline-block col-1 mr-1 select2" id="taskFilter">
                <option value="">All Tasks</option>
                @foreach($completedtask_department_wise as $task)
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

            <button type="button" class="btn btn-default mr-1" id="daterange-btn">
                <i class="far fa-calendar-alt"></i>
                <span>Filters</span>
                <i class="fas fa-caret-down"></i>
            </button>


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
            url: "{{ route('task.completedList') }}",
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
                d.department = departmentFilter || "<?php echo isset($_REQUEST['depart']) ? $_REQUEST['depart'] : ''; ?>";
                d.project = projectFilter;
                d.assigned_to = userFilter;
                d.title = taskFilter;
                d.priority = priorityFilter;
                d.status = statusFilter;
                // Get PHP variables
                var phpStartDate = "<?php echo isset($_REQUEST['start_date']) ? $_REQUEST['start_date'] : ''; ?>";
                var phpEndDate = "<?php echo isset($_REQUEST['end_date']) ? $_REQUEST['end_date'] : ''; ?>";
                var phpDepartment = "<?php echo isset($_REQUEST['depart']) ? $_REQUEST['depart'] : ''; ?>";

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
        // End of This code is to get task data when clicked from server side data table list function


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

    function restrictSpecialChars(input) {
        // Define the allowed characters: letters, numbers, spaces, and hyphens
        const regex = /^[a-zA-Z0-9\s-.]*$/;
        
        // If the value doesn't match the allowed characters, replace the value with the filtered value
        if (!regex.test(input.value)) {
            input.value = input.value.replace(/[^a-zA-Z0-9\s-.]/g, '');
        }
    }
</script>
<script>

function updateProjectTask() {
        var projectFilter = document.getElementById("projectFilter").value;
        var taskFilter = document.getElementById("taskFilter");
        var subtaskOptions = taskFilter.querySelectorAll("option");
        // Clear existing options
        subtaskOptions.forEach(function(option) {
            taskFilter.removeChild(option);
        });

        // Add "All Subtasks" option
        var allSubtasksOption = document.createElement("option");
        allSubtasksOption.value = "";
        allSubtasksOption.textContent = "All Tasks";
        taskFilter.appendChild(allSubtasksOption);

        // Add subtask options for the selected task
        @foreach($projects as $proj)
        if ("{{ $proj->id }}" === projectFilter || projectFilter === "") {
             @foreach($proj -> ptasks->where('status', 1) as $task)
            var option = document.createElement("option");
            option.value = "{{ $task->title }}";
            option.textContent = "{{ $task->title }}";
            option.setAttribute("data-project", "{{ $proj->id }}");
            taskFilter.appendChild(option);
            @endforeach
        }
        @endforeach
    }
    
    function updateSubtaskOptions() {
    var departmentFilter = document.getElementById("departmentFilter");
    var taskFilter = document.getElementById("taskFilter");
    var projectFilter = document.getElementById("projectFilter");
    var department = departmentFilter.value;

    projectFilter.innerHTML = "<option value=''>All Projects</option>";
    @foreach($department as $departments)
    if ("{{ $departments->id }}" === department || department === "") {
        @if($departments->projects->whereNotIn('status', [1, 4, 6]))
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
        @foreach($departments->tasks->where('status', '!=', 6) as $task)
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
        
        
    });

    function handleFormSubmit(formId, buttonId) {
        document.getElementById(formId).addEventListener('submit', function(event) {
            event.preventDefault();  // Prevent the form from submitting immediately

            const button = document.getElementById(buttonId);
            button.disabled = true;

            setTimeout(function() {
                button.disabled = false;
                // Optionally, you can submit the form here after 5 seconds
                // document.getElementById(formId).submit(); 
            }, 10000);

            // Submit the form immediately after disabling the button
            document.getElementById(formId).submit();
        });
    }

    // Handle LogTimeForm submission and modal
    handleFormSubmit('AddTaskForm', 'addTaskButton');

    // Handle AddSubtaskForm submission and modal
    handleFormSubmit('AddSubtaskForm', 'addSubtaskButton');
    
</script>


@endsection