@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Log Time</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Log Time</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="card card-info card-outline">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <h5><b>Employee Name: </b> {{$currentUser->name}}({{$currentUser->designation}}) </h5>
                <h5>
                    <b>Current Date: </b> {{now()->setTimezone('Asia/Karachi')->format('Y-m-d')}}
                </h5>
            </div>

            <!---total duration black box---->
            <div class="row justify-content-center">
                <div class="col-12">
                    <h3 class="text-center">Today's Time Spent</h3>
                </div>
                <div class="col-md-6 col-xl-3 col-xxl-3">
                    <div class="clock-container justify-content-center bg-info">
                        <div class="clock-col">
                            <p class="clock-hours clock-timer">
                                {{$sumofCurrentdayActivities/60}}
                            </p>
                            <p class="clock-label">
                                Hours
                            </p>
                        </div>
                        <div class="clock-col">
                            <p class="clock-minutes clock-timer">
                                00
                            </p>
                            <p class="clock-label">
                                Minutes
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <!---end total duration---->

            <div class="table-responsive">
                <select class="form-control d-inline-block col-1 mr-1 float-right" id="shift">
                    <!-- <option value="">Select your shift</option> -->
                    <option value="A">A Shift</option>
                    <option value="B">B Shift</option>
                    <option value="C">C Shift</option>
                    <option value="General">General Shift</option>
                </select>
                @php
                $currentDay = now()->toDateString();
                @endphp
                <form action="{{ route('activity.storelog') }}" method="POST">
                    @csrf
                    <table class="table table-bordered hourly-table" id="subtaskTable">
                        <thead>
                            <tr>
                                <th>Subtask Name</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Remarks</th>
                                @if(auth()->user()->department==23)
                                <th>Log Status</th>
                                @else
                                <th>Subtask Status</th>
                                @endif
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($hour = 0; $hour < 24; $hour++)
                            @php
                            $currentDay = date('Y-m-d');
                            $nextDay = date('Y-m-d', strtotime('+1 day'));

                            $start_time = sprintf('%02d:00:00', $hour);
                            $end_hour = ($hour + 1) % 24;
                            $end_time = sprintf('%02d:00:00', $end_hour);
                            $start_datetime = $currentDay . ' ' . $start_time;
                            $end_datetime = $hour == 23 ? $nextDay . ' ' . $end_time : $currentDay . ' ' . $end_time;
                            $duration = 1;
                            $matchingActivity = $activities->firstWhere('start_datetime', $start_datetime);
                            $matchingendActivity = $activities->firstWhere('end_datetime', $end_datetime);
                            $sub_description = $matchingendActivity ? $matchingendActivity->sub_description : null;
                            $subtask = $matchingendActivity ? $matchingendActivity->sub_task_id : null;
                            if(auth()->user()->department==23){
                            $subtaskStatus = $matchingendActivity ? $matchingendActivity->sub_task_id : null;
                            $activityStatus = $matchingendActivity ? $matchingendActivity->id : null;
                            
                            }
                            else
                            {
                                $activityStatus = $matchingendActivity ? $matchingendActivity->id : null;
                                $subtaskStatus = $matchingendActivity ? $matchingendActivity->sub_task_id : null;
                             
                            }

                            $start_time_formatted = date('h:i A', strtotime($start_datetime));
                            $end_time_formatted = date('h:i A', strtotime($end_datetime));
                            $subtasksArray = $subtasks->pluck('remaining_time', 'id')->all();

                            $shift_class = '';
                            if ($hour >= 9 && $hour < 17) {
                                $shift_class = 'shift-General';
                            }
                            @endphp

                            <tr class="{{ $shift_class }}">
                                <td>
                                    <div class="form-group">
                                        @if($subtask)
                                        {{ \App\Models\Subtask::find($subtask)->name }}
                                        @else
                                        <select class="form-control subtask-select" name="subtask_{{ $hour }}">
                                            <option value="">Please select a Subtask</option>
                                            @foreach($subtasks as $subtask)
                                            <option value="{{ $subtask->id }}">{{ $subtask->name }}</option>
                                            @endforeach
                                        </select>
                                        @error("subtask_$hour")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($matchingActivity)
                                    {{ $start_time_formatted }}
                                    @else
                                    <input type="hidden" name="start_datetime_{{ $hour }}" value="{{ $start_datetime }}">
                                    <input class="form-control time-input" type="time" name="start_time_{{ $hour }}" value="{{ date('H:i', strtotime($start_datetime)) }}" readonly>
                                    @endif
                                </td>
                                <td>
                                    @if($matchingendActivity)
                                    {{ $end_time_formatted }}
                                    @else
                                    <input type="hidden" name="end_datetime_{{ $hour }}" value="{{ $end_datetime }}">
                                    <input class="form-control time-input" type="time" name="end_time_{{ $hour }}" value="{{ date('H:i', strtotime($end_datetime)) }}" readonly>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        @if($sub_description)
                                        {{ $sub_description }}
                                        @else
                                        <textarea class="form-control" rows="1" name="sub_description_{{ $hour }}"></textarea>
                                        @error("sub_description_$hour")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        @endif
                                    </div>
                                </td>
                                <td>
                                @if($subtaskStatus)
                                    @php
                                    $status = \App\Models\Subtask::find($subtaskStatus)->status;
                                    $activitystatus = \App\Models\Activity::find($activityStatus)->status;
                                    @endphp
                                    @if(auth()->user()->department==23)
                                    <span>
                                        @if($activitystatus==1) Completed
                                        @elseif($activitystatus==0) In Progress
                                        @elseif($activitystatus==2) On Hold
                                        @elseif($activitystatus==3) Not Started Yet
                                        @elseif($activitystatus==4) Cancelled
                                        @elseif($activitystatus==6) Pending
                                        @endif
                                    </span>
                                    @else
                                    <span>
                                        @if($status==1) Completed
                                        @elseif($status==0) In Progress
                                        @elseif($status==2) On Hold
                                        @elseif($status==3) Not Started Yet
                                        @elseif($status==4) Cancelled
                                        @elseif($status==6) Pending
                                        @endif
                                    </span>
                                    @endif
                                    @else
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="subtask_status_{{ $hour }}" value="1">
                                        <label class="form-check-label">Completed</label><br>
                                        <input class="form-check-input" type="radio" name="subtask_status_{{ $hour }}" value="0" checked>
                                        <label class="form-check-label">In Progress</label><br>
                                        <input class="form-check-input" type="radio" name="subtask_status_{{ $hour }}" value="2">
                                        <label class="form-check-label">On Hold</label>
                                        @error("subtask_status_$hour")
                                        <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($matchingActivity)
                                    {{ "" }}
                                    @else
                                    <button type="submit" name="submit_row_{{ $hour }}" value="1" class="btn btn-primary">Log Time</button>
                                    <input type="hidden" name="start_datetime_{{ $hour }}" value="{{ $start_datetime }}">
                                    <input type="hidden" name="end_datetime_{{ $hour }}" value="{{ $end_datetime }}">
                                    <input type="hidden" name="duration_{{ $hour }}" value="{{ $duration }}">
                                    <input type="hidden" class="subtask-id-input" name="remainingtime_{{ $hour }}" value="">

                                    @endif
                                </td>
                            </tr>
                            @endfor
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <div class="d-flex justify-content-center"></div>
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
    document.addEventListener('DOMContentLoaded', function() {
        // PHP array converted to JavaScript object
        const subtasks = @json($subtasksArray);

        document.querySelectorAll('.subtask-select').forEach(function(selectElement) {
            selectElement.addEventListener('change', function() {
                const selectedSubtaskId = this.value;
                const remainingTime = subtasks[selectedSubtaskId] || 0;
                const updatedTime = remainingTime - 1;
                const hiddenInput = this.closest('tr').querySelector('.subtask-id-input');
                hiddenInput.value = updatedTime;
            });
        });
    });
