@extends('portal.layout.appb')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1 class="m-0">Department Report</h1><br>

                <form action="{{ route('user.departsingle_reportfetch') }}" method="POST">
                    @csrf
                    <?php
                    $todayDate = now()->setTimezone('Asia/Karachi')->format('Y-m-d');
                    ?>
                    <label for="start_date">Single Day Report</label>
                    <input type="date" id="start_date" name="start_date" placeholder="Enter Start Date" value="{{ $start_date_only ??$start_date_only ?? $todayDate }}" required>

                    <label for="start_date">Weekly & Monthly Report</label>
                    <input type="hidden" name="startDate" id="startDate" value="">
                    <input type="hidden" name="endDate" id="endDate" value="">
                    <button type="button" class="btn btn-default mr-1" id="daterange-btn">
                        <i class="far fa-calendar-alt"></i>
                        <span>Select duration</span>
                        <i class="fas fa-caret-down"></i>
                    </button>


                    <div class="dropdown d-inline-block" style="margin-right: 5px;">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="departmentDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Departments
                        </button>
                        <div class="dropdown-menu" aria-labelledby="departmentDropdown" style="padding: 0px 9px; z-index:1100">
                            <a class="dropdown-item" href="#" id="selectAllDepartments">Select All</a>
                            <a class="dropdown-item" href="#" id="deselectAllDepartments">Deselect All</a>
                            <div class="dropdown-divider"></div>
                            @foreach($department as $dept)
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input departmentCheckbox" name="dept[]" id="department_{{ $dept->id }}" value="{{ $dept->id }}" data-department="{{ $dept->name }}" @if(in_array($dept->id, (array)$depart)) checked @endif>
                                <label class="form-check-label" for="department_{{ $dept->id }}">{{ $dept->name }}</label>
                            </div>
                            @endforeach
                        </div>





                    </div>

                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div><!-- /.col -->
            <div class="col-sm-2">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Department Report</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->

<section class="content">
    <div class="container-fluid">
        <div class="card card-info card-outline">
            @if(empty($results) && empty($data))
            <div class="card-header">
                <div class="row">
                    <div class="col-12 user-report-form">
                        @if(empty($startDate))
                        <select class="form-control d-inline-block col-2 mr-1 select2" id="userFilter" required>
                            <option value="">Attendace Status</option>

                            <option value="Absent">Absent</option>
                            <option value="Present">Present</option>
                            <option value="Leave">Leave</option>
                            <option value="Short Leave">Short Leave</option>
                            <option value="Half Leave">Half Leave</option>

                        </select>
                        @endif
                        @if (!empty($departmentSummaryoneday))
                        <select class="form-control d-inline-block col-2 mr-1" id="priorityFilter">
                            <option value="">Work Logged</option>
                            <option value="0">0</option>
                            <option value="less_than_6">Less than 6</option>
                            <option value="greater_equal_6">Greater or equal to 6</option>
                            <option value="greater_equal_7">Greater or equal to 7</option>
                            <option value="greater_equal_8">Greater or equal to 8</option>
                        </select>
                        @else
                        <select class="form-control d-inline-block col-2 mr-1" id="priorityFiltere">
                            <option value="">Work Logged</option>
                            <option value="0">0</option>
                            <option value="less_than_6">Less than 6</option>
                            <option value="greater_equal_6">Greater or equal to 6</option>
                            <option value="greater_equal_7">Greater or equal to 7</option>
                            <option value="greater_equal_8">Greater or equal to 8</option>
                        </select>
                        @endif



                    </div>
                </div>
            </div>
            @endif
            <div class="card-body">
                <div class="table-responsive">

                    <!---weekly report--->
                    @if(!empty($mergedDataw))
                    @if(isset($mergedDataw['error']))
                    <div class="alert alert-danger">
                        {{ $mergedDataw['error'] }}
                    </div>
                    @else


                    <h2>Department-wise Activity Report: {{$startDatew}} to {{$endDatew}}</h2>

                    @if (!empty($departmentSummary))
                    <table class="table table-bordered" id="subtaskTablesum">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Department</th>
                                <th>Total Employees</th>
                                <th>Man Days</th>
                                <th>Work Logged (Days)</th>
                                <th>Total Leaves</th>
                                <th>Total Absents</th>
                                <th>Total Offs</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($departmentSummary as $summary)
                            <tr>
                                @php

                                $completeworkdays=($weeklyhours-$saturdaysCount/2)*$summary['total_users']-$summary['total_leaves']-$summary['total_absents']-$summary['total_offs'];
                                $completeworkdaysops=$weeklyhours*$summary['total_users']-$summary['total_leaves']-$summary['total_absents']-$summary['total_offs'];

                                $workdays= ($weeklyhours)-$saturdaysCount;
                                $allworkingdays=$summary['total_users'] *($weeklyhours) ;
                                @endphp
                                <!-- summary['saturday_duration'] -->
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $summary['department_name'] }}</td>
                                <td>
                                <a href="#" class="employee-link" data-toggle="modal" data-target="#userModal"
                                    data-department="{{ $summary['department_name'] }}" data-users="{{ $summary['total_users'] }}"
                                    data-employees="{{ json_encode($summary['employees']) }}" data-empid="{{ json_encode($summary['employee_id']) }}"
                                    data-offs="{{json_encode($summary['offemployee'])}}" data-absents= "{{json_encode($summary['absentemployee'])}}"
                                    data-leaves="{{json_encode($summary['leaveemployee'])}}"
                                    data-countClicked="total_users">
                                   {{ $summary['total_users'] }}
                                    </a>
                                </td>
                                <td>@if (in_array($summary['departmentids'], ['16','21','13']) or $summary['department_type']==1){{ $completeworkdaysops }} @else{{ $completeworkdays }}@endif</td>
                                @php
                                $totalTimeSpent = is_numeric($summary['total_time_spent']) ? (float) $summary['total_time_spent'] : 0;
                                $saturday_durationspent = is_numeric($summary['saturday_duration']) ? (float) $summary['saturday_duration'] : 0;

                                $withoutsatspent=$totalTimeSpent-$saturday_durationspent;
                                $withoutsatspentint=number_format($withoutsatspent / 8);
                                $timeSpentPerDaysat = number_format($saturday_durationspent / 4);
                                $totalactivitydur=$withoutsatspentint+$timeSpentPerDaysat;

                                $totalTimeminusweek=$totalTimeSpent-$saturdaysCount*4;
                                $weekhours=$totalTimeSpent-$totalTimeminusweek;

                                $timeSpentPerDaywithoutsat = number_format($totalTimeminusweek / 8);
                                $timeSpentPerDaysat = number_format($weekhours / 4);
                                $totaldaysspent=$timeSpentPerDaywithoutsat+$timeSpentPerDaysat;

                                $timeSpentPerDay = number_format($totalTimeSpent / 8);



                                $minusweek=$timeSpentPerDay-($timeSpentPerDay*$saturdaysCount);
                                $actualtimeSpent=($saturdaysCount*$totalTimeSpent / 4);

                                @endphp
                                @if ($completeworkdays != 0)
                                <td>@if (in_array($summary['departmentids'], ['16','21','13']) or $summary['department_type']==1){{ $timeSpentPerDay }} @else{{ $totalactivitydur }}@endif</td>

                                @else
                                <td>0</td> <!-- Or handle this case as you see fit -->
                                @endif
                                <td>
                                <a href="#" class="employee-link" data-toggle="modal" data-target="#userModal"
                                    data-department="{{ $summary['department_name'] }}" data-users="{{ $summary['total_leaves'] }}"
                                   
                                    data-employees="{{ json_encode($summary['employees']) }}" data-empid="{{ json_encode($summary['employee_id']) }}"
                                
                                        data-offs="{{ json_encode($summary['offemployee']) }}"
                             
                                    data-absents= "{{json_encode($summary['absentemployee'])}}"
                                    data-leaves="{{json_encode($summary['leaveemployee'])}}"
                                   
                                    data-countClicked="leaves">    
                                           {{ $summary['total_leaves'] }}
                                 </a>
                            </td>
                                <td>
                                <a href="#" class="employee-link" data-toggle="modal" data-target="#userModal"
                                    data-department="{{ $summary['department_name'] }}" data-users="{{ $summary['total_absents'] }}"
                                   
                                    data-employees="{{ json_encode($summary['employees']) }}" data-empid="{{ json_encode($summary['employee_id']) }}"
                                
                                        data-offs="{{ json_encode($summary['offemployee']) }}"
                             
                                    data-absents= "{{json_encode($summary['absentemployee'])}}"
                                    data-leaves="{{json_encode($summary['leaveemployee'])}}"
                                   
                                    data-countClicked="absents">
                                    {{ $summary['total_absents'] }}
                                    </a>
                                </td>
                               <!---Total Off button--->
                                <td>
                                <a href="#" class="employee-link" data-toggle="modal" data-target="#userModal"
                                    data-department="{{ $summary['department_name'] }}" data-users="{{ $summary['total_offs'] }}"
                                   
                                    data-employees="{{ json_encode($summary['employees']) }}" data-empid="{{ json_encode($summary['employee_id']) }}"
                                
                                        data-offs="{{ json_encode($summary['offemployee']) }}"
                             
                                    data-absents= "{{json_encode($summary['absentemployee'])}}"
                                    data-leaves="{{json_encode($summary['leaveemployee'])}}"
                                   
                                    data-countClicked="offs">
                                    {{ $summary['total_offs'] }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>No data available for selected departments.</p>
                    @endif
                    <br>
                    <table class="table table-bordered" id="subtaskTablet">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Employee Name</th>
                                <th>Employee ID</th>
                                <th>Department</th>
                                <th>Working Days</th>
                                <th>Total (hrs) </th>
                                <th>Work Logged (hrs)</th>
                                <th style="width:8%">Total Leaves</th>
                                <th style="width:8%">Total Absents</th>
                                <th style="width:8%">Total Offs</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mergedDataw as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td> <a href="{{ route('user.dashboardreport', ['user' => $data['id'], 'start_date' => $startDatew.' 00:00:00', 'end_date' => $endDatew.' 23:59:00']) }}">{{ $data['name'] }} || {{ $data['designation'] }}</a></td>

                                <td>{{ $data['employee_id'] }}</td>
                                <td>{{ $data['department'] }}</td>
                                <td>{{ (($weeklyhours-$saturdaysCount)-($data['totalOffs']+$data['totalLeaves']+$data['totalAbsents']))+($saturdaysCount) }}</td>
                                <td>{{ (($weeklyhours-$saturdaysCount)-($data['totalOffs']+$data['totalLeaves']+$data['totalAbsents']))*8+($saturdaysCount*4) }}</td>
                                <td>{{ $data['time_spent'] }}</td>
                                <td>{{ $data['totalLeaves'] }}</td>
                                <td>{{ $data['totalAbsents'] }}</td>
                                <td>{{ $data['totalOffs'] }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    @endif
                    <!---end weekly report---->

                    @if(!empty($mergedData))
                    @if(isset($mergedData['error']))
                    <div class="alert alert-danger">
                        {{ $mergedData['error'] }}
                    </div>
                    @else
                   

                        @if (!empty($departmentSummaryoneday))
                        <h2>Department-wise Activity Report: {{$start_date_only}}</h2>
                        <table class="table table-bordered" id="subtaskTablesum">
                            <thead>
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Department</th>
                                    <th>Total Employees</th>
                                    <th>Man Days</th>
                                    <th>Work Logged (Days)</th>
                                    <th>Total Leaves</th>
                                    <th>Total Absents</th>
                                    <th>Total Offs</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departmentSummaryoneday as $summary)
                                <tr>
                                    @php

                                    $completeworkdays=(1)*$summary['total_users']-$summary['total_leaves']-$summary['total_absents']-$summary['total_offs'];
                                    $completeworkdaysops=$weeklyhours*$summary['total_users']-$summary['total_leaves']-$summary['total_absents']-$summary['total_offs'];

                                    $workdays= ($weeklyhourso)-$saturdaysCounto;
                                    $allworkingdays=$summary['total_users'] *($weeklyhourso) ;
                                    @endphp
                                    <!-- summary['saturday_duration'] -->
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $summary['department_name'] }}</td>
                                    <td>
                                    <a href="#" class="employee-link" data-toggle="modal" data-target="#userModal"
                                        data-department="{{ $summary['department_name'] }}" data-users="{{ $summary['total_users'] }}"
                                        data-employees="{{ json_encode($summary['employees']) }}" data-empid="{{ json_encode($summary['employee_id']) }}"
                                        data-offs="{{json_encode($summary['offemployee'])}}" data-absents= "{{json_encode($summary['absentemployee'])}}"
                                        data-leaves="{{json_encode($summary['leaveemployee'])}}"
                                        data-countClicked="total_users">
                                    {{ $summary['total_users'] }}
                                        </a>
                                    </td>
                                    <td>@if (in_array($summary['departmentids'], ['16','21','13']) or $summary['department_type']==1){{ $completeworkdaysops }} @else{{ $completeworkdays }}@endif</td>
                                    @php
                                    $totalTimeSpent = is_numeric($summary['total_time_spent']) ? (float) $summary['total_time_spent'] : 0;
                                    $saturday_durationspent = is_numeric($summary['saturday_duration']) ? (float) $summary['saturday_duration'] : 0;

                                    $withoutsatspent=$totalTimeSpent-$saturday_durationspent;
                                    $withoutsatspentint=number_format($withoutsatspent / 8);
                                    $timeSpentPerDaysat = number_format($saturday_durationspent / 4);
                                    $totalactivitydur=$withoutsatspentint+$timeSpentPerDaysat;

                                    $totalTimeminusweek=$totalTimeSpent-$saturdaysCounto*4;
                                    $weekhours=$totalTimeSpent-$totalTimeminusweek;

                                    $timeSpentPerDaywithoutsat = number_format($totalTimeminusweek / 8);
                                    $timeSpentPerDaysat = number_format($weekhours / 4);
                                    $totaldaysspent=$timeSpentPerDaywithoutsat+$timeSpentPerDaysat;

                                    $timeSpentPerDay = number_format($totalTimeSpent / 8);



                                    $minusweek=$timeSpentPerDay-($timeSpentPerDay*$saturdaysCounto);
                                    $actualtimeSpent=($saturdaysCounto*$totalTimeSpent / 4);

                                    @endphp
                                    @if ($completeworkdays != 0)
                                    <td>@if (in_array($summary['departmentids'], ['16','21','13']) or $summary['department_type']==1){{ $timeSpentPerDay }} @else{{ $totalactivitydur }}@endif</td>

                                    @else
                                    <td>0</td> <!-- Or handle this case as you see fit -->
                                    @endif
                                    <td>
                                    <a href="#" class="employee-link" data-toggle="modal" data-target="#userModal"
                                        data-department="{{ $summary['department_name'] }}" data-users="{{ $summary['total_leaves'] }}"
                                    
                                        data-employees="{{ json_encode($summary['employees']) }}" data-empid="{{ json_encode($summary['employee_id']) }}"
                                    
                                            data-offs="{{ json_encode($summary['offemployee']) }}"
                                
                                        data-absents= "{{json_encode($summary['absentemployee'])}}"
                                        data-leaves="{{json_encode($summary['leaveemployee'])}}"
                                    
                                        data-countClicked="leaves">    
                                            {{ $summary['total_leaves'] }}
                                    </a>
                                </td>
                                    <td>
                                    <a href="#" class="employee-link" data-toggle="modal" data-target="#userModal"
                                        data-department="{{ $summary['department_name'] }}" data-users="{{ $summary['total_absents'] }}"
                                    
                                        data-employees="{{ json_encode($summary['employees']) }}" data-empid="{{ json_encode($summary['employee_id']) }}"
                                    
                                            data-offs="{{ json_encode($summary['offemployee']) }}"
                                
                                        data-absents= "{{json_encode($summary['absentemployee'])}}"
                                        data-leaves="{{json_encode($summary['leaveemployee'])}}"
                                    
                                        data-countClicked="absents">
                                        {{ $summary['total_absents'] }}
                                        </a>
                                    </td>
                                <!---Total Off button--->
                                    <td>
                                    <a href="#" class="employee-link" data-toggle="modal" data-target="#userModal"
                                        data-department="{{ $summary['department_name'] }}" data-users="{{ $summary['total_offs'] }}"
                                    
                                        data-employees="{{ json_encode($summary['employees']) }}" data-empid="{{ json_encode($summary['employee_id']) }}"
                                    
                                            data-offs="{{ json_encode($summary['offemployee']) }}"
                                
                                        data-absents= "{{json_encode($summary['absentemployee'])}}"
                                        data-leaves="{{json_encode($summary['leaveemployee'])}}"
                                    
                                        data-countClicked="offs">
                                        {{ $summary['total_offs'] }}
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <p>No data available for selected departments.</p>
                        @endif
                        <br>
                    <table class="table table-bordered" id="subtaskTablet">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th class="d-none">Employee Name</th>
                                <th>Employee Name</th>
                                <th>Employee ID</th>
                                <th>Department</th>
                                <th>Total (hrs) </th>
                                <th>Time Spent (hrs)</th>
                                <th>Work Logged (hrs)</th>
                                <th style="width:8%">Date</th>
                                <th style="width:8%">Time In</th>
                                <th style="width:8%">Time Out</th>
                                <th>Attendance Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mergedData as $index => $data)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="d-none">{{ $data['name'] }} || {{ $data['designation'] }}</td>
                                <td> <a href="{{ route('user.dashboardreport', ['user' => $data['id'], 'start_date' => $startDatesinglereport, 'end_date' => $endDatesinglereport]) }}">{{ $data['name'] }} || {{ $data['designation'] }}</a></td>
                                <td>{{ $data['employee_id'] }}</td>
                                <td>{{ $data['department'] }}</td>
                                <td>
<!-----$leave_status is in hours this is for deduction from estimated hours------->
                                    @php
                                        $leave_status = 0;
                                        $leave_statusops = 0;

                                        if(($data['attendance']=='OFF' || $data['attendance']=='Out Side Duty') && $data['time_spent']>0){
                                                echo "8.0";
                                        }

                                        

                                        if ($saturdaysCounto == 1) {
                                            if ($data['attendance'] == 'Present') {
                                                $leave_status = 0; $leave_statusops = 0;
                                            } elseif ($data['attendance'] == 'OFF' || $data['attendance'] == 'Leave' || $data['attendance'] == 'Absent') {
                                                $leave_status = 4; $leave_statusops = 8;
                                            } elseif ($data['attendance'] == 'Short Leave') {
                                                $leave_status = 1;   $leave_statusops = 2;
                                            } elseif ($data['attendance'] == 'Short Leave(WD)') {
                                                $leave_status = 1;  
                                            } elseif ($data['attendance'] == 'Half Day') {
                                                $leave_status = 2; $leave_statusops = 4;
                                            }
                                        } else {
                                            if ($data['attendance'] == 'Present') {
                                                $leave_status = 0; $leave_statusops = 0;
                                            } elseif ($data['attendance'] == 'OFF' || $data['attendance'] == 'Leave' || $data['attendance'] == 'Absent') {
                                                $leave_status = 8; $leave_statusops = 8;
                                            } elseif ($data['attendance'] == 'Short Leave') {
                                                $leave_status = 2;  $leave_statusops = 2;
                                            } elseif ($data['attendance'] == 'Short Leave(WD)') {
                                                $leave_status = 2;  
                                            } elseif ($data['attendance'] == 'Half Day') {
                                                $leave_status = 4; $leave_statusops = 4;
                                            }
                                        }
                                    @endphp
         
                                
                                @if($saturdaysCounto==1)
                                    @if (in_array($data['departmentid'], ['16','21','13']) || $data['department_type'] == 1 || ($data['departmentid'] == 2 && (
                                            stripos($data['designation'], 'Police') !== false ||
                                            stripos($data['designation'], 'PTO') !== false ||
                                            stripos($data['designation'], 'SCO') !== false ||
                                            stripos($data['designation'], 'PCO') !== false ||
                                            stripos($data['designation'], 'Communication') !== false)))
                                        {{8 - $leave_statusops }}
                                    @else
                                        {{4 - $leave_status }}
                                    @endif

                                 @else
                                 @if (in_array($data['departmentid'], ['16','21','13']) or $data['department_type']==1){{8-$leave_statusops }} @else{{8-$leave_status }}@endif
                                @endif
                                    </td>
                                <td>{{ $data['timeDifference'] }}</td>
                                <td>{{ $data['time_spent'] }}</td>
                                <td>{{ $data['date'] }}</td>
                                <td>{{ $data['inTime'] }}</td>
                                <td>{{ $data['outTime'] }}</td>
                                <td>{{ $data['attendance'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                    @endif


                    @if(empty($startDate))
                    <table class="table table-bordered" id="subtaskTablet">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th class="d-none">Employee Name</th>
                                <th>Employee Name</th>
                                <th>Employee ID</th>
                                <th>Department</th>
                                <th>Work Logged (hrs)</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userlist as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="d-none">{{ $user->name }} || {{ $user->designation }}</td>
                                <td>
                                    {{ $user->name }} || {{ $user->designation }}
                                </td>
                                <td>{{ $user->employee_id }}</td>
                                <td>{{ $user->dept->name ?? '' }}</td>
                                <td>{{ number_format($user->total_duration / 60, 1) }}</td>



                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif

                </div>
            </div>
             <!-- Modal -->
            <div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="userModalLabel">Department Users</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Department: <span id="departmentName"></span></p>
                            <p>Total Users: <span id="totalUsers"></span></p>
                            <table id="employeesTable" class="table">
                                <thead>
                                    <tr>
                                        <th>Serial No.</th>
                                        <th>Name</th>
                                        <th> Employee ID</th>
                                        <th> Leave</th>
                                        <th> Absent</th>
                                        <th> Off</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Dynamic rows will be added here -->
                                </tbody>
                            </table>
                            <!-- Additional content if needed -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>




        </div>
</section>
<!-- /.content -->
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.select2').select2();
        var table = $('#subtaskTablet').DataTable({
            dom: 'Bfrtip',
            buttons: ['pageLength',
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    title: 'User Report: <?php if (!empty($mergedDataw)) {
                                                                    echo $startDatew . ' to ' . $endDatew;
                                                                }
                                                                elseif(!empty($start_date_only)){
                                                                 echo   $start_date_only;
                                                                } ?>',
                    exportOptions: {
                        columns: ':not(.d-none)' // Exclude columns with the class "d-none"
                    }
                },
                // 'colvis'
            ]
        });
        $('#userFilter').on('change', function() {
            var selectedUser = $(this).val();
            if (selectedUser === '') {
                table.columns(9).search('').draw();
            } else {
                table.columns(9).search('^' + selectedUser + '$', true, false).draw();
            }
        });
        $('#priorityFilter').on('change', function() {
            var filterValue = $(this).val();

            if (filterValue === "0") {
                table.column(6).search('^0(\.0+)?$', true, false).draw();
            } else if (filterValue === "less_than_6") {
                table.column(6).search('^(0(\.[0-9]+)?|[1-5](\.[0-9]+)?)$', true, false).draw();
            } else if (filterValue === "greater_equal_6") {
                table.column(6).search('^(6(\.[0-9]+)?|[7-9](\.[0-9]+)?|[1-9][0-9](\.[0-9]+)?)$', true, false).draw();
            } else if (filterValue === "greater_equal_7") {
                table.column(6).search('^(7(\.[0-9]+)?|[8-9](\.[0-9]+)?|[1-9][0-9](\.[0-9]+)?)$', true, false).draw();
            } else if (filterValue === "greater_equal_8") {
                table.column(6).search('^(8(\.[0-9]+)?|[9-9](\.[0-9]+)?|[1-9][0-9](\.[0-9]+)?)$', true, false).draw();
            } else {
                table.column(6).search('').draw();
            }
        });

        $('#priorityFiltere').on('change', function() {
            var filterValue = $(this).val();

            if (filterValue === "0") {
                table.column(5).search('^0(\.0+)?$', true, false).draw();
            } else if (filterValue === "less_than_6") {
                table.column(5).search('^(0(\.[0-9]+)?|[1-5](\.[0-9]+)?)$', true, false).draw();
            } else if (filterValue === "greater_equal_6") {
                table.column(5).search('^(6(\.[0-9]+)?|[7-9](\.[0-9]+)?|[1-9][0-9](\.[0-9]+)?)$', true, false).draw();
            } else if (filterValue === "greater_equal_7") {
                table.column(5).search('^(7(\.[0-9]+)?|[8-9](\.[0-9]+)?|[1-9][0-9](\.[0-9]+)?)$', true, false).draw();
            } else if (filterValue === "greater_equal_8") {
                table.column(5).search('^(8(\.[0-9]+)?|[9-9](\.[0-9]+)?|[1-9][0-9](\.[0-9]+)?)$', true, false).draw();
            } else {
                table.column(5).search('').draw();
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.select2').select2();
        var table = $('#subtaskTablesum').DataTable({
            dom: 'Bfrtip',
            buttons: ['pageLength',
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    title: 'Department-wise Activity Report: <?php if (!empty($mergedDataw)) {
                                                                    echo $startDatew . ' to ' . $endDatew;
                                                                } elseif(!empty($departmentSummaryoneday)) {
                                                                    echo $start_date_only;
                                                                } ?>',
                    exportOptions: {
                        columns: ':not(.d-none)' // Exclude columns with the class "d-none"
                    }
                },
                // 'colvis'
            ]
        });

    });
</script>
<script>
    $(document).ready(function() {
        $('#userModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var department = button.data('department'); // Extract info from data-* attributes
    var users = button.data('users');
    var employees = button.data('employees');
    var empIds = button.data('empid'); // Access empid from data-empid attribute
    var leaves = button.data('leaves');
    var absents = button.data('absents');
    var offs = button.data('offs');
    var countClicked = button.data('countclicked'); // Get the countClicked attribute

    console.log(leaves, offs, absents);

    var modal = $(this);
    modal.find('#departmentName').text(department);
    modal.find('#totalUsers').text(users);

    // Clear existing table rows and headers
    var tableHead = modal.find('#employeesTable thead tr');
    var tableBody = modal.find('#employeesTable tbody');
    tableHead.empty();
    tableBody.empty();

    // Define common headers
    tableHead.append('<th>Serial No.</th>');
    tableHead.append('<th>Name</th>');
    tableHead.append('<th>Employee ID</th>');

    if (countClicked === 'total_users') {
        // Add headers for all columns
        // tableHead.append('<th>Leave</th>');
        // tableHead.append('<th>Absent</th>');
        // tableHead.append('<th>Off</th>');

        // Show all users
        employees.forEach(function(employee, index) {
            tableBody.append(
                '<tr>' +
                    '<td>' + (index + 1) + '</td>' +
                    '<td>' + employee + '</td>' +
                    '<td>' + empIds[index] + '</td>' + // Include Employee ID
                   
                '</tr>'
            );
        });
    } else if (countClicked === 'offs') {
        // Add headers for specific columns
        tableHead.append('<th>Off</th>');

        // Show only users with Off count greater than 0
        employees.forEach(function(employee, index) {
            if (offs[index] > 0) {
                tableBody.append(
                    '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + employee + '</td>' +
                        '<td>' + empIds[index] + '</td>' + // Include Employee ID
                        '<td>' + offs[index] + '</td>' + 
                    '</tr>'
                );
            }
        });
    } else if (countClicked === 'absents') {
        // Add headers for specific columns
        tableHead.append('<th>Absent</th>');

        // Show only users with Absents count greater than 0
        employees.forEach(function(employee, index) {
            if (absents[index] >= 1) {
                tableBody.append(
                    '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + employee + '</td>' +
                        '<td>' + empIds[index] + '</td>' + // Include Employee ID
                        '<td>' + absents[index] + '</td>' + 
                    '</tr>'
                );
            }
        });
    } else if (countClicked === 'leaves') {
        // Add headers for specific columns
        tableHead.append('<th>Leave</th>');

        // Show only users with Leaves count greater than 0
        employees.forEach(function(employee, index) {
            if (leaves[index] >= 1) {
                tableBody.append(
                    '<tr>' +
                        '<td>' + (index + 1) + '</td>' +
                        '<td>' + employee + '</td>' +
                        '<td>' + empIds[index] + '</td>' + // Include Employee ID
                        '<td>' + leaves[index] + '</td>' + 
                    '</tr>'
                );
            }
        });
    }
});

$('#total-users-cell').click(function() {
    $('#usersModal').modal('show');
});




        $('#notificationIcon').click(function() {
            $('#notificationModal').modal('show');
        });
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
    });
</script>
<script>
    $('#daterange-btn').daterangepicker({
        ranges: {
            '1st Week': [moment().startOf('month'), moment().startOf('month').add(6, 'days')],
            '2nd Week': [moment().startOf('month').add(7, 'days'), moment().startOf('month').add(13, 'days')],
            '3rd Week': [moment().startOf('month').add(14, 'days'), moment().startOf('month').add(20, 'days')],
            '4th Week': [moment().startOf('month').add(21, 'days'), moment().startOf('month').add(27, 'days')],
            '5th Week': [moment().startOf('month').add(28, 'days'), moment().endOf('month')],
            'This Month (Till Date)': [moment().startOf('month'), moment()],
        },
        startDate: moment().subtract(1, 'months').startOf('month'),
        endDate: moment().subtract(1, 'days').endOf('day'),
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
        $('#startDate').val(sDate);
        $('#endDate').val(eDate);
        // table.ajax.reload();
    });
</script>
@endsection