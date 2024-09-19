@extends('portal.layout.appb')

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-10">
                <h1 class="m-0">Department Wise Report</h1><br>
                <form action="{{ route('departmental_report.fetch') }}" method="POST">
                    @csrf
                    <label for="start_date">Start Date</label>
                    <input type="datetime-local" id="start_date" name="start_date" placeholder="Enter Start Date" value="{{ $startDate ??$startDate ?? now()->setTimezone('Asia/Karachi')->format('Y-m-d\T00:00') }}" required>
                    <label for="end_date">End Date</label>
                    <input type="datetime-local" id="end_date" name="end_date" placeholder="Enter End Date" value="{{$endDate ??$endDate ?? now()->setTimezone('Asia/Karachi')->format('Y-m-d\T23:59') }}" required>
               
                    <select class="form-control d-inline-block col-2 mr-1" name="dept" id="dept" required>
                        <option value="">Select Department</option>
                        @foreach($department as $dept)
                      
                        <option value="{{ $dept->id }}" @if($depart==$dept->id) selected @endif>{{ $dept->name }}</option>
                        @endforeach
                    </select>
                   
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div><!-- /.col -->
            <div class="col-sm-2">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Department Wise Report</li>
                   
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
            <div class="card-header">
                <div class="row">
                    <div class="col-12 user-report-form">

                        <select class="form-control d-inline-block col-2 mr-1 select2" id="userFilter">
                            <option value="">Select Employee</option>
                            @foreach($userlist as $user)
                            <option value="{{ $user->name }}">{{ $user->name }}</option>
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
            <div class="card-body">
                <div class="table-responsive">
               



           
                            @if(!empty($results) && !empty($data))
                            @php
                                $decodedData = json_decode($data, true);
                            @endphp
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Employee Name</th>
                                        <th>Designation</th>
                                        <th>Employee ID</th>
                                        <th>Department</th>
                                        <th>Date</th>
                                        <th>Attendance Status</th>
                                        <th>Time Spent (hrs)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($results as $date => $totalDuration)
                                        @foreach($decodedData['data'] as $attendanceGroup)
                                            @foreach($attendanceGroup as $code => $records)
                                                @foreach($records as $record)
                                                    @if ($date == date('Y-m-d', strtotime($record['date'])) && $users->employee_id == $record['code'])
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $users->name }}</td> <!-- Assuming 'name' is the attribute to display -->
                                                            <td>{{ $users->designation }}</td>
                                                            <td>{{ $users->employee_id }}</td>
                                                            <td>{{ $users->dept->name ?? '' }}</td>
                                                            <td>{{ $date }}</td>
                                                            <td>{{ $record['attendaceStatus'] }}</td>
                                                            <td>{{ number_format($totalDuration / 60, 1) }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>

           
                    @endif
                   <table class="table table-bordered" id="subtaskTablet">
                        <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th class="d-none">Employee Name</th>
                            <th>Employee Name</th>
                            <th>Designation</th>
                            <th>Employee ID</th>
                            <th>Department</th>
                            <th>Time Spent (hrs)</th>
                            @if(!empty($startDate) && !empty($endDate))
                            <th>View Detail</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($userlist as $user)
                        <tr>
            <td>{{ $loop->iteration }}</td>
            <td class="d-none">{{ $user->name }}</td>
            <td>
                    {{ $user->name }}
            </td>
            <td>{{ $user->designation }}</td>
            <td>{{ $user->employee_id }}</td>
            <td>{{ $user->dept->name ?? '' }}</td>
            <td>{{ number_format($user->total_duration / 60, 1) }}</td>
                           
            @if(!empty($startDate) && !empty($endDate))
            <td>
                           
                            <a href="#" class="mr-1 text-info add-activity-btn" 
                    title="View Detail" 
                    data-task-id="{{ $user->id }}" 
                    data-task-name="{{ $user->name }}" 
                    data-task-designation="{{ $user->designation }}"
                    data-task-employee-id="{{ $user->employee_id }}"
                    data-task-department="{{ $user->dept->name ?? '' }}"
                    data-toggle="modal" 
                    data-target="#addActivityModal">
                    <i class="fas fa-eye"></i>
                    </a>
                   
                            </td>
                            
                            @endif
                            
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

                 <!-- Add Activity Modal -->
                    <!-- Modal -->
                    <div class="modal fade" id="addActivityModal" tabindex="-1" role="dialog" aria-labelledby="addActivityModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addActivityModalLabel">User Report</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="table-responsive" id="modalTableContainer">
                                        <!-- Table to be populated dynamically -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Add Activity Modal -->


    </div>
</section>
<!-- /.content -->
@endsection

@section('script')
<script>



</script>
<script>
    function isoToSimpleDate(dateString) {
        ///////////////////////////////////////

        // Create a Date object from the input string
        const date = new Date(dateString);

        // Extract year, month, and day
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0'); // getMonth() is zero-based
        const day = String(date.getDate()).padStart(2, '0'); // Adding 3 days to the current date

        // Format the date to YYYY-MM-DD
        const formattedDate = `${year}-${month}-${day}`;

        console.log(formattedDate); // Output: 2024-06-04
        return formattedDate;
        //////////////////////////////////////
    }
    $(document).ready(function() {
            // Function to fetch user data based on user ID
// Function to fetch attendance data based on user ID
function fetchUserData(userId, startDate, endDate, userName, userDesignation, department, employeeId) {
    const attendanceApiUrl = `http://10.22.16.119:555/api/HRMS/GetEmployeeAttendance?empCode=${userId}&startDate=${startDate}&endDate=${endDate}`;

    fetch(attendanceApiUrl)
        .then(response => response.json())
        .then(async (data) => {
            // Clear previous table content
            document.getElementById('modalTableContainer').innerHTML = '';

            // Build the table dynamically
            const table = document.createElement('table');
            table.className = 'table table-bordered';
            const thead = document.createElement('thead');
            const tbody = document.createElement('tbody');

            // Create table header row
            const headerRow = document.createElement('tr');
            headerRow.innerHTML = `
                <th style="width:10%">Date</th>
                <th>Employee Name</th>
                <th>Designation</th>
                <th>Employee ID</th>
                <th>Department</th>
                
                <th>Attendance Status</th>
                <th>Time Spent (hrs)</th>
            `;
            thead.appendChild(headerRow);
            let timeSpent = await fetchActivitiesData(employeeId, startDate, endDate)
            let timeSpentDates = Object.keys(timeSpent);
            console.log()
            // Create table body rows
            data.map((record, index) => {
                let uid = Object.keys(record);
                let attd = record[uid];
                attd.map((a, i) => {
                    let attendDate = isoToSimpleDate(a.date)

                    timeSpentDates.map((dt,i)=> {
                        if ( dt === attendDate ) {

                      
                    const row = document.createElement('tr');
                    row.innerHTML = `
                    <td>${attendDate}</td>
                        <td><a href="../userdashboard/dashboardreport?user=${employeeId}&start_date=${attendDate} 00:00:00&end_date=${attendDate} 23:59:00">${userName}</a></td>
                        <td>${userDesignation}</td>
                        <td>${userId}</td>
                        <td>${department}</td>
                       
                        <td>${a.attendaceStatus}</td>
                        <td>${(timeSpent[dt] / 60).toFixed(1)}</td>

                    `;
                    tbody.appendChild(row);
                }
                    })
                });
            });

            // Append thead and tbody to the table
            table.appendChild(thead);
            table.appendChild(tbody);

            // Append the table to modal's table container
            document.getElementById('modalTableContainer').appendChild(table);

            // Fetch and update the time spent data
            //fetchActivitiesData(userDesignation, startDate, endDate);
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
        });
}

// Function to fetch activities data and update the table
// Function to fetch activities data and update the table
// Function to fetch activities data and update the table
async function fetchActivitiesData(userId, startDate, endDate) {
    const activitiesApiUrl = `{{ route('activity.listed') }}`;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let response = 'abc';

    await fetch(activitiesApiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken // Include CSRF token if needed
        },
        body: JSON.stringify({
            userId: userId,
            startDate: startDate,
            endDate: endDate
        })
    })
    .then(async (response) => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return await response.json();
    })
    .then(data => {
        // Process the activities data to calculate total duration per day
        response = data
    })
    .catch(error => {
        console.error('Error fetching activities data:', error);
    });
    return response;
}



$('.add-activity-btn').on('click', function(e) {
    const userId = e.target.parentNode.getAttribute('data-task-id');
    const userName = e.target.parentNode.getAttribute('data-task-name');
    const userDesignation = e.target.parentNode.getAttribute('data-task-designation');
    const employeeId = e.target.parentNode.getAttribute('data-task-employee-id');
    const department = e.target.parentNode.getAttribute('data-task-department');
    const startDate = $('#start_date').val(); // Replace with your start date variable or value
    const endDate = $('#end_date').val();
    fetchUserData(employeeId, startDate, endDate, userName, userDesignation, department, userId);
});

// Event listener for modal shown event (Bootstrap 4)
$('#addActivityModal').on('show.bs.modal', function(event) {
    // Your modal setup code here
});

// Example: Bind the openModal function to a click event on a link
document.addEventListener('DOMContentLoaded', () => {
    const addActivityButtons = document.querySelectorAll('.add-activity-btn');
    addActivityButtons.forEach(button => {
        button.addEventListener('click', () => {
            const userId = button.getAttribute('data-task-id');
            //openModal(userId);
        });
    });
});
        //upper is modal code
        $('.add-activity-btn').on('click', function() {
            // Retrieve the task ID associated with the clicked button
            var userId = $(this).data('task-id');
            var userName = $(this).data('task-title');
            // Log the task ID to ensure it's correct
            console.log('User ID:', userId);
        

            // Set the task title in the modal input field
            $('#task_title').val(userName);
            var taskProgress = $(this).data('task-progress')
            iProgress = parseInt(taskProgress);

            $('#progressSliderModal').slider('setValue', parseInt(taskProgress));

            // Populate any necessary fields in the modal
            $('#addActivityModal input[name="task"]').val(userId);
            $('#addActivityModal').modal('show');
        });

        $('.select2').select2();
        var table = $('#subtaskTablet').DataTable({
            dom: 'Bfrtip',
            buttons: ['pageLength',
                {
                    extend: 'excelHtml5',
                    text: 'Export to Excel',
                    title: 'Department Report',
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
<!-- <script>
    $(document).ready(function() {
        $('#notificationIcon').click(function() {
            $('#notificationModal').modal('show');
        });
    });
</script> -->
@endsection