</script>
<script>
$(document).ready(function() {
    // Function to load shift based on local storage or default to empty
    function loadShift() {
        var selectedShift = localStorage.getItem('selectedShift');
        if (selectedShift) {
            $('#shift').val(selectedShift);
            applyShiftFilter(selectedShift);
        }
    }

    // Function to apply filter based on selected shift
    function applyShiftFilter(selectedShift) {
        $('.shift-A, .shift-B, .shift-C, .shift-General').hide();
        if (selectedShift === 'A') {
            window.location.href="{{route('activity.index')}}";

        } else if (selectedShift === 'B') {
            window.location.href="{{route('activity.index')}}";

        } else if (selectedShift === 'C') {
            window.location.href="{{route('activity.index')}}";

        } else if (selectedShift === 'General') {
            // Show rows from 9am to 5pm for General shift.
            $('.shift-General').show();
            $('.shift-General').filter(function() {
                var startTime = $(this).find('input[name^="start_time_"]').val();
                return startTime >= '00:00:00' && startTime < '24:00:00';
            }).show();
        }
    }

    // Load shift on document ready
    loadShift();

    // Event listener for shift selection
    $('#shift').on('change', function() {
        var selectedShift = $(this).val();
        localStorage.setItem('selectedShift', selectedShift); // Store selected shift in local storage
        applyShiftFilter(selectedShift);
    });

    // Add your existing script here...
});

</script>
@endsection

