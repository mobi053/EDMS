@extends('portal.layout.app')
@section('content')
@php
    use Carbon\Carbon;
@endphp
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1 class="m-0">User Report</h1><br>
                <form action="{{ route('user.dashboardreport') }}" method="GET"  class="user-report-form">
                    <label for="start_date">Start Date</label>
                    <input type="datetime-local" id="start_date" name="start_date" placeholder="Enter Start Date" value="{{$startDate ?? now()->setTimezone('Asia/Karachi')->format('Y-m-d\T00:00') }}" required>
                    <label for="end_date">End Date</label>
                    <input type="datetime-local" id="end_date" name="end_date" placeholder="Enter End Date" value="{{$endDate ?? now()->setTimezone('Asia/Karachi')->format('Y-m-d\T23:59') }}" required>
                    <select class="form-control d-inline-block col-2 mr-1 select2" name="user" id="user" required onchange="updateuser()">
                        <option value="">Select Employee</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" @if($id==$user->id) selected @endif>{{ $user->name }} || {{ $user->designation }} </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div><!-- /.col -->
            <div class="col-sm-2">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">User Report</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">

    <div class="card card-info card-outline">
        <!---total duration black box---->
        <div class="row justify-content-center">
            <div class="col-12">
                <h3 class=text-center style="padding-top: 15px;;">Work Logged on {{$loggedat ?? ''}}</h3>
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

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="subtaskTable">
                    <thead>
                        <tr>

                            <th class="d-none">Employee Name</th>
                            <th>Task Name</th>
                            <th>SubTask Name</th>
                            <th>Log Description</th>
                            <th style="width: 12%;">Logged Interval</th>
                            <th>Work Logged (Hrs)</th>
                            <th class="d-none">SubTask Created At</th>

                            <th>SubTask Status</th>
                            <th class="d-none">Department</th>
                            <th>Actions</th>


                        </tr>
                    </thead>
                    <tbody>

                        <!-- //It is for Admin -->

                        <!-- Additional loop for $alltask  -->


                        @foreach($activities as $activity)

                        <tr data-user-id="{{$activity->activity_creator->id}}">
                            <td class="d-none"> {{$activity->activity_creator->name}} | {{$activity->activity_creator->designation}}</td>
                            <td> <a href="{{ route('task.subtask_list', ['id' => $activity->subTasks->task->id]) }}"> {{$activity->subTasks->task->title}} </a></td>
                            <td> <a @if($activity->subTasks->status==6) style="color:#fff" @endif href="{{ route('task.activity', ['id' => $activity->subTasks->id]) }}"> {{$activity->subTasks->name}} </a></td>
                            <td> {{$activity->sub_description}}</td>
                            <td>{{Carbon::parse($activity->start_datetime)->format('g:i A');}} - {{Carbon::parse($activity->end_datetime)->format('g:i A');}}</td>

                            <td>
                                @php
                                $timespenthr = number_format($activity->duration / 60, 1);
                                @endphp
                                {{$timespenthr}}
                            </td>

                            <td class="d-none">{{$activity->created_at}}</td>

                            <td>@if($activity->subTasks->status==1) Completed @elseif($activity->subTasks->status==0) In Progress @elseif($activity->subTasks->status==2) On Hold @elseif($activity->subTasks->status==3) Not Started Yet @elseif($activity->subTasks->status==4) Cancelled @elseif($activity->subTasks->status==6) Pending @endif</td>
                            <td class="d-none">{{$activity->subTasks->task->department->name ?? ''}}</td>
                            <td>
                                <!-- Add actions/buttons for the new column doolar-subtask->sub_task_creator->id -->
                                <a href="{{ route('task.activity', ['id' => $activity->subTasks->id]) }}" class="mr-1 text-blue" title="View"><i class="fa fa-eye"></i> </a>


                            </td>
                        </tr>


                        @endforeach



                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
@endsection
@section('script')
<script src="{{ url('/portal') }}/plugins/chart.js/Chart.min.js"></script>









<script>
    $(document).ready(function() {

 $('.select2').select2();


        // Calculate and update the sum of the "Duration" column
        function updateTotalDuration() {
            var table = $('#subtaskTable').DataTable({
                dom: 'Bfrtip',
                buttons: ['pageLength',
                    {
                        extend: 'excelHtml5',
                        text: 'Export to Excel',
                        title: 'User Report'
                    },
                    // 'colvis'
                ]
            });
            var totalDurationHours = 0; // Initialize total duration in hours

            // Iterate over each row that matches the current search
            table.rows({
                search: 'applied'
            }).every(function(rowIdx, tableLoop, rowLoop) {
                var data = this.data(); // Get the row data
                var hours = data[5]; // Get data from the 6th column

                // Log the raw data from the column
                console.log("Raw hours data from column:", hours);

                // Check if hours is a valid number
                if (hours !== null && hours !== undefined && hours !== "" && !isNaN(hours)) {
                    hours = parseFloat(hours); // Convert to float
                    totalDurationHours += hours; // Accumulate valid hours
                    console.log("Accumulated Hours: ", totalDurationHours);
                } else {
                    console.log("Invalid Hours Data: ", hours);
                }
            });

            // Separate hours and minutes
            var totalDurationHoursFloor = Math.floor(totalDurationHours);
            var remainingMinutes = Math.round((totalDurationHours - totalDurationHoursFloor) * 60); // Convert remaining fraction to minutes

            // Update the total duration in the new div
            document.querySelector('.clock-hours').innerText = totalDurationHoursFloor;
            document.querySelector('.clock-minutes').innerText = remainingMinutes;

            console.log("Total Duration: ", totalDurationHoursFloor, " Hours ", remainingMinutes, " Minutes");
        }


        updateTotalDuration();





    });
</script>


@endsection