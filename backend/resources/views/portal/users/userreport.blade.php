@extends('portal.layout.appb')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1 class="m-0">User Report</h1><br>
                <form action="{{ route('user.user_reportfetch') }}" method="POST" class="user-report-form">
                    @csrf
                    <label for="start_date">Start Date</label>
                    <input type="datetime-local" id="start_date" name="start_date" placeholder="Enter Start Date" value="{{ $startDate ?? now()->setTimezone('Asia/Karachi')->format('Y-m-d\T00:00') }}" required>
                    <label for="end_date">End Date</label>
                    <input type="datetime-local" id="end_date" name="end_date" placeholder="Enter End Date" value="{{$endDate ?? now()->setTimezone('Asia/Karachi')->format('Y-m-d\T23:59') }}" required>
                    <select class="form-control d-inline-block col-2 mr-1 select2" name="user" id="user" required onchange="updateuser()">
                        <option value="">Select Employee</option>
                        @foreach($userlist as $user)
                        <option value="{{ $user->id }}" @if($userName==$user->id) selected @endif>{{ $user->name }} | {{ $user->designation }}</option>
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
<div class="container-fluid">
        <div class="card card-info card-outline">
        @if(empty($results) && empty($data))
            <div class="card-header">
                <div class="row">
                    <div class="col-12 user-report-form">

                        <select class="form-control d-inline-block col-2 mr-1 select2" id="userFilter" required>
                            <option value="">Select Employee</option>
                            @foreach($userlist as $user)
                            <option value="{{ $user->name }}">{{ $user->name }} | {{ $user->designation }}</option>
                            @endforeach
                        </select>
                        <select class="form-control d-inline-block col-2 mr-1" id="priorityFilter">
                            <option value="">Time Spent</option>
                            <option value="0">0</option>
                            <option value="less_than_6">Less than 6</option>
                            <option value="greater_equal_6">Greater or equal to 6</option>
                            <option value="greater_equal_7">Greater or equal to 7</option>
                            <option value="greater_equal_8">Greater or equal to 8</option>
                        </select>

                     
                        
                    </div>
                </div>
            </div>
        @endif
            <div class="card-body">
                <div class="table-responsive">
               



           
                            @if(!empty($results) && !empty($data))
                            @php
                                $decodedData = json_decode($data, true);
                            @endphp
                            <table class="table table-bordered"  id="subtaskTablet">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Employee Name</th>
                                        
                                        <th>Employee ID</th>
                                        <th>Department</th>
                                        <th>Work Logged (hrs)</th>
                                        <th style="width:8%">Date</th>
                                        <th style="width:8%">Time In</th>
                                        <th style="width:8%">Time Out</th>
                                        <th>Attendance Status</th>
                                       
                                        <th>View Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php
// Step 1: Collect the data into an array
$data = [];

foreach ($results as $date => $totalDuration) {
    foreach ($decodedData['data'] as $attendanceGroup) {
        foreach ($attendanceGroup as $code => $records) {
            foreach ($records as $record) {
                if ($record['totalLeaves'] == 1 && $record['totalAbsents'] == 1) {
                                        $record['totalAbsents'] = 0;
                                        $record['attendaceStatus'] = 'Leave';
                                    }

                                    if (is_null($record['attendaceStatus'])) {
                                        $record['attendaceStatus'] = $record['attendaceStatusO'];
                                    }
                if ($date == date('Y-m-d', strtotime($record['date'])) && $users->employee_id == $record['code']) {
                    $data[] = [
                        'iteration' => 0, // Placeholder, will set it later
                        'name' => $users->name,
                        'designation' => $users->designation,
                        'employee_id' => $users->employee_id,
                        'dept_name' => $users->dept->name ?? '',
                        'date' => $date,
                        'inTime' => $record['inTime'],
                        'outTime' => $record['outTime'],
                        'attendaceStatus' => $record['attendaceStatus'],
                        'totalDuration' => $totalDuration
                    ];
                }
            }
        }
    }
}

// Step 2: Sort the array by date
usort($data, function($a, $b) {
    return strtotime($a['date']) - strtotime($b['date']);
});
@endphp
@foreach($data as $index => $row)
    <tr>
        <td>{{ $index + 1 }}</td> <!-- Set iteration number here -->
        <td>  <a href="{{ route('user.dashboardreport', ['user' => $users->id, 'start_date' => $row['date'].' 00:00:00', 'end_date' => $row['date'].' 23:59:00']) }}">
            {{ $row['name'] }} || {{ $row['designation'] }}
                </a>
        </td>
       
        <td>{{ $row['employee_id'] }}</td>
        <td>{{ $row['dept_name'] }}</td>
        <td>{{ number_format($row['totalDuration'] / 60, 1) }}</td>
        <td>{{ $row['date'] }}</td>
        <td>{{ $row['inTime'] }}</td>
        <td>{{ $row['outTime'] }}</td>
        <td>{{ $row['attendaceStatus'] }}</td>
        
        <td> <a class="mr-1 text-blue" title="View Detail" href="{{ route('user.dashboardreport', ['user' => $users->id, 'start_date' => $row['date'].' 00:00:00', 'end_date' => $row['date'].' 23:59:00']) }}">
                      
                      <i class="fa fa-eye"></i> 
                  </a>

      
                          </td>
    </tr>
@endforeach
                                </tbody>
                            </table>
@elseif(!empty($startDate) && empty($data))

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
        Swal.fire({
            title: 'Error!',
            text: 'Service of API server is temporarily down',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../user/user-report";
            }
        });
    </script>
@else
<table class="table table-bordered" id="subtaskTablet">
                        <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th class="d-none">Employee Name</th>
                            <th>Employee Name</th>
                            <th>Designation</th>
                            <th>Employee ID</th>
                            <th>Department</th>
                            <th>Work Logged (hrs)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userlist as $user)
                        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="d-none">{{ $user->name }}</td>
            <td>
                @if(!empty($startDate) && !empty($endDate))
                    <a href="{{ route('user.dashboardreport', ['user' => $user->id, 'start_date' => $startDate, 'end_date' => $endDate]) }}">
                        {{ $user->name }}
                    </a>
                @else
                    {{ $user->name }}
                @endif
            </td>
            <td>{{ $user->designation }}</td>
            <td>{{ $user->employee_id }}</td>
            <td>{{ $user->dept->name ?? '' }}</td>
            <td>{{ number_format($user->total_duration / 60, 1) }} 
      
                            
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
           
                    @endif
         
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
                    title: 'User Report',
                    exportOptions: {
                        columns: ':not(.d-none)'  // Exclude columns with the class "d-none"
                    }
                },
                // 'colvis'
            ]
        });
        $('#userFilter').on('change', function() {
            var selectedUser = $(this).val();
            if (selectedUser === '') {
                table.columns(1).search('').draw();
            } else {
                table.columns(1).search('^' + selectedUser + '$', true, false).draw();
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
    });
</script>
<script>
    $(document).ready(function() {
        $('#notificationIcon').click(function() {
            $('#notificationModal').modal('show');
        });
    });
</script>
@endsection
