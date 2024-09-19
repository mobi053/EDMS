@extends('portal.layout.appsubtask')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>SubTasks</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('task.index')}}">Task</a></li>
                    <li class="breadcrumb-item active">SubTask</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-info card-outline">

        <!---total duration black box---->
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class=text-center style="padding-top: 15px;;">Total Time </h3>
            </div>
            <div class="col-md-6 col-xl-3 col-xxl-3">
                <div class="clock-container justify-content-center bg-info">
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


        <div class="card-header d-flex justify-content-end">


            @if(auth()->user()->hasPermissionTo('view_allactivities'))

            <select class="form-control d-inline-block col-2 mr-1 modalsearch" id="departmentFilter" onchange="updatetaskOptions()">
                <option value="">All Department</option>
                @foreach($department as $departments)
                <option value="{{ $departments->id }}">{{ $departments->name }}</option>
                @endforeach
            </select>

            <select class="form-control d-inline-block col-1 mr-1 modalsearch" id="userFilter">
                <option value="">All Users</option>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} | {{ $user->designation }}</option>
                @endforeach
            </select>

            <!--for admin to show all tasks in filter--->
            <select class="form-control d-inline-block col-1 mr-1 modalsearch" id="taskFilter">
                <option value="">All Tasks</option>
                @foreach($tasks as $task)
                <option value="{{ $task->id }}">{{ $task->title }}</option>
                @endforeach
            </select>

           

            <!---end admin like MD filter---->
            <!---Department wise Filters--->
            @elseif(auth()->user()->hasPermissionTo('department_head'))
            <select class="form-control d-inline-block col-1 mr-1 modalsearch" id="userFilter">
                <option value="">Assigned To</option>
                @foreach($department_wise_users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} | {{ $user->designation }}</option>
                @endforeach
            </select>

            <select class="form-control d-inline-block col-1 mr-1 modalsearch" id="taskFilter">
            <option value="">All Tasks</option>
                @foreach($department_wise_tasks as $task)
                <option value="{{ $task->id }}">{{ $task->title }}</option>
                @endforeach
            </select>

          
            <!----end department wise filters---->
            <!---filters for end users---->
            @else
            <!--for specific user to show his task and collaborator task in filter--->
            @if($subordinate->isNotEmpty())
            <select class="form-control d-inline-block col-1 mr-1 modalsearch" id="userFilter">
                <option value="">Assigned To</option>
                @foreach($subordinate as $user)
                <option value="{{ $user->id }}">{{ $user->name }} | {{ $user->designation }}</option>
                @endforeach
            </select>
            @endif

            <select class="form-control d-inline-block col-1 mr-1 modalsearch" id="taskFilter">
            <option value="">All Tasks</option>
                @foreach($alltask as $task)
                <option value="{{ $task->id }}">{{ $task->title }}</option>
                @endforeach
            </select>
           


            <!---end---->
            @endif

            <select class="form-control d-inline-block col-1 mr-1" id="statusFilter">
                <option value="">Subtask Status</option>
                <option value="0">In Progress</option>
                <option value="1">Completed</option>
                <option value="3">Not Started Yet</option>
                <option value="2">On Hold</option>
                <option value="4">Cancelled</option>
                <option value="6">Pending</option>
            </select>
            <button type="button" class="btn btn-default mr-1" id="daterange-btn">
                <i class="far fa-calendar-alt"></i>
                <span>Filters</span>
                <i class="fas fa-caret-down"></i>
            </button>
            @if(auth()->user()->hasPermissionTo('create_subtask'))
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addActivityModal">
                Add Subtask
            </button>

            @endif

            <!-- <label for="userSearch">Search by User:</label>
                    <input type="text" class="form-control" id="userSearch" placeholder="Enter user name"> -->
        </div>

        <!-- Add these input fields within the Add Activity Modal in your view -->


        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="subtaskTable">
                    <thead>
                        <tr>
                            <th>ID </th>
                            <th>Task Name</th>
                            <th>Subtask Name</th>
                            <th>Task Due Date</th>
                            <th>Created At</th>
                            <th style="width: 7%;">Estimated Time (hrs)</th>
                            <th style="width: 7%;">Time Spent (hrs)</th>
                            <th>Subtask Creator</th>
                            <th>Subtask Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <!-- Add Subtask Modal -->
        <div class="modal fade" id="addActivityModal" tabindex="" role="dialog" aria-labelledby="addActivityModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addActivityModalLabel">Add Subtask</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('subtask.store') }}" method="POST" role="form" enctype="multipart/form-data" id="AddSubtaskForm">
                            @csrf
                      

                            <div class="form-group">
                                <label for="task_title">Task*</label>
                                <select name="task" id="task_title" class="form-control select3" required>
                                    <option value="">Please Select a Task</option>
                                    @foreach($alltask as $task)
                                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                           


                            <div class="form-group">
                                <label for="subtaskName">Subtask Name *</label>
                                <input type="text" class="form-control" required name="name" value="{{ old('name') }}" id="subtaskName" placeholder="Name" oninput="restrictSpecialChars(this)">
                            </div>
                            <div class="form-group">
                                <label for="description">Subtask Description *</label>
                                <textarea class="form-control" rows="3" required name="description" id="description" placeholder="Description" oninput="restrictSpecialChars(this)">{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group d-none">
                                <label for="start_datetime">Start Time/Date *</label>
                                <input type="datetime-local" class="form-control" name="start_datetime" id="start_datetime" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i') }}" placeholder="Start Time/Date">
                            </div>
                            <div class="form-group d-none">
                                <label for="end_datetime">End Time/Date *</label>
                                <input type="datetime-local" class="form-control" name="end_datetime" id="end_datetime" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i') }}" placeholder="End Time/Date">
                            </div>
                            <div class="form-group">
                                <label for="duration">Estimated Time (hrs) *</label>
                                <input type="number" class="form-control" required name="estimated_time" id="duration" placeholder="Estimated Time (hrs)" min="0.5" step="0.5">
                            </div>
                            <div class="form-group d-none">
                                <label for="due_date">Due Date</label>
                                <input type="date" class="form-control" name="due_datetime" id="due_date" placeholder="Due Date">
                            </div>
                            @if(auth()->user()->department_type==1)
                            <div class="form-group">
                                <label>Access Level</label>
                                <select name="deptops_global" class="form-control">
                                    <option value="">Visible to me only</option>
                                    <option value="2">Visible to My department</option>
                                    <option value="1">Visible to All departments</option>

                                </select>
                            </div>
                            @endif
                            <div class="form-group">
                                <label for="status">Subtask Status *</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="0">In Progress</option>
                                    <option value="6">Pending</option>
                                    <option value="2">On Hold</option>
                                    <option value="3">Not Started Yet</option>
                                    <option value="4">Cancelled</option>
                                </select>
                            </div>
                            <div class="form-group d-none">
                                <label for="task_status">Task Status</label>
                                <select class="form-control" name="task_status" id="task_status">
                                    <option value="">Please Select Task Status</option>
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
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="addSubtaskButton">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End of Add Subtask Modal -->


        <!-- Edit Log Time Modal -->
        <div class="modal fade" id="editLogTimeModal" tabindex="-1" role="dialog" aria-labelledby="editLogTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editLogTimeModalLabel">Edit Log Time</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('activity.editLogTime')}}" method="POST" role="form" enctype="multipart/form-data" id="editLogTimeForm">
                    @csrf
                    <div class="form-group">
                        <label for="taskTitlelog">Task *</label>
                        <input type="text" class="form-control" id="taskTitlelog" readonly>
                        <!-- <input type="hidden" name="task" id="taskId"> -->
                    </div>
                    <div class="form-group">
                        <label for="subtaskNametlog">Subtask Name</label>
                        <input type="text" class="form-control" id="subtaskNametlog" readonly>
                        <!-- <input type="hidden" name="subtask" id="subtaskId"> -->
                    </div>
                    <div class="form-group">
                        <label for="activityId">Activity ID</label>
                        <input type="text" class="form-control" id="activityId" readonly>
                        <input type="hidden" name="activity" id="activityIdHidden">
                    </div>
                    <div class="form-group">
                        <label for="created_at">Created At</label>
                        <input type="datetime-local" name="created_at" class="form-control" id="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submitButtonforeditLogTime">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        <!-- End of Edit Log Time Modal -->

        <!-- Log Time Modal -->
        <div class="modal fade" id="LogTimeModal" tabindex="-1" role="dialog" aria-labelledby="LogTimeModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="LogTimeModalLabel">Log Time </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>



                    </div>
                    <div class="modal-body">
                        <form action="{{route('activity.store')}}" method="POST" role="form" enctype="multipart/form-data" id="LogTimeForm">
                            @csrf
                            <div class="form-group ">
                                <label for="Name">Task *</label>

                                <input type="text" class="form-control" id="taskTitle" readonly>
                                <input type="text" name="task" id="taskId" class="form-control " hidden>

                            </div>

                            <div class="form-group">
                                <label for="Name"> Subtask Name</label>
                                <input type="text" class="form-control" id="subtaskNamet" readonly>
                                <input type="text" name="subtask" id="subtaskId" class="form-control " hidden>

                            </div>
                            <!-- <div class="form-group">
                                <label for="Name">Activity Name *</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="Name" placeholder="Name">
                            </div> -->
                            <div class="form-group">
                                <label>Remarks *</label>
                                <textarea class="form-control" rows="3" name="sub_description" placeholder="Description" required oninput="restrictSpecialChars(this)">{{ old('sub_description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="Name"> Time Spent(hrs)*</label>
                                <input type="number" name="duration" id="durationt" class="form-control" min="0.5" step="0.5" required>

                                <input type="text" name="subtaskestimated" id="subtaskestimatedt" class="form-control d-none" value="">
                                <input type="text" name="subduration" id="subdurationt" class="form-control d-none" value="">
                            </div>

                            <div>

                                <label for="Name"> More Time Required (hrs)</label>
                                <input type="text" name="moreDuration" id="moreDurationt" class="form-control">
                            </div>


                            <div class="form-group">
                                <label for="Name"> Remaining Time (hrs) </label>
                                <input type="text" name="remainingtime" id="remainingtimet" class="form-control " value="{{$subtask->remaining_time ?? ''}}" readonly>

                            </div>
                            <!-- <div class="form-group d-none">
                                <label for="Name"> Time Remaining</label>
                                <input type="text" name="subtask" id="duration" class="form-control ">
                            </div> -->
                            <div class="form-group d-none">
                                <label for="dueDateTime">Start Time/Date *</label>
                                <input type="datetime-local" class="form-control" name="start_datetime" id="start_datetime" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i') }}" placeholder="Start Time/Date">
                            </div>
                            <div class="form-group d-none">
                                <label for="dueDateTime">End Time/Date *</label>
                                <input type="datetime-local" class="form-control" name="end_datetime" id="end_datetime" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i') }}" placeholder="Start Time/Date">
                            </div>
                           
                            <div class="form-group">
                                <label>Subtask Status*</label>
                                <select class="form-control " name="subtask_status" id="status" required>
                                    <option value="">Please select Subtask status below </option>
                                    <option value="1">Completed</option>
                                    <option value="0">In progress</option>
                                    <option value="2">On Hold</option>
                                    <option value="3">Not Started Yet</option>
                                </select>
                            </div>

                            @if (auth()->user()->department==2)
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="checkbox" id="customCheckbox1" value="checkbox">
                                <label for="customCheckbox1" class="custom-control-label">Click on the checkbox if doing double shift in night!!!</label>
                                </div>
                             </div>
                             @endif

                            <div class="form-group">

                                <label>File </label>

                                <!-- <input type="file" class="form-control-file" id="attachment_file" name="attachment_file" accept="image/*,video/*" required /> -->

                                <!-- <input type="file" multiple  class="form-control-file" id="attachment_file" name="attachment_file[]" accept="image/*,video/*,.pdf,.doc,.txt" required /> -->
                                <input type="file" class="form-control-file" id="attachment_file" name="attachment_file[]" accept="image/*,video/*,.pdf,.doc,.txt" multiple />



                                <small class="form-text text-muted">File size must be less than 5MB.</small>

                            </div>
                          
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submitButton">Add</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- End of Log Time Modal -->


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

<!-- script for Log Time -->
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script type="text/javascript">
$(document).ready(function() {
    function updateTotalDuration(totalTime) {
            //var table = $('#subtaskTable').DataTable();
            var totalDurationHours = totalTime/60; // Initialize total duration in hours
            // Separate hours and minutes
            var totalDurationHoursFloor = Math.floor(totalDurationHours);
            var remainingMinutes = Math.round((totalDurationHours - totalDurationHoursFloor) * 60); // Convert remaining fraction to minutes
            // Update the total duration in the new div
            document.querySelector('.clock-hours').innerText = totalDurationHoursFloor;
            document.querySelector('.clock-minutes').innerText = remainingMinutes;
            // console.log("Total Duration: ", totalDurationHoursFloor, " Hours ", remainingMinutes, " Minutes");
        }
    // Initialize the DataTable
    let globalStartDate, globalEndDate;
    var table = $('#subtaskTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('subtask.list') }}",
            data: function(d) {
                d.department = $('#departmentFilter').val(); 
                d.created_by = $('#userFilter').val(); // Include the selected user's value
                d.title = $('#taskFilter').val();
                d.subtask = $('#subtaskFilter').val();
                
                d.status = $('#statusFilter').val();
                d.sDate=globalStartDate;
                d.eDate=globalEndDate;
                // Retrieve the start and end dates separately
                // console.log("----------->", d.sDate)
            }
        },
        responsive: true,
        columns: [
            { data: 'id' },
            { data: 'task_title' },
            { data: 'subtask_name' },
            { data: 'task_duedate' },
            { data: 'subtask_created_at' },
            { data: 'estimated_time' },
            { data: 'time_spent' },
            { data: 'subtask_creator' },
            { data: 'status' },
            { data: 'action', orderable: false }
        ],
        order: [[0, 'asc']],
        rowCallback: function(row, data) {
            if (data.rowClass) {
                $(row).addClass(data.rowClass);
            }
        },
        fnDrawCallback: function(oSettings) {
            var api = this.api();
            var data = api.ajax.json();
            var totalTime = data.totalTime; // Access totalTime from the response

            // Manipulate or display totalTime as needed
            console.log('Total Time:', totalTime);
            updateTotalDuration(totalTime)
        }
    });

    // Event listener for the custom filter
    $('#departmentFilter, #userFilter, #taskFilter, #subtaskFilter, #statusFilter').on('change', function() {
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


        // Function to update total duration

        var remainingTimeInitialValue = 0;

        function updateTotalDurationt() {
            var durationValue = parseFloat($('#durationt').val()) || 0; // Get value of duration input
            var subDurationValue = parseFloat($('#subdurationt').val()) || 0; // Get value of subduration input
            var subtaskestimatedValue = parseFloat($('#subtaskestimatedt').val()) || 0;
            var moreDurationValue = parseFloat($('#moreDurationt').val()) || 0;
            //$('#moreDuration').val(moreDurationValue);
            let u = parseFloat($('#moreDurationt').val()) || 0;
            var totalDuration = durationValue + subDurationValue; // Calculate total duration
            $('#totalDurationt').val(totalDuration); // Update total duration input field
         
            var remainingTimeUpdatedValue = remainingTimeInitialValue - durationValue + u;
            // var remainingTimeUpdatedValue = subtaskestimatedValue - subDurationValue - durationValue + u ;
            $('#remainingtimet').val(remainingTimeUpdatedValue);
        }

        // Call the function initially to calculate the initial total duration
        updateTotalDurationt(); // Update it later on

        //Listen for changes in the duration and subduration input fields
        $('#durationt, #subdurationt, #moreDurationt, #remainingtimet').on('input', function() {
            updateTotalDurationt(); // Update total duration when input changes
        });

        // Fetch data-task-id when the modal is opened
        $('#LogTimeModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var taskId = button.data('task-id'); // Extract info from data-* attributes
            var taskTitle = button.data('task-title'); // Extract info from data-* attributes
            var subtaskId = button.data('subtask-id'); // Extract subtaskId from data-* attribute
            var subtaskName = button.data('subtask-name'); // Extract subtaskId from data-* attribute
            var subtaskestimated = button.data('subtask-estimated');
            var subduration = button.data('subtask-subduration');
            var remainingtime = button.data('subtask-remainingtimet');
            remainingTimeInitialValue = remainingtime;

            // Update the element within the modal with the taskId

            $('#taskId').val(taskId);
            $('#taskTitle').val(taskTitle);
            $('#subtaskId').val(subtaskId);
            $('#subtaskNamet').val(subtaskName);
            $('#subtaskestimatedt').val(subtaskestimated);
            $('#subdurationt').val(subduration);
            $('#remainingtimet').val(remainingtime);



            console.log(taskTitle);
            console.log(taskId);
            console.log(subtaskName);
            console.log(subtaskId); // You can use this taskId variable as per your requirement
            console.log("Estimated Time", subtaskestimated);
            console.log("Spent Time", subduration); //Total spent duration
            console.log("Remaining Time", remainingtime); //Total spent duration

        });
        
        $('.select3').select2();


    });
</script>
<script>
    $(document).ready(function() {
        //Edit Log Tim
        // Edit Log Time button click event
            $('#subtaskTable').on('click', '.edit-logtime-btn', function() {
                //data-toggle="modal" data-target="#editLogTimeModal" 
                //alert('asfjafkb')
                console.log(this)
                var taskId = $(this).data('tasklog-id');
                var taskTitle = $(this).data('tasklog-title');
                var subtaskId = $(this).data('subtasklog-id');
                var subtaskName = $(this).data('subtasklog-name');
                var activityId = $(this).data('activitylog-id');

                // Set the values in the modal fields
                $('#taskTitlelog').val(taskTitle);
                $('#taskId').val(taskId);
                $('#subtaskNametlog').val(subtaskName);
                $('#subtaskId').val(subtaskId);
                $('#activityId').val(activityId);
                $('#activityIdHidden').val(activityId);  // Set the hidden field for form submission

                console.log('Task ID:', taskId);
                console.log('Task Title:', taskTitle);
                console.log('Subtask ID:', subtaskId);
                console.log('Subtask Name:', subtaskName);
                console.log('Activity ID:', activityId);
            });

            // Prevent form submission for debugging (remove/comment this out when ready for production)
            $('#LogTimeForm').on('submit', function(e) {
                e.preventDefault();
                console.log('Form Submitted');
                console.log($(this).serialize());
            });
        //End of Edit Log Time

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
           

            // Populate any necessary fields in the modal
            $('#addActivityModal input[name="task"]').val(taskId);
            $('#addActivityModal').modal('show');
        });

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

       

        // Fetch data-task-id when the modal is opened
        $('#addActivityModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var taskId = button.data('task-id'); // Extract info from data-* attributes
            var taskTitle = button.data('task-title'); // Extract info from data-* attributes
            var subtaskId = button.data('subtask-id'); // Extract subtaskId from data-* attribute
            var subtaskName = button.data('subtask-name'); // Extract subtaskId from data-* attribute

            // Update the elements within the modal with the extracted data
            $('#task').val(taskId);
            $('#task_title').val(taskTitle);
            $('#subtaskId').val(subtaskId);
            $('#subtaskName').val(subtaskName);

            console.log('Task ID:', taskId);
            console.log('Task Title:', taskTitle);
            console.log('Subtask ID:', subtaskId);
            console.log('Subtask Name:', subtaskName);
        });
      
    });
