@extends('portal.layout.app')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Meetings </h1>



                <!-- $subtask_progress->progress -->

            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <!-- <li class="breadcrumb-item"><a href="#">Projects</a></li> -->
                    <li class="breadcrumb-item active">Meeting</li>
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

           
          
         
            <select class="form-control d-inline-block col-2 mr-1 select2" id="crimeNoFilter">
                <option value="">Select title</option>
                @foreach($meetings as $task)
                    <option value="{{$task->title}}">{{$task->title}}</option>
                @endforeach
            </select>
            <div class="form-control d-inline-block col-3 mr-1" id="dateRangePicker">
                <i class="fa fa-calendar"></i>&nbsp;
                <span>Select Date Range</span> <i class="fa fa-caret-down"></i>
            </div>
        
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addTaskModal">
            Schedule Meeting
            </button>
         


        </div>
        <div class="card-body">
            <div class="table table-responsive">
                <table class="table table-bordered" id="taskTable">
                    <thead>
                        <tr>
                            <th> Sr. </th>
                             <th> Meeting Title </th>
                            <th> Start Date </th>
                            <th> End Date </th>
                           
                             <th> Meeting Head </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>

                        <!--Admin like MD View all tasks--->

                        <!--department head--->

                        <!--Enduser view tasks created by or assigned to him--->


                    </tbody>
                </table>
            </div>
        </div>

      


        <!--Add Task Modal -->
        <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">`
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskModalLabel">Schedule Meeting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('meeting.store')}}" method="POST" enctype="multipart/form-data">


                            @csrf
                            <div class="form-group d-none">
                                <label>Project*</label>
                                <select name="project" class="form-control" required>
                                
                                    <option value="2">Test Project 2</option>
                                 
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="Title" class="required">Meeting Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" id="Title" placeholder="Title" required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="Description" class="required">Description</label>
                                <textarea class="form-control @error('Description') is-invalid @enderror" rows="3" name="Description" id="Description" required placeholder="Description" >{{ old('Description') }}</textarea>
                                @error('Description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="start_datee">Start Date/Time</label>
                                <input class="form-control" type="datetime-local" id="start_datee" name="start_date" placeholder="Enter Start Date" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\T09:00') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="start_datee">End Date/Time</label>
                                <input class="form-control" type="datetime-local" id="end_datee" name="end_date" placeholder="Enter End Date" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\T09:00') }}" required>
                            </div>
                       
                            <div class="form-group d-none">
                                <label for="estimated_time">Estimated Time (hrs)*</label>
                                <input type="number" value="0" class="form-control" name="estimated_time" id="estimated_time" placeholder="Estimated Time (hrs)" required>
                            </div>

                            <div class="form-group d-none">
                                <label>Priority</label>
                                <select name="priority" class="form-control">
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                    <option value="Critical">Critical</option>
                                    <option value="Low">Low</option>
                                </select>
                            </div>
                            <div class="form-group d-none">
                                <label>Status</label>
                                <select class="form-control" name="status">

                                    <option value="7">Approved</option>
                                  
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="required">Meeting Head</label>
                                <select name="assigned_to" class="form-control" required>
                                <option value="" >Please select the user </option>
                                <option value="{{auth()->user()->id}}">{{auth()->user()->name}} | {{auth()->user()->designation}} </option>
                                    @foreach($reportinguser as $userassigned)
                                    <option value="{{$userassigned->id}}">{{$userassigned->name}} | {{$userassigned->designation}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="collaborators">Participants</label>
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


<script>
 $(document).ready(function() {
    function fetchTasks() {
        var crimeNo = $('#crimeNoFilter').val();
        var dateRange = $('#dateRangePicker span').html();
        var startDate = null;
        var endDate = null;

        if (!crimeNo) {
            // Only use date range if no title is selected
            if (dateRange && dateRange !== 'Select Date Range') {
                var dates = dateRange.split(' - ');
                startDate = dates[0];
                endDate = dates[1];
            }
        }

        $.ajax({
            url: "{{ route('search.tasks') }}",
            type: "GET",
            data: { 
                title: crimeNo,
                start_date: startDate,
                end_date: endDate
            },
            success: function(data) {
                $('#taskTable tbody').empty();
                var serialNumber = 1;
                $.each(data, function(index, task) {
                    var status = task.status;
                    var taskManagerid = task.created_by;
                    var editUrl = '{{ route("meeting.edit", ":id") }}'.replace(':id', task.id);
                    var deleteUrl = '{{ route("meeting.delete", ":id") }}'.replace(':id', task.id);
                    var viewUrl = '{{ route("meeting.detailview", ":id") }}'.replace(':id', task.id);
                    var approveUrl = '{{ route("meeting.approve", ":id") }}'.replace(':id', task.id);
                    var cancelUrl = '{{ route("meeting.delete", ":id") }}'.replace(':id', task.id);

                    var taskManagerName = task.task_manager ? task.task_manager.name : 'N/A';

                                var approveLink = '';
                if ({{ auth()->user()->id }} === taskManagerid) {
                    
                    if (task.status == 1) {
                    approveLink = `<span class="mr-1 text-success" title="Mark Meeting as Completed"><i class="fa fa-check-circle"></i> </a>`;
                } else {
                    approveLink = `<a href="` + approveUrl + `" class="mr-1 text-warning" title="Mark Meeting as Completed" data-task-id="` + task.id + `"><i class="fa fa-check-circle"></i> </a>`;
    }

                }

                    $('#taskTable tbody').append(
                        `<tr>
                            <td>` + serialNumber++ + `</td>
                            <td>` + task.title + `</td>
                            <td>` + task.start_date + `</td>
                            <td>` + task.end_date + `</td>
                            <td>` + taskManagerName + `</td>                      
                            <td>
                                @can('edit_meeting', $tasks)
                                    <a href="` + editUrl + `" class="mr-1 text-info" title="Edit"><i class="fa fa-edit"></i> </a>
                                @endcan

                        
                             
                            @can('delete_meeting', $tasks)
                            <a href="` + cancelUrl + `" class="mr-1 text-danger" title="Cancel"><i class="fa fa-times" data-task-id="` + task.id + `"></i> </a>
                            @endcan
                            <a href="` + viewUrl + `" class="mr-1 text-blue" title="View Detail" data-task-id="` + task.id + `"><i class="fa fa-eye"></i> </a>

                            ` + approveLink + `
                                                        
                            
                                  
                                 
         
                            </td>
                        </tr>`
                    );
                });

                // Reinitialize DataTables
                $('#taskTable').DataTable();
            },
            error: function() {
                alert('Error fetching tasks. Please try again.');
            }
        });
    }

    $('#crimeNoFilter').on('change', function() {
        // Reset date range picker if a title is selected
        if ($(this).val()) {
            $('#dateRangePicker span').html('Select Date Range');
        } else {
            // Initialize the date range picker with the option to select any date range
            $('#dateRangePicker').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                startDate: moment(),
                endDate: moment().add(1, 'month')
            }, function(start, end) {
                $('#dateRangePicker span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
                fetchTasks();
            });

            $('#dateRangePicker span').html(moment().format('YYYY-MM-DD') + ' - ' + moment().add(1, 'month').format('YYYY-MM-DD'));
        }

        fetchTasks();
    });

    // Initialize the date range picker with the option to select any date range
    $('#dateRangePicker').daterangepicker({
        locale: {
            format: 'YYYY-MM-DD'
        },
        startDate: moment(),
        endDate: moment().add(1, 'month')
    }, function(start, end) {
        $('#dateRangePicker span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
        fetchTasks();
    });

    // Initial fetch for the current day and future dates
    $('#dateRangePicker span').html(moment().format('YYYY-MM-DD') + ' - ' + moment().add(1, 'month').format('YYYY-MM-DD'));
    fetchTasks();
});





</script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
        

        $('.usersearch').select2({
            placeholder: "Please Select the User"
        });
        $('.collaboratorsearch').select2({
            placeholder: "Please Select the Participants"
        });
        
        
    });
    
</script>


@endsection