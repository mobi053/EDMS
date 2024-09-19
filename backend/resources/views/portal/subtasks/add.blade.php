@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Log Time</h1>
                <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <!-- <form action="{{ route('activity.storelog') }}" method="POST"> -->
                <form id="logTimeForm">

                    @csrf
                    <table class="table table-bordered hourly-table" id="subtaskTable">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Subtask Name</th>
                                <th style="width: 7%;">Start Time</th>
                                <th style="width: 7%;">End Time</th>
                                <th>Remarks</th>
                                @if(auth()->user()->department==23)
                                <th style="width: 10%;">Log Status</th>
                                @else
                                <th style="width: 10%;">Subtask Status</th>
                                @endif
                                <th style="width: 10%;" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($hour = 0; $hour < 24; $hour++)
                                @php
                                $currentDay=date('Y-m-d');
                                $nextDay=date('Y-m-d', strtotime('+1 day'));
                                $start_time=sprintf('%02d:00:00', $hour);
                                $end_hour=($hour + 1) % 24;
                                $end_time=sprintf('%02d:00:00', $end_hour);
                                $start_datetime=$currentDay . ' ' . $start_time;
                                $end_datetime=$hour==23 ? $nextDay . ' ' . $end_time : $currentDay . ' ' . $end_time;
                                $duration=1; //hour
                                $matchingActivity=$activities->firstWhere('start_datetime', $start_datetime);
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
                                $subtaskRemainingTime = $matchingendActivity ? $matchingendActivity->remaining_time : null;
                                $start_time_formatted = date('h:i A', strtotime($start_datetime));
                                $end_time_formatted = date('h:i A', strtotime($end_datetime));
                                $subtasksArray = $subtasks->pluck('remaining_time', 'id')->all();
                                $shift_class = '';
                                if ($hour >= 6 && $hour < 14) {
                                    $shift_class='shift-A' ;
                                    }
                                    elseif ($hour>= 14 && $hour < 22) {
                                        $shift_class='shift-B' ;
                                        }
                                        elseif ($hour>= 22 || $hour < 6) {
                                            $shift_class='shift-C' ;
                                            }
                                            elseif ($hour>= 9 && $hour < 17) {
                                                $shift_class='shift-General' ;
                                                }
                                                @endphp
                                                <tr class="{{ $shift_class }}">
                                                <td>
                                                    <div class="form-group">
                                                        @if($subtask)
                                                        <input class="form-control" value="{{ \App\Models\Subtask::find($subtask)->name }}" readonly="" disabled>
                                                        @else
                                                        <select class="form-control subtask-select" name="subtask_{{ $hour }}" id="subtask_{{ $hour }}">
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
                                                    <input class="form-control" value="{{ $start_time_formatted }}" readonly="" disabled>
                                                    @else
                                                    <input type="hidden" name="start_datetime_{{ $hour }}" value="{{ $start_datetime }}">
                                                    <input class="form-control time-input" type="time" name="start_time_{{ $hour }}" value="{{ date('H:i', strtotime($start_datetime)) }}" readonly>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($matchingendActivity)
                                                    <input class="form-control" value="{{ $end_time_formatted }}" readonly="" disabled>
                                                    @else
                                                    <input type="hidden" name="end_datetime_{{ $hour }}" value="{{ $end_datetime }}">
                                                    <input class="form-control time-input" type="time" name="end_time_{{ $hour }}" value="{{ date('H:i', strtotime($end_datetime)) }}" readonly>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div>
                                                        @if($sub_description)
                                                        <textarea class="form-control" rows="1" disabled>{{ $sub_description }}</textarea>
                                                        @else
                                                        <textarea class="form-control" rows="1" name="sub_description_{{ $hour }}" id="sub_description_{{ $hour }}"></textarea>
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
                                                    @elseif(auth()->user()->department_type==1)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="subtask_status_{{ $hour }}" value="0" checked>
                                                        <label class="form-check-label">In Progress</label><br>
                                                    </div>
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
                                                    <button type="button" name="submit_row_{{ $hour }}" value="1" class="btn btn-primary log-btn">Log Time</button>
                                                    <!-- <button type="submit" name="submit_row_{{ $hour }}" value="1" class="btn btn-primary"> Log Time</button> -->

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
<!-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script> -->

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

        $(".log-btn").on("click", function() {
            // console.log(this.name)
            let row = this.name;
            let rowNumber = row.split('_').pop(); // Extract the last part of the string (e.g., "3")
            let formData = $('#logTimeForm').serialize();
            let jsonFormData = $('#logTimeForm').serializeArray();

            formData += `&${row}=1`
            // console.log(formData)
            let button = $(`button[name="${row}"]`);
            button.prop('disabled', true);
            //$('#logTimeForm').submit()

            $.ajax({
                url: "{{ route('activity.storelog') }}", // Use Laravel route helper to generate the URL
                method: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    // alert('Time Logged Successfully!');
                    // console.log('Success data:', formData); // Log response from the server
                    if (response.message) {
                        toastr.error(response.message);
                        button.prop('disabled', false);
                    } else if (response.success) { 
                        toastr.success(response.success);
                        $(`button[name="${row}"]`).prop('disabled', true);
                        $(`#sub_description_${rowNumber}`).prop('disabled', true);
                        let subtaskVal = $(`#subtask_${rowNumber}`).val();
                        let selectedSubtask = $(`#subtask_${rowNumber}`).children(`option[value="${subtaskVal}"]`).text();
                        $(`#subtask_${rowNumber}`).parent("div").html(`<input class="form-control" value="${selectedSubtask}" readonly="" disabled="">`);

                        // increment hours
                        let hours = parseInt($(".clock-hours").html());
                        hours++;
                        $(".clock-hours").html(hours);

                        //reomve button
                        $(`button[name="${row}"]`).remove();

                        // update status
                        let radioVal = $(`input[type="radio"][name="subtask_status_${rowNumber}"]:checked`).next("label").html();
                        $(`input[type="radio"][name="subtask_status_${rowNumber}"]:checked`).closest('td').html(radioVal)

                        // remove completed sub task
                        jsonFormData.map(param => {
                            if (param.name === `subtask_${rowNumber}` && param.value !== "") {
                                jsonFormData.map(iParam => {
                                if (iParam.name === `subtask_status_${rowNumber}` && iParam.value === "1") {
                                    // console.log(">>>>>>>>>>>", `.subtask-select option[value="${param.value}]"`);
                                    $(`.subtask-select option[value="${param.value}"]`).remove();
                                }
                            })
                            }
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // console.log('Error Logging time:', error); // Log any errors
                    // alert('Failed to log Time.');
                    toastr.error('Please Enter Remarks and Subtask Name');
                    button.prop('disabled', false);
                }
            });
        })
        
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
                $('.shift-A').show();
            } else if (selectedShift === 'B') {
                $('.shift-B').show();
            } else if (selectedShift === 'C') {
                // Show rows from 10pm to 6am for Shift C
                $('.shift-C').show();
                $('.shift-C').filter(function() {
                    var startTime = $(this).find('input[name^="start_time_"]').val();
                    return startTime >= '22:00:00' || startTime < '06:00:00';
                }).show();
            } else if (selectedShift === 'General') {
                // Show rows from 9am to 5pm for General shift.
                // $('.shift-General').show();
                // $('.shift-General').filter(function() {
                //     var startTime = $(this).find('input[name^="start_time_"]').val();
                //     return startTime >= '09:00:00' && startTime < '17:00:00';
                // }).show();
                window.location.href = "{{route('subtask.add_activity_general')}}";
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