</script>

<script>
    function restrictSpecialChars(input) {
        // Define the allowed characters: letters, numbers, spaces, hyphens, commas, periods, ampersands, at symbols, plus signs, question marks, parentheses, square brackets, curly brackets, percentage signs, and double quotes
        const regex = /^[a-zA-Z0-9\s\-.,&@+?()\[\]{}%="]*$/;

        // If the value doesn't match the allowed characters, replace the value with the filtered value
        if (!regex.test(input.value)) {
            input.value = input.value.replace(/[^a-zA-Z0-9\s\-.,&@+?()\[\]{}%="]/g, '');
        }
    }


    function handleFormSubmit(formId, buttonId) {
    document.getElementById(formId).addEventListener('submit', function(event) {
        event.preventDefault();  // Prevent the form from submitting immediately

        const button = document.getElementById(buttonId);
        button.disabled = true;

        setTimeout(function() {
            button.disabled = false;
            // Optionally, you can submit the form here after 5 seconds
            // document.getElementById(formId).submit(); 
        }, 30000);

        // Submit the form immediately after disabling the button
        document.getElementById(formId).submit();
    });
}

// Handle LogTimeForm submission and modal
handleFormSubmit('LogTimeForm', 'submitButton');
// Handle AddSubtaskForm submission and modal
handleFormSubmit('AddSubtaskForm', 'addSubtaskButton');
handleFormSubmit('editLogTimeForm', 'submitButtonforeditLogTime');





  

</script>
<script>
    function updatetaskOptions() {
        var departmentFilter = document.getElementById("departmentFilter");
        var taskFilter = document.getElementById("taskFilter");
        var department = departmentFilter.value;

        userFilter.innerHTML = "<option value=''>All Users</option>";

        // Add tasks corresponding to the selected department
        @foreach($department as $departments)
        if ("{{ $departments->id }}" === department || department === "") {
            @foreach($departments -> users as $user)
            var option = document.createElement("option");
            option.value = "{{ $user->id }}";
            option.textContent = "{{ $user->name }}";
            userFilter.appendChild(option);
            @endforeach
        }
        @endforeach

        // Clear existing options
        taskFilter.innerHTML = "<option value=''>All Tasks</option>";

        // Add tasks corresponding to the selected department
        @foreach($department as $departments)
        if ("{{ $departments->id }}" === department || department === "") {
            @foreach($departments -> tasks as $task)
            var option = document.createElement("option");
            option.value = "{{ $task->id }}";
            option.textContent = "{{ $task->title }}";
            taskFilter.appendChild(option);
            @endforeach
        }
        @endforeach

     
    }
</script>
@endsection