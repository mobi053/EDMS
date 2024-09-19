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
                    <!-- <li class="breadcrumb-item"><a href="#">Projects</a></li> -->
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
            @if(auth()->user()->hasPermissionTo('view_alltasks'))
            <select class="form-control d-inline-block col-1 mr-1" id="userFilter">
                <option value="">Assigned To</option>
                @foreach($users as $user)
                <option value="{{ $user->name }} | {{$user->designation}}">{{ $user->name }} | {{$user->designation}}</option>
                @endforeach
            </select>

            <select class="form-control d-inline-block col-1 mr-1" id="taskFilter">
                <option value="">All Tasks</option>
                @foreach($tasks as $task)
                <option value="{{ $task->title }}">{{ $task->title }}</option>
                @endforeach
            </select>
            @else

            @endif
            <select class="form-control d-inline-block col-1 mr-1" id="priorityFilter">
                <option value="">Priority</option>

                <option value="High">High</option>
                <option value="Medium">Medium</option>
            </select>

            <button type="button" class="btn btn-default  mr-1" id="daterange-btn">
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
            <table class="table table-bordered" id="taskTable">
                <thead>
                    <tr>
                        <th> Sr. </th>
                        <th> Title </th>
                        <th> Due Date </th>
                        <th style="display: none;"> Description </th>
                        <th> Priority </th>
                        <!-- <th> Project </th> -->
                        <th> Progress </th>
                        <th> Created At </th>
                        <th> Assigned to </th>
                        <th> Assigned by </th>
                        <th> Actions </th>
                    </tr>
                </thead>
                <tbody>


                    @if(auth()->user()->hasPermissionTo('view_alltasks'))
                    @php
                    $serialNumber = 1;
                    @endphp
                    @foreach($tasks as $task)
                    <tr data-user-id="{{$task->task_creator->id}}">
                        <td>{{$serialNumber++}}</td>
                        <td> <a href="{{ route('task.subtask_list', ['id' => $task->id]) }}"> {{$task->title}} </a></td>
                        <td>{{$task->duedate}}</td>
                        <td style="display: none;">{{$task->description}}</td>
                        <td>{{$task->priority}}</td>
                        <td>{{$task->progress}}</td>
                        <td>{{$task->created_at}}</td>
                        <td>{{$task->task_manager->name}} | {{$task->task_manager->designation}}</td>
                        <td>
                            {{$task->task_creator->name}} | {{$task->task_creator->designation}} 
                        </td>
                        <td>
                            <!-- Add actions/buttons for the new column -->
                            <a href="{{ route('task.subtask_list', ['id' => $task->id]) }}" class="mr-1 text-blue" title="View"><i class="fa fa-eye"></i> </a>          
                            @can('edit_task', $task)
                            @if(auth()->user()->id==$task->task_creator->id)
                            <a href="{{ route('task.edit', ['id' => $task->id]) }}" class="mr-1 text-info" title="Edit"><i class="fa fa-edit"></i> </a>
                            @endif
                            @endcan

                            @can('delete_task', $task)
                            @if(auth()->user()->id==$task->task_creator->id)
                            <a href="{{ route('task.delete', ['id' => $task->id]) }}" class="mr-1 text-danger delete-task" title="Cancel" data-task-id="{{ $task->id }}">
                                <i class="fa fa-times"></i>

                            </a>
                            @endif
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                    @else
                    @php
                    $serialNumber = 1;
                    @endphp
                    @foreach($usertask as $task)
                    <tr data-user-id="{{$task->task_creator->id}}">
                        <td>{{$serialNumber++}}</td>
                        <td> <a href="{{ route('task.subtask_list', ['id' => $task->id]) }}"> {{$task->title}} </a></td>
                        <td>{{$task->duedate}}</td>
                        <td style="display: none;">{{$task->description}}</td>
                        <td>{{$task->priority}}</td>
                        <td>{{$task->progress}}</td>
                        <td>{{$task->created_at}}</td>
                        <td>{{$task->task_manager->name}} | {{$task->task_manager->designation}}</td>
                        <td>
                            {{$task->task_creator->name}} | {{$task->task_creator->designation}} 
                        </td>
                        <td>
                            <!-- Add actions/buttons for the new column -->
                            <a href="{{ route('task.subtask_list', ['id' => $task->id]) }}" class="mr-1 text-blue" title="View"><i class="fa fa-eye"></i> </a>          
                            @can('edit_task', $task)
                            @if(auth()->user()->id==$task->task_creator->id)
                            <a href="{{ route('task.edit', ['id' => $task->id]) }}" class="mr-1 text-info" title="Edit"><i class="fa fa-edit"></i> </a>
                            @endif
                            @endcan

                            @can('delete_task', $task)
                            @if(auth()->user()->id==$task->task_creator->id)
                            <a href="{{ route('task.delete', ['id' => $task->id]) }}" class="mr-1 text-danger delete-task" title="Cancel" data-task-id="{{ $task->id }}">
                                <i class="fa fa-times"></i>

                            </a>
                            @endif
                            @endcan

                        </td>
                    </tr>
                    @endforeach
                    @endif

                </tbody>
            </table>
        </div>
        <!-- Role Grant Modal -->
        <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskModalLabel">Add Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('task.store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="Title">Title*</label>
                                <input type="text" class="form-control" name="title" value="{{ old('title') }}" id="Title" placeholder="Title">
                            </div>
                            <div class="form-group">
                                <label>Description*</label>
                                <textarea class="form-control" rows="3" name="Description" placeholder="Description">{{ old('Description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="dueDate">Due Date</label>
                                <input type="text" class="form-control" name="dueDate" id="dueDate" placeholder="Due Date">
                            </div>
                            <div class="form-group">
                                <label>Priority</label>
                                <select name="priority" class="form-control">
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <!--<label>Project</label> -->
                                <select style="display:none;" name="project" class="form-control">
                                    @foreach($projects as $project)
                                    <option value="{{$project->id}}">{{$project->name}} | {{$project->location}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Assigned to</label>
                                <select name="assigned_to" class="form-control">
                                    @foreach($userassign as $userassigned)
                                    <option value="{{$userassigned->id}}">{{$userassigned->name}} | {{$userassigned->designation}} | {{$userassigned->employee_id}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <!-- <label>Collaborators</label> -->
                                
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="collaboratorDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Select Collaborators
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="collaboratorDropdown">
                                    @foreach($userassign as $userassigned)
                                            <div class="dropdown-item">
                                                <input type="checkbox" name="collaborators[]" value="{{$userassigned->id}}" id="collaborator{{$userassigned->id}}">
                                                <label for="collaborator{{$userassigned->id}}">{{$userassigned->name}} | {{$userassigned->designation}} | {{$userassigned->employee_id}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
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

        // Add click event handler for delete buttons with class 'delete-task'
        $('.delete-task').on('click', function(event) {
            event.preventDefault(); // Prevent the default behavior (e.g., navigating to the delete URL)

            var taskId = $(this).data('task-id');

            // Show a confirmation alert
            if (confirm('Are you sure you want to delete this task?')) {
                // If user clicks 'OK', proceed with the deletion
                window.location.href = "{{ url('/admin/task/delete') }}/" + taskId;
            }
        });

        // Initialize DataTable
        
    // Initialize DataTable with column-specific options
    var table = $('#taskTable').DataTable({
        columnDefs: [
            { targets: [1, 2, 3, 4, 5, 6, 7, 8, 9], orderable: false } // Set orderable to false for all columns except the 1st column
        ]
    });

        

        // Apply filter when user selects a value from the userFilter dropdown
        $('#userFilter').on('change', function() {
            var filterValue = $(this).val();
            table.column(7).search(filterValue).draw();
        });

        // DataTables date range filtering function
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex, startDatetime, endDatetime) {
                startDatetime = $('#daterange-btn').data('daterangepicker').startDate.format('YYYY-MM-DD HH:mm:ss');
                endDatetime = $('#daterange-btn').data('daterangepicker').endDate.format('YYYY-MM-DD HH:mm:ss');
                var activityCreatedAt = data[6]; // Assuming Activity Created At is in the 8th column

                if ((startDatetime === '' && endDatetime === '') ||
                    (startDatetime === '' && activityCreatedAt <= endDatetime) ||
                    (startDatetime <= activityCreatedAt && endDatetime === '') ||
                    (startDatetime <= activityCreatedAt && activityCreatedAt <= endDatetime)) {
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
        // Apply filter when user selects a value from the taskFilter dropdown
        $('#taskFilter').on('change', function() {
            var filterValue = $(this).val();
            table.column(1).search(filterValue).draw();
        });
        $('#priorityFilter').on('change', function() {
            var filterValue = $(this).val();
            table.column(4).search(filterValue).draw();
        });
    });
</script>
<script>
    $(function() {
        $('#dueDate').daterangepicker({
            singleDatePicker: true,
        });
    });
</script>


@endsection