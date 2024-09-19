@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Projects</h1>
               
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{'dashboard'}}">Home</a></li>
                    <li class="breadcrumb-item active">Projects</li>
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
            @if(auth()->user()->hasPermissionTo('view_allproject'))
            <!-- Select dropdown for department filter -->
            <!-- <select class="form-control d-inline-block col-2 mr-1" id="departmentFilter">
    <option value="">All Departments</option>
    @foreach($categories as $department)
        <option value="{{ $department->name }}">{{ $department->name }}</option>
    @endforeach
</select> -->

            <!-- Checkboxes for department filter -->
            <div class="dropdown " style="margin-right: 5px;">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="departmentDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Departments
                </button>
                <div class="dropdown-menu" aria-labelledby="departmentDropdown" style="padding: 0px 9px;">
                    <a class="dropdown-item" href="#" id="selectAllDepartments">Select All</a>
                    <a class="dropdown-item" href="#" id="deselectAllDepartments">Deselect All</a>
                    <div class="dropdown-divider"></div>
                    @foreach($allcategories as $department)
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input departmentCheckbox" id="department_{{ $department->id }}" value="{{ $department->name }}" data-department="{{ $department->name }}">
                        <label class="form-check-label" for="department_{{ $department->id }}">{{ $department->name }}</label>
                    </div>
                    @endforeach
                </div>

            </div>


            <div class="dropdown" style="margin-right: 5px;">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="projectDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Projects
                </button>
                <div class="dropdown-menu" aria-labelledby="projectDropdown">
                    @foreach($allprojects as $proj)
                    <label class="dropdown-item"><input type="checkbox" class="project-filter" value="{{ $proj->name }}" data-project="{{ $proj->name }}"> {{ $proj->name }}</label>
                    @endforeach
                </div>
            </div>


            @endif
            <!-- Checkboxes for department filter -->


            @if(auth()->user()->hasPermissionTo('create_project'))

            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addProjectModal">
                Add Project
            </button>
            @endif

        </div>
        <div class="card-body">
            <table class="table table-bordered" id="taskTable" width="100%">
                <thead>
                    <tr>
                        <th> Sr. </th>
                        <th> Project Name </th>
                        <th> Location </th>
                        <th> Start Date </th>
                        <th> Due Date </th>

                        <th> Department </th>
                        <th> Status </th>
                        <th> Owner </th>
                        <th> Created by </th>
                        <th> Actions </th>
                    </tr>
                </thead>
                <tbody>
                    @if(auth()->user()->hasPermissionTo('view_allproject'))
                    @foreach($allprojects as $proj)
                    <tr @if($proj->status==6) style="background-color: #999; color:#fff" @endif>
                        <td>{{$loop->iteration}}</td>
                        <td> <a @if($proj->status==6) style="color: #fff;" @endif href="{{ route('project.task_list', ['id' => $proj->id]) }}"> {{$proj->name}} </a></td>
                        <td> {{$proj->location}}</td>
                        <td>{{$proj->start_date}} </td>
                        <td>{{$proj->due_date}} </td>
                        <td>{{$proj->project_category->name}} </td>
                        <td>@if($proj->status==1) Completed
                            @elseif($proj->status==2) Owned
                            @elseif($proj->status==3) In Progress
                            @elseif($proj->status==4) Blocked
                            @elseif($proj->status==5) On Hold
                            @elseif($proj->status==6) Cancelled
                            @elseif($proj->status==7) Approved @endif </td>
                        <td>{{$proj->project_manager->name ?? ''}} </td>
                        <td>{{$proj->createdByUser->name ?? ''}} </td>
                        <td>
                            <a href="{{ route('project.edit', ['id' => $proj->id]) }}" class="mr-1 text-info" title="Edit"><i class="fa fa-edit"></i> </a>
                            <a href="{{ route('project.task_list', ['id' => $proj->id]) }}" class="mr-1 text-blue" title="View Project"><i class="fa fa-eye"></i> </a>

                            @if(in_array($proj->status, [1,4,6]))

                          
                            @else
                            @if(auth()->user()->hasPermissionTo('create_task'))
                            <a href="#" class="mr-1 text-success add-activity-btn" title="Add Task" data-task-id="{{ $proj->id }}" data-task-progress="{{ $proj->id }}" data-task-title="{{ $proj->name}}" title="Add Task"><i class="fa fa-plus"></i> </a>
                            @endif

                            <!-- <a href="{{ route('project.task_list', ['id' => $proj->id]) }}" class="mr-1 text-blue" title="View Project"><i class="fa fa-eye"></i> </a> -->
                           
                            @if($proj->status != 6)
                            <a href="{{ route('project.delete', ['id' => $proj->id]) }}" class="mr-1 text-danger delete-task" title="Cancel" data-task-id="{{ $proj->id }}">
                                <i class="fa fa-times"></i>
                            </a>
                            @endif
                          
                            @endif

                        </td>
                    </tr>
                    @endforeach
                    @elseif(auth()->user()->hasPermissionTo('view_project'))
                    @foreach($projects as $proj)
                    <tr @if($proj->status==6) style="background-color: #999; color:#fff" @endif>
                        <td>{{$loop->iteration}}</td>
                        <td> <a @if($proj->status==6) style="color: #fff;" @endif href="{{ route('project.task_list', ['id' => $proj->id]) }}"> {{$proj->name}} </a></td>
                        <td> {{$proj->location}}</td>
                        <td>{{$proj->start_date}} </td>
                        <td>{{$proj->due_date}} </td>
                        <td>{{$proj->project_category->name}} </td>
                        <td>@if($proj->status==1) Completed
                            @elseif($proj->status==2) Owned
                            @elseif($proj->status==3) In Progress
                            @elseif($proj->status==4) Blocked
                            @elseif($proj->status==5) On Hold
                            @elseif($proj->status==6) Cancelled
                            @elseif($proj->status==7) Approved @endif </td>
                        <td>{{$proj->project_manager->name ?? ''}} </td>
                        <td>{{$proj->createdByUser->name ?? ''}} </td>
                        <td>
                            @if(in_array($proj->status, [1,4,6]))

                            @if(auth()->user()->id==$proj->createdByUser->id)
                            <a href="{{ route('project.edit', ['id' => $proj->id]) }}" class="mr-1 text-info" title="Edit"><i class="fa fa-edit"></i> </a>
                            @endif
                            <a href="{{ route('project.task_list', ['id' => $proj->id]) }}" class="mr-1 text-blue" title="View Project"><i class="fa fa-eye"></i> </a>

                            @else
                            <a href="#" class="mr-1 text-success add-activity-btn" title="Add Task" data-task-id="{{ $proj->id }}" data-task-progress="{{ $proj->id }}" data-task-title="{{ $proj->name}}" title="Add Task"><i class="fa fa-plus"></i> </a>

                            <a href="{{ route('project.task_list', ['id' => $proj->id]) }}" class="mr-1 text-blue" title="View Project"><i class="fa fa-eye"></i> </a>
                            @if(auth()->user()->id==$proj->createdByUser->id)
                            <a href="{{ route('project.edit', ['id' => $proj->id]) }}" class="mr-1 text-info" title="Edit"><i class="fa fa-edit"></i> </a>
                            @if($proj->status != 6)
                            <a href="{{ route('project.delete', ['id' => $proj->id]) }}" class="mr-1 text-danger delete-task" title="Cancel" data-task-id="{{ $proj->id }}">
                                <i class="fa fa-times"></i>
                            </a>
                            @endif
                            @endif
                            @endif

                        </td>
                    </tr>
                    @endforeach
                    @elseif(auth()->user()->hasPermissionTo('department_head'))
                    @foreach($departmentwise_projects as $proj)
                    <tr @if($proj->status==6) style="background-color: #999; color:#fff" @endif>
                        <td>{{$loop->iteration}}</td>
                        <td> <a @if($proj->status==6) style="color: #fff; color:#fff" @endif href="{{ route('project.task_list', ['id' => $proj->id]) }}"> {{$proj->name}} </a></td>
                        <td> {{$proj->location}}</td>
                        <td>{{$proj->start_date}} </td>
                        <td>{{$proj->due_date}} </td>

                        <td>{{$proj->project_category->name}} </td>
                        <td>@if($proj->status==1) Completed
                            @elseif($proj->status==2) Owned
                            @elseif($proj->status==3) In Progress
                            @elseif($proj->status==4) Blocked
                            @elseif($proj->status==5) On Hold
                            @elseif($proj->status==6) Cancelled
                            @elseif($proj->status==7) Approved @endif </td>
                        <td>{{$proj->project_manager->name}} </td>
                        <td>{{$proj->createdByUser->name}} </td>
                        <td>
                            @if(in_array($proj->status, [1,4,6]))

                            @if(auth()->user()->id==$proj->createdByUser->id)
                            <a href="{{ route('project.edit', ['id' => $proj->id]) }}" class="mr-1 text-info" title="Edit"><i class="fa fa-edit"></i> </a>
                            @endif
                            <a href="{{ route('project.task_list', ['id' => $proj->id]) }}" class="mr-1 text-blue" title="View Project"><i class="fa fa-eye"></i> </a>

                            @else
                            <a href="#" class="mr-1 text-success add-activity-btn" title="Add Task" data-task-id="{{ $proj->id }}" data-task-progress="{{ $proj->id }}" data-task-title="{{ $proj->name}}" title="Add Task"><i class="fa fa-plus"></i> </a>

                            <a href="{{ route('project.task_list', ['id' => $proj->id]) }}" class="mr-1 text-blue" title="View Project"><i class="fa fa-eye"></i> </a>
                            @if(auth()->user()->id==$proj->createdByUser->id)
                            <a href="{{ route('project.edit', ['id' => $proj->id]) }}" class="mr-1 text-info" title="Edit"><i class="fa fa-edit"></i> </a>
                            @if($proj->status != 6)
                            <a href="{{ route('project.delete', ['id' => $proj->id]) }}" class="mr-1 text-danger delete-task" title="Cancel" data-task-id="{{ $proj->id }}">
                                <i class="fa fa-times"></i>
                            </a>
                            @endif
                            @endif
                            @endif

                        </td>
                    </tr>
                    @endforeach
                    @else
                    @foreach($departmentwise_projects as $proj)
                    <tr @if($proj->status==6) style="background-color: #999; color:#fff" @endif>
                        <td>{{$loop->iteration}}</td>
                        <td> <a @if($proj->status==6) style="color: #fff; color:#fff" @endif href="{{ route('project.task_list', ['id' => $proj->id]) }}"> {{$proj->name}} </a></td>
                        <td> {{$proj->location}}</td>
                        <td>{{$proj->start_date}} </td>
                        <td>{{$proj->due_date}} </td>

                        <td>{{$proj->project_category->name}} </td>
                        <td>@if($proj->status==1) Completed
                            @elseif($proj->status==2) Owned
                            @elseif($proj->status==3) In Progress
                            @elseif($proj->status==4) Blocked
                            @elseif($proj->status==5) On Hold
                            @elseif($proj->status==6) Cancelled
                            @elseif($proj->status==7) Approved @endif </td>
                        <td>{{$proj->project_manager->name}} </td>
                        <td>{{$proj->createdByUser->name}} </td>
                        <td>
                            @if(in_array($proj->status, [1,4,6]))

                            @if(auth()->user()->id==$proj->createdByUser->id)
                            <a href="{{ route('project.edit', ['id' => $proj->id]) }}" class="mr-1 text-info" title="Edit"><i class="fa fa-edit"></i> </a>
                            @endif
                            <a href="{{ route('project.task_list', ['id' => $proj->id]) }}" class="mr-1 text-blue" title="View Project"><i class="fa fa-eye"></i> </a>

                            @else
                            <a href="#" class="mr-1 text-success add-activity-btn" title="Add Task" data-task-id="{{ $proj->id }}" data-task-progress="{{ $proj->id }}" data-task-title="{{ $proj->name}}" title="Add Task"><i class="fa fa-plus"></i> </a>
                            <a href="{{ route('project.task_list', ['id' => $proj->id]) }}" class="mr-1 text-blue" title="View Project"><i class="fa fa-eye"></i> </a>
                            @if(auth()->user()->id==$proj->createdByUser->id)
                            <a href="{{ route('project.edit', ['id' => $proj->id]) }}" class="mr-1 text-info" title="Edit"><i class="fa fa-edit"></i> </a>
                            @if($proj->status != 6)
                            <a href="{{ route('project.delete', ['id' => $proj->id]) }}" class="mr-1 text-danger delete-task" title="Cancel" data-task-id="{{ $proj->id }}">
                                <i class="fa fa-times"></i>
                            </a>
                            @endif
                            @endif
                            @endif


                            <!-- <button type="button" class="btn btn-primary float-right add-activity-btn" 
                            data-task-id="{{ $proj->id }}" 
                            data-task-progress="{{ $proj->id }}" 
                            data-task-title="{{ $proj->name}}" 
                            title="Add Task">
                            Add Task
                            </button> -->




                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Add Activity Modal -->
        <div class="modal fade" id="addActivityModal" role="dialog" aria-labelledby="addActivityModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addActivityModalLabel">Add Task</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('task.store')}}" method="POST" role="form" enctype="multipart/form-data">

                            <!-- <form action="{{route('task.store')}}" method="POST" id="addTaskForm" data-isValid="{{--$isValid--}}"> -->
                            @csrf
                            <div class="form-group">
                                <label for="Name">Project </label>


                                <input type="text" class="form-control d-none" name="project" id="title">
                                <input type="text" class="form-control" name="task_title" id="task_title" readonly>
                                <input type="hidden" name="subtaskprogress" id="task-progress" value="">


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
                                <label for="start_daten">Start Date</label>
                                <input type="date" class="form-control" value="{{now()->setTimezone('Asia/Karachi')->format('Y-m-d') }}" required name="start_date" id="startdaten" placeholder="start date">
                            </div>
                            <div class="form-group">
                                <label for="dueDaten">Due Date</label>
                                <input type="date" class="form-control" value="{{now()->setTimezone('Asia/Karachi')->format('Y-m-d') }}" required name="dueDate" id="dueDatetn" placeholder="Due Date">
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
                                <label for="estimated_time">Estimated Time (hrs)</label>
                                <input type="number" class="form-control" name="estimated_time" min="0.5" step="0.5" value="{{ old('estimated_time') }}" id="estimated_time" placeholder="Estimated Time (hrs)" required max="1000">
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
                                <select class="form-control" name="status" required>

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
                                <select name="assigned_to" class="form-control" id="assigned_to" required>
                                    <option value="">Please select the user </option>
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

                                <label>File </label>

                                <!-- <input type="file" class="form-control-file" id="attachment_file" name="attachment_file" accept="image/*,video/*" required /> -->

                                <!-- <input type="file" multiple  class="form-control-file" id="attachment_file" name="attachment_file[]" accept="image/*,video/*,.pdf,.doc,.txt" required /> -->
                                <input type="file" class="form-control-file" id="attachment_file" name="attachment_file[]" accept="image/*,video/*,.pdf,.doc,.txt" multiple />



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
        <!-- End of Add Activity Modal -->
        <!-- Role Grant Modal -->
        <div class="modal fade" id="addProjectModal" tabindex="" role="dialog" aria-labelledby="addProjectModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProjectModalLabel">Add Project</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('project.store')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="Name">Name*</label>
                                <input type="text" class="form-control" name="name" id="Name" placeholder="Name" required oninput="restrictSpecialChars(this)">
                            </div>
                            <div class="form-group">
                                <label for="Location">Location</label>
                                <select class="form-control" id="Location" name="location">
                                    <option>PSCA LAHORE</option>
                                    <option>PPIC3 Kasur</option>
                                    <option>PPIC3 Nankana</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="startDatee">Start Date</label>
                                <input type="date" class="form-control" name="start_date" id="startDatee" value="{{now()->setTimezone('Asia/Karachi')->format('Y-m-d') }}" required placeholder="Start Date">
                            </div>
                            <div class="form-group">
                                <label for="dueDateu">Due Date</label>
                                <input type="date" class="form-control" id="dueDateu" name="due_date" value="{{now()->setTimezone('Asia/Karachi')->format('Y-m-d') }}" required placeholder="Due Date">
                            </div>
                            <div class="form-group">
                                <label>Manager*</label><br>
                                <select class="form-control select2"  name="manager" required>
                                    <option value="">Please select the user </option>
                                    <option value="{{auth()->user()->id}}">{{auth()->user()->name}} | {{auth()->user()->designation}} </option>
                                    @foreach($reportinguser as $user)
                                    <option value="{{$user->id}}">{{$user->name}} | {{$user->designation}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Department</label>
                                <select class="form-control" name="category">
                                    <option value="">Please select the department or Global to show all departments</option>
                                    <option value="999">Global Project (visible to all departments)</option>
                                    @if(auth()->user()->department == 10)
                                        <option value="16">Law and EDAC</option>
                                    @endif
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
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
<script type="text/javascript">
    $(function() {

        $('#table1').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('project.list')}}",
            responsive: true,
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name',

                },
                {
                    data: 'location'
                },
                {
                    data: 'start_date'
                },
                {
                    data: 'due_date'
                },

                {
                    data: 'manager'
                },
                {
                    data: 'category'
                },
                {
                    data: 'status'
                },
                {
                    data: 'created_by'
                },
                {
                    targets: -1,
                    data: 'action',
                },
            ],

            columnDefs: [{
                'targets': [3], // column index (start from 0)
                'orderable': false, // set orderable false for selected columns

            }],
            order: [
                [0, 'desc']
            ],
        });
    });
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('.usersearch').select2({
            placeholder: "Please Select the User"
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
            var taskProgress = $(this).data('task-progress')
            iProgress = parseInt(taskProgress);

            $('#progressSliderModal').slider('setValue', parseInt(taskProgress));

            // Populate any necessary fields in the modal
            $('#addActivityModal input[name="project"]').val(taskId);
            $('#addActivityModal').modal('show');
        });

        // Set the task ID when a row is clicked
        $('#taskTable tbody').on('click', 'data-task-id', function() {
            // Retrieve the task ID associated with the clicked row
            var taskId = $(this).data('task-id');

            // Populate any necessary fields in the modal
            $('#addActivityModal input[name="project"]').val(taskId);

            // Open the "Add Activity" modal
            $('#addActivityModal').modal('show');
        });

        // Submit the form when the 'Add Activity' button is clicked
        $('#addActivityBtn').on('click', function() {
            $('#task-progress').val(calculatedDifference);
            $('#addActivityModal form').submit();
        });



        // Initialize progress slider for the modal


        // Event listener for progress slider


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
            if (confirm('Are you sure you want to Cancel the Project?')) {
                // If user clicks 'OK', proceed with the deletion
                window.location.href = "{{ url('/admin/project/delete') }}/" + taskId;
            }
        });

        // Initialize DataTable

        // Initialize DataTable with column-specific options
        var table = $('#taskTable').DataTable({
            columnDefs: [{
                    targets: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                    orderable: false
                } // Set orderable to false for all columns except the 1st column
            ]
        });


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

        // Initialize date pickers

        // Apply filter when user selects a value from the taskFilter dropdown departmentFilter

        $('#priorityFilter').on('change', function() {
            var filterValue = $(this).val();
            table.column(5).search(filterValue).draw();
        });
        // jQuery script for handling both select dropdown and checkbox filtering
        // jQuery script for handling dropdown with checkboxes




        // jQuery script for handling dropdown with checkboxes
        $('.departmentCheckbox').on('change', function(e) {
            e.stopPropagation(); // Prevent dropdown from closing when clicking on checkbox
            var selectedDepartments = [];
            $('.departmentCheckbox:checked').each(function() {
                var department = $(this).data('department');
                selectedDepartments.push(department);
            });
            applyFilter(selectedDepartments);
        });

        // Handle click events for checkbox labels to prevent dropdown from closing
        $('.form-check-label').on('click', function(e) {
            e.stopPropagation();
        });

        $('#selectAllDepartments').on('click', function(e) {
            e.stopPropagation(); // Prevent dropdown from closing when clicking on "Select All"
            $('.departmentCheckbox').prop('checked', true).trigger('change');
        });

        $('#deselectAllDepartments').on('click', function(e) {
            e.stopPropagation(); // Prevent dropdown from closing when clicking on "Deselect All"
            $('.departmentCheckbox').prop('checked', false).trigger('change');
        });

        function applyFilter(selectedDepartments) {
            if (selectedDepartments.length > 0) {
                table.column(5).search(selectedDepartments.join('|'), true, false).draw();
                departmentsProjects();
            } else {
                table.column(5).search('').draw(); // Clear filter if no departments selected
            }
        }

        function departmentsProjects() {
            ///////////////////////////////////////////////////
            var columnIndex = 1; // Replace 0 with the index of the column you want to retrieve data from

            // Get the filtered rows
            var filteredIndexes = table.rows({
                search: 'applied'
            }).indexes();

            // Get data from the filtered cells in the specified column
            var filteredColumnData = [];
            filteredIndexes.each(function(index) {
                var cellData = table.cell(index, columnIndex).data();
                var tempElement = document.createElement('div');
                tempElement.innerHTML = cellData;
                var linkText = tempElement.querySelector('a').innerText;
                filteredColumnData.push(linkText.trim());
            });

            // Now, filteredColumnData contains data from filtered cells in the specified column
            // Reset Project Check Boxes
            $("[aria-labelledby='projectDropdown']").html('');
            let projectCheckBoxes = "";
            for (let i = 0; i < filteredColumnData.length; i++) {
                projectCheckBoxes += `<label class="dropdown-item"><input type="checkbox" class="project-filter" value="${filteredColumnData[i]}" data-project="${filteredColumnData[i]}"> ${filteredColumnData[i]}</label>`;
            }
            $("[aria-labelledby='projectDropdown']").html(projectCheckBoxes);

            //console.log(projectCheckBoxes)
            return filteredColumnData;
            ///////////////////////////////////////////////////
        }

        function projectsFilter() {
            // alert('fing dong')
            var filters = [];
            $('.project-filter:checked').each(function() {
                filters.push($(this).val());
            });
            table.column(1).search(filters.join('|'), true, false).draw();
        }

        $('.dropdown').on('change', '.project-filter', function(e) {
            e.stopPropagation(); // Prevent dropdown from closing when clicking on checkbox
            console.log(">>>>>>>>>>>>>>>>>")
            var selectedProjects = [];
            $('.project-filter:checked').each(function() {
                var project = $(this).data('project');
                selectedProjects.push(project);
            });
            projectsFilter(selectedProjects);
        });

        // Close dropdown when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.dropdown').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });




    });
</script>
<script>
    $(function() {
        $('#startDate').daterangepicker({
            singleDatePicker: true,
        });
        $('#dueDate').daterangepicker({
            singleDatePicker: true,
        });

    });
</script>

<script>
    $(function() {
        $('#startdate').daterangepicker({
            singleDatePicker: true,
        });
        $('#dueDatet').daterangepicker({
            singleDatePicker: true,
        });

    });
    function restrictSpecialChars(input) {
        // Define the allowed characters: letters, numbers, spaces, hyphens, commas, periods, ampersands, at symbols, plus signs, question marks, parentheses, square brackets, curly brackets, percentage signs, and double quotes
        const regex = /^[a-zA-Z0-9\s\-.,&@+?()\[\]{}%="]*$/;

        // If the value doesn't match the allowed characters, replace the value with the filtered value
        if (!regex.test(input.value)) {
            input.value = input.value.replace(/[^a-zA-Z0-9\s\-.,&@+?()\[\]{}%="]/g, '');
        }
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
        $('#assigned_to').select2({
            placeholder: "Please Select the user"
        });


    });
</script>

@endsection