@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Completed SubTasks</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Subtask</li>
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

        @if(auth()->user()->hasPermissionTo('view_allactivities'))
            <select class="form-control d-inline-block col-1 mr-1" id="userFilter">
                <option value="">All Users</option>
                @foreach($users as $user)
                <option value="{{ $user->name }} | {{ $user->designation }}">{{ $user->name }} | {{ $user->designation }}</option>
                @endforeach
            </select>
            <!--for admin to show all tasks in filter--->
            <select class="form-control d-inline-block col-1 mr-1" id="taskFilter" onchange="updateSubtaskOptions()">
    <option value="">All Tasks</option>
    @foreach($tasks as $task)
        <option value="{{ $task->title }}">{{ $task->title }}</option>
    @endforeach
</select>

<select class="form-control d-inline-block col-1 mr-1" id="subtaskFilter">
    <option value="">All Subtasks</option>
    @foreach($tasks as $task)
        @foreach($task->subtasks as $subtask)
            <option value="{{ $subtask->name }}" data-task="{{ $task->title }}">
                {{ $subtask->name }}
            </option>
        @endforeach
    @endforeach
</select>

            <!---end---->
            @else
            <!--for specific user to show his task and collaborator task in filter--->
            
            <!-- <select class="form-control d-inline-block col-1 mr-1" id="userFilter">
                <option value="">Assigned To</option>
                @foreach($subordinate as $subuser)
                <option value="{{ $subuser->name }} | {{ $subuser->designation }}">{{ $subuser->name }} | {{ $subuser->designation }}</option>
                @endforeach


            </select> -->
        
                <select class="form-control d-inline-block col-1 mr-1" id="taskFilter" onchange="updateSubtaskOptions()">
                    <option value="">All Tasks</option>
                    @php
                        $uniqueTaskTitles = [];
                    @endphp
                    @foreach($subtaskdrop as $subtaskdropdown)
                        @if(!in_array($subtaskdropdown->task->title, $uniqueTaskTitles))
                            @php
                                $uniqueTaskTitles[] = $subtaskdropdown->task->title;
                            @endphp
                            <option value="{{  $subtaskdropdown->task->title }}" data-task="{{ $subtaskdropdown->task->title }}">
                                {{  $subtaskdropdown->task->title }}
                            </option>
                        @endif
                    @endforeach
                </select>


            <select class="form-control d-inline-block col-1 mr-1" id="subtaskFilter" >
                <option value="">Sub Tasks</option>
                @foreach($subtaskdrop as $subtaskdropdown)
                <option value="{{ $subtaskdropdown->name }}">{{ $subtaskdropdown->name }}</option>
                @endforeach
            </select>

            
            <!---end---->
            @endif
            <button type="button" class="btn btn-default mr-1" id="daterange-btn">
                <i class="far fa-calendar-alt"></i>
                <span>Filters</span>
                <i class="fas fa-caret-down"></i>
            </button>

            <!-- <label for="userSearch">Search by User:</label>
                    <input type="text" class="form-control" id="userSearch" placeholder="Enter user name"> -->
        </div>

        <!-- Add these input fields within the Add Activity Modal in your view -->


        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="subtaskTable">
                    <thead>
                        <tr>
                            <th >Task Title</th>
                            <th>Subtask Name</th>
                            <th>Subtask Due Date</th>
                           
                            <th>SubTask Created At</th>
                            <th>Assigned To</th>
                            <th>Assigned By</th>
                            <th>Subtask Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <!-- //It is for Admin -->
                        @if(auth()->user()->hasPermissionTo('view_allactivities'))
                        @foreach($completesubtask as $isubtask)
                    <tr>
                        <td> <a href="{{ route('task.subtask_list', ['id' => $isubtask->task->id]) }}"> {{$isubtask->task->title}} </a></td>
                        <td><a href="{{ route('task.activity', ['id' => $isubtask->id]) }}"> {{$isubtask->name}} </a></td>
                        <td>{{$isubtask->due_date}}</td>
                       
                        <td>{{$isubtask->created_at}}</td>
                        <td>{{$isubtask->sub_task_assign->name}} | {{$isubtask->sub_task_assign->designation}}</td>
                        <td>{{$isubtask->sub_task_creator->name}} | {{$isubtask->sub_task_creator->designation}} </td>
                        <td>Completed </td>

                    </tr>
                        @endforeach
                        @elseif(auth()->user()->hasPermissionTo('supervisor_stats'))
                        @foreach($enduser_completedsubtask as $isubtask)
                    <tr>
                    <td> <a href="{{ route('task.subtask_list', ['id' => $isubtask->task->id ?? '#']) }}"> {{ $isubtask->task->title ?? '' }} </a></td>
<td><a href="{{ route('task.activity', ['id' => $isubtask->id]) }}"> {{ $isubtask->name ?? '#' }} </a></td>


                        <td>{{$isubtask->due_date}}</td>
                       
                        <td>{{$isubtask->created_at}}</td>
                        <td>{{$isubtask->sub_task_assign->name ?? ''}} | {{$isubtask->sub_task_assign->designation ?? ''}}</td>
                        <td>{{$isubtask->sub_task_creator->name ?? ''}} | {{$isubtask->sub_task_creator->designation ?? ''}} </td>
                        <td>Completed </td>

                    </tr>
                        @endforeach
                        @endif
                        <!-- Additional loop for $alltask  -->
                      
                        
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
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>


<script>
    $(document).ready(function() {

        // Add click event handler for delete buttons with class 'delete-subtask'
        $('#subtaskTable').on('click', '.delete-subtask', function(event) {
            event.preventDefault(); // Prevent the default behavior (e.g., navigating to the delete URL)
            var subtaskId = $(this).data('subtask-id');
            // Show a confirmation alert
            if (confirm('Are you sure you want to delete this SubTask?')) {
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



            var totalDurationHours = Math.floor(totalDurationMinutes / 60);
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

        function loadProgressForFirstTask() {
            // Fetch progress value for the first task from the server
            var firstTaskId = $('#taskSelect option:first').val();

            $.ajax({
                url: '{{ route("subtask.getTaskProgress") }}',
                method: 'GET',
                data: {
                    taskId: firstTaskId
                },
                success: function(response) {
                    // Update the progress slider with the fetched progress value
                    $('#progressSliderModal').slider('setValue', response.progress);
                },
                error: function(error) {
                    console.error('Error fetching task progress:', error);
                }
            });
        }

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
        $('#progressSliderModal').on('slideStop', function(slideEvt) {
            var newProgress = slideEvt.value;

            // Check if the new progress is greater than or equal to the current progress
            if (newProgress >= currentProgress) {
                // Update the current progress value
                newProgress = newProgress;
            } else {
                // If the new progress is less than the current progress, revert to the current progress
                $('#progressSliderModal').slider('setValue', currentProgress);
            }
        });


        // Fetch data-task-id when the modal is opened
        $('#addActivityModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var taskId = button.data('task-id'); // Extract info from data-* attributes
            var taskTitle = button.data('task-title'); // Extract info from data-* attributes
            var subtaskId = button.data('subtask-id'); // Extract subtaskId from data-* attribute
            var subtaskName = button.data('subtask-name'); // Extract subtaskId from data-* attribute

            // Update the element within the modal with the taskId

            $('#taskId').val(taskId);
            $('#taskTitle').val(taskTitle);
            $('#subtaskId').val(subtaskId);
            $('#subtaskName').val(subtaskName);

            console.log(subtaskName);
            console.log(taskId);

            console.log(subtaskId); // You can use this taskId variable as per your requirement
        });

        // User filter change event handler
        $('#userFilter').on('change', function() {
            var selectedUserId = $(this).val();
            // alert(table.columns(8));

            // Show all rows if no user is selected
            if (selectedUserId === '') {
                table.columns(4).search('').draw();
            } else {
                // Filter the table based on the selected user's ID
                table.columns(4).search(selectedUserId).draw();
            }
            // Update total duration
            updateTotalDuration();
        });

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






        // Initialize progress slider for the modal
        $('#progressSliderModal').slider({
            formatter: function(value) {
                return 'Current value: ' + value;
            }
        });
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
</script>
@endsection