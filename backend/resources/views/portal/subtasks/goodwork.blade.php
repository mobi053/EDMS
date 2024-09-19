@extends('portal.layout.appsubtask')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Good Work</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('task.index')}}">Task</a></li>
                    <li class="breadcrumb-item active">Good Work</li>
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

            <select class="form-control d-inline-block col-1 mr-1" id="statusFilter">
                <option value="">All Subtask</option>
                <option value="1">Authenticated</option>
                <option value="0">Not Authenticated</option>
              
            </select>
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
            url: "{{ route('subtask.goodworklist') }}",
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
        // fnDrawCallback: function(oSettings) {
        //     var api = this.api();
        //     var data = api.ajax.json();
        //     var totalTime = data.totalTime; // Access totalTime from the response

        //     // Manipulate or display totalTime as needed
        //     console.log('Total Time:', totalTime);
        //     updateTotalDuration(totalTime)
        // }
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

     
        
        $('.select3').select2();


    });
</script>




@endsection