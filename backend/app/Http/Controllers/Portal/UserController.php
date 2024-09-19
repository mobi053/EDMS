<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


// Models
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;


class UserController extends Controller
{
    public function index()

    {
   
        return view('portal.users.index');
    }

    public function user_report(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dept = $request->input('dept');
        $depart = $request->input('dept');
        $userName = $request->input('user');


        $startdatetime = now()->setTimezone('Asia/Karachi')->format('Y-m-d\T00:00');
        $enddatetime = now()->setTimezone('Asia/Karachi')->format('Y-m-d\T23:59');
        $userlist = User::select('users.id', 'users.name', 'users.employee_id', 'users.designation', 'users.department', DB::raw('SUM(activities.duration) as total_duration'))
            ->leftJoin('activities', function ($join) use ($startdatetime, $enddatetime) {
                $join->on('users.id', '=', 'activities.created_by')
                    ->whereBetween('activities.created_at', [$startdatetime, $enddatetime]);
            })
            ->when(auth()->user()->department_type == 1, function ($query) {
                // If department_type is 1, filter users by department_type 1
                return $query->where('users.department_type', 1);
            }, function ($query) {
                // If department_type is not 1, do not apply any specific department_type filter
                return $query; // This is where we ensure no additional filter is applied
            })
            ->when($depart, function ($query) use ($depart) {
                return $query->where('users.department', $depart);
            })
            ->groupBy('users.id', 'users.name', 'users.employee_id', 'users.designation', 'users.department')
            ->get();
            // dd($userlist);



        // $ctask = Task::whereIn("id", $taskIdsFromSQLstat)->where('status', 1)->get();
        $alluser = User::all();
        $department = Category::whereNotIn('id', [999, 20, 8])->get();

        // Your logic here

        return view('portal.users.userreport', compact('alluser', 'department', 'depart', 'userlist', 'userName', 'startDate', 'endDate'));
    }

    public function depart_report(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dept = $request->input('dept');
        $depart = $request->input('dept');
        $userName = $request->input('user');


        $startdatetime = now()->setTimezone('Asia/Karachi')->format('Y-m-d\T00:00');
        $enddatetime = now()->setTimezone('Asia/Karachi')->format('Y-m-d\T23:59');

        $userlist = User::select('users.id', 'users.name', 'users.employee_id', 'users.designation', 'users.department', DB::raw('SUM(activities.duration) as total_duration'))
            ->leftJoin('activities', function ($join) use ($startdatetime, $enddatetime) {
                $join->on('users.id', '=', 'activities.created_by')
                    ->whereBetween('activities.created_at', [$startdatetime, $enddatetime]);
            })
            ->when($depart, function ($query) use ($depart) {
                return $query->where('users.department', $depart);
            })
            ->groupBy('users.id', 'users.name', 'users.employee_id', 'users.designation', 'users.department')
            ->get();



        // $ctask = Task::whereIn("id", $taskIdsFromSQLstat)->where('status', 1)->get();
        $alluser = User::all();
        if(auth()->user()->id==317){
            $department = Category::where('department_type', 1)->get();
            // dd($department);

        } else{
            $department = Category::whereNotIn('id', [999, 20, 8])->get();
        }

        // Your logic here

        return view('portal.users.depart_report', compact('alluser', 'department', 'depart', 'userlist', 'userName', 'startDate', 'endDate'));
    }

    public function user_reportfetch(Request $request)
    {
        $userid = $request->user;
        $empid = User::where('id', $userid)->value('employee_id');
        // dd($empid);
        $start_date_only = date('Y-m-d', strtotime($request->start_date));
        $end_date_only = date('Y-m-d', strtotime($request->end_date));
        $department = 0;
        //dd($start_date_only);

        try {
            $url = 'http://10.22.16.119:555/api/HRMS/GetEmployeeAttendance?startDate=' . $start_date_only . '&endDate=' . $end_date_only . '&empCode=' . $empid;

            // Use file_get_contents to send the GET request
            $response = file_get_contents($url);

            if ($response === FALSE) {
                throw new Exception('Error fetching data from the API');
            }

            // Decode the JSON response
            $data = json_decode($response, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Error decoding JSON response: ' . json_last_error_msg());
            }

            // Return the response as JSON
            $data = json_encode(['data' => $data]);
        } catch (Exception $e) {
            $data = "";
        }
// dd($data);
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $dept = $request->dept;
        $depart = $request->dept;



        $request->validate([
            'end_date' => 'required|after:' . $startDate,
        ]);


        $userlist = User::select('users.id', 'users.name', 'users.employee_id', 'users.designation', 'users.department', DB::raw('SUM(activities.duration) as total_duration'))
            ->leftJoin('activities', function ($join) use ($startDate, $endDate) {
                $join->on('users.id', '=', 'activities.created_by')
                    ->whereBetween('activities.created_at', [$startDate, $endDate]);
            })
            ->when(auth()->user()->department_type == 1, function ($query) {
                // If department_type is 1, filter users by department_type 1
                return $query->where('users.department_type', 1);
            }, function ($query) {
                // If department_type is not 1, do not apply any specific department_type filter
                return $query; // This is where we ensure no additional filter is applied
            })
            ->when($depart, function ($query) use ($depart) {
                return $query->where('users.department', $depart);
            })
            ->groupBy('users.id', 'users.name', 'users.employee_id', 'users.department', 'users.designation')
            ->get();

        // Get all dates between $startDate and $endDate
        $useridd = $userid;
        $userName = $userid;
        $usern = User::where('id', $useridd)->get(); // or ->get() if expecting multiple users
        $dates = Carbon::parse($startDate)->daysUntil($endDate);


        // Fetch sum of duration for each date
        $results = Activity::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(duration) as total_duration'))
            ->where('created_by', $useridd)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderByDesc('date')
            ->get()
            ->pluck('total_duration', 'date')
            ->toArray();

        // Fill in missing dates with 0
        foreach ($dates as $date) {
            $formattedDate = $date->toDateString();
            if (!isset($results[$formattedDate])) {
                $results[$formattedDate] = 0;
            }
        }
        //combined attendance with user table

        ///end combined attendance with user table

        // $ctask = Task::whereIn("id", $taskIdsFromSQLstat)->where('status', 1)->get();
        $alluser = User::all();
        $department = Category::whereNotIn('id', [999, 20, 8])->get();
        $users = $usern->first();
        // Your logic here


        // Your logic here

        return view('portal.users.userreport', compact('alluser', 'department', 'depart', 'userlist', 'userName', 'startDate', 'endDate', 'data', 'results', 'users'));
    }

    public function departsingle_reportfetch(Request $request)
    {
        $startDatew = $request->input('startDate');
        $endDatew = $request->input('endDate');
        $startDatelist = $request->input('startDate') . 'T00:00';;
        $endDatelist = $request->input('endDate') . 'T23:59';
        // dd($endDatew);
        $start_date_only = $request->start_date;
       $end_date_only = $request->start_date;
        $tomorrowday = Carbon::parse($request->start_date)->addDay()->toDateString();
        // $end_date_only=$tomorrowday. 'T06:45';
        $department = 0;
        $startDate = $request->start_date . 'T00:00';
        $endDate = $request->start_date . 'T23:59';
        $startDatesinglereport = $request->start_date . 'T06:45';
        $endDatesinglereport = $tomorrowday. 'T06:45';
        $dept = $request->dept;
        $depart = $request->dept;
        $userName = $request->user;
        $depart = $request->input('dept', []);

        $endDated = Carbon::parse($endDatelist, 'Asia/Karachi');
        $startDated = Carbon::parse($startDatelist, 'Asia/Karachi');
        $endDatedo = Carbon::parse($endDate, 'Asia/Karachi');
        $startDatedo = Carbon::parse($startDate, 'Asia/Karachi');

        $saturdaysCount = 0;

        // Loop through each day in the date range


        // Calculate the difference in minutes
        $minutesDifferenced = $endDated->diffInMinutes($startDated);

        // Convert the difference to hours as a decimal
        $hoursDifferenced = $minutesDifferenced / 1440;

        // Output the difference
        $weeklyhours = (int)round($hoursDifferenced);
        // dd($weeklyhours);
        for ($date = $startDated; $date->lte($endDated); $date->addDay()) {
            if ($date->isSaturday()) {
                $saturdaysCount++;
            }
        }

        $saturdaysCounto = 0;

        // Loop through each day in the date range


        // Calculate the difference in minutes
        $minutesDifferencedo = $endDatedo->diffInMinutes($startDatedo);

        // Convert the difference to hours as a decimal
        $hoursDifferencedo = $minutesDifferencedo / 1440;

        // Output the difference
        $weeklyhourso = (int)round($hoursDifferencedo);
        // dd($weeklyhours);
        for ($date = $startDatedo; $date->lte($endDatedo); $date->addDay()) {
            if ($date->isSaturday()) {
                $saturdaysCounto++;
            }
        }
        //  dd($saturdaysCount);
        // $userlistw =User::select(
        //     'users.id',
        //     'users.name',
        //     'users.employee_id',
        //     'users.designation',
        //     'users.department',
        //     DB::raw('SUM(activities.duration) as total_duration')
        // )
        // ->leftJoin('activities', function($join) use ($startDatelist, $endDatelist) {
        //     $join->on('users.id', '=', 'activities.created_by')
        //          ->whereBetween('activities.created_at', [$startDatelist, $endDatelist]);
        // })
        // ->when($depart, function($query) use ($depart) {
        //     return $query->whereIn('users.department', $depart);
        // })
        // ->groupBy('users.id', 'users.name', 'users.employee_id', 'users.department', 'users.designation')
        // ->get();
        $start = Carbon::parse($startDatelist);
        $end = Carbon::parse($endDatelist);

        $userlistw = User::select(
            'users.id',
            'users.name',
            'users.employee_id',
            'users.designation',
            'users.department',
            DB::raw('SUM(activities.duration) as total_duration'),
            DB::raw('SUM(CASE WHEN DAYOFWEEK(activities.created_at) = 7 THEN activities.duration ELSE 0 END) as saturday_duration')
        )
            ->leftJoin('activities', function ($join) use ($startDatelist, $endDatelist) {
                $join->on('users.id', '=', 'activities.created_by')
                    ->whereBetween('activities.created_at', [$startDatelist, $endDatelist]);
            })
            ->when($depart, function ($query) use ($depart) {
                return $query->whereIn('users.department', $depart);
            })
            ->groupBy('users.id', 'users.name', 'users.employee_id', 'users.department', 'users.designation')
            ->get();

            if(auth()->user()->id==317){
                $department = Category::where('department_type', 1)->get();
                // dd($department);

                } else{
                    $department = Category::whereNotIn('id', [999, 20, 8])->get();
            }        //weekly api for performance
        if (!empty($startDatew)) {
            $userlist = '';
            $attendanceData = '';
            $mergedData = '';
            $departmentSummaryoneday='';
            try {
                $urlw =  'http://10.22.16.119:555/api/HRMS/GetEmployeeAttendanceDetail?startDate=' . $startDatew . '&endDate=' . $endDatew;

                // Use file_get_contents to send the GET request
                $responsew = file_get_contents($urlw);

                if ($responsew === FALSE) {
                    throw new Exception('Error fetching data from the API');
                }

                // Decode the JSON response
                $attendanceDataw = json_decode($responsew, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception('Error decoding JSON response: ' . json_last_error_msg());
                }
            } catch (Exception $e) {
                $attendanceDataw = ['error' => $e->getMessage()];
            }

            // Assuming $userlist is already fetched and contains user data
            $mergedDataw = [];
            

            if (is_array($attendanceDataw) && !isset($attendanceDataw['error'])) {
                foreach ($userlistw as $userw) {
                    foreach ($attendanceDataw as $recordw) {
                        if ($recordw['code'] == $userw->employee_id) {
                            $mergedDataw[] = [
                                'sr_no' => null,
                                'name' => $userw->name,
                                'id' => $userw->id,
                                'designation' => $userw->designation,
                                'employee_id' => $userw->employee_id,
                                'department' => $userw->dept->name ?? '',
                                'departmentid' => $userw->department ?? '',
                                'time_spent' => number_format($userw->total_duration / 60, 1),
                                'saturday_duration' => number_format($userw->saturday_duration / 60, 1),
                                'totalLeaves' => $recordw['totalLeaves'],
                                'totalAbsents' => $recordw['totalAbsents'],
                                'totalOffs' => $recordw['totalOffs'],
                            ];
                        }
                    }
                }
            } else {
                // Handle the case where there is an error in attendanceData or it's not an array
                $mergedDataw = [
                    'error' => $attendanceDataw['error'] ?? 'No data available'
                ];
            }
            // dd($mergedDataw);

     
            // Fetch department names for display
            $departments = Category::whereNotIn('id', [999, 20, 8])->get();

            // Initialize an array to hold department-wise summary
            $departmentSummary = [];

            // Loop through selected departments
            foreach ($depart as $departmentId) {
                $departmentName = Category::find($departmentId)->name;
                $departmentids = Category::find($departmentId)->id;
                $department_type = Category::find($departmentId)->department_type;

                // Calculate department-wise totals
                $totalTimeSpent = 0;
                $totalLeaves = 0;
                $totalAbsents = 0;
                $totalOffs = 0;
                $totalUsers = 0;
                $saturday_duration = 0;
                $employeeNames = [];
                $emp_id = [];
                $offemployee = [];
                $absentemployee = [];
                $leaveemployee = [];



                // dd($employeeNames);


                foreach ($mergedDataw as $data) {
                    if ($data['departmentid'] == $departmentId) {
                        $saturday_duration += (float) $data['saturday_duration'];
                        $totalTimeSpent += (float) $data['time_spent'];
                        $totalLeaves += (int) $data['totalLeaves'];
                        $totalAbsents += (int) $data['totalAbsents'];
                        $totalOffs += (int) $data['totalOffs'];
                        $totalUsers++;
                        $employeeNames[] = $data['name']; // Collecting employee names
                        $emp_id[] = $data['employee_id'];
                        $leaveemployee[] = $data['totalLeaves']; // Collecting employee names
                        $absentemployee[] = $data['totalAbsents']; // Collecting employee names
                        $offemployee[] = $data['totalOffs']; // Collecting employee names
                    }
                }

                // Store department-wise summary
                $departmentSummary[] = [
                    'departmentids' => $departmentids,
                    'department_type' => $department_type,
                    'department_name' => $departmentName,
                    'saturday_duration' => $saturday_duration,
                    'total_time_spent' => $totalTimeSpent,
                    'total_leaves' => $totalLeaves,
                    'total_absents' => $totalAbsents,
                    'total_offs' => $totalOffs,
                    'total_users' => $totalUsers,
                    'employees' => $employeeNames, // This should be an array of employee names
                    'employee_id' => $emp_id,
                    'leaveemployee' => $leaveemployee,
                    'absentemployee'=> $absentemployee,
                    'offemployee' => $offemployee
                ];
            }

            // dd($departmentSummary);


            // dd($emp_id);
        
        } else {
            $userlistw = '';
            $attendanceDataw = '';
            $mergedDataw = '';
            $departmentSummary = ''; 
            $departmentSummaryoneday = '';
            
            $userlist = User::select('users.id', 'users.name', 'users.employee_id', 'users.designation', 'users.department', DB::raw('SUM(activities.duration) as total_duration'), DB::raw('SUM(CASE WHEN DAYOFWEEK(activities.created_at) = 7 THEN activities.duration ELSE 0 END) as saturday_duration'))
                ->leftJoin('activities', function ($join) use ($startDatesinglereport, $endDatesinglereport) {
                    $join->on('users.id', '=', 'activities.created_by')
                        ->whereBetween('activities.created_at', [$startDatesinglereport, $endDatesinglereport]);
                })
                ->when($depart, function ($query) use ($depart) {
                    return $query->whereIn('users.department', $depart);
                })
                ->groupBy('users.id', 'users.name', 'users.employee_id', 'users.department', 'users.designation')
                ->get();
                // dd($endDatesinglereport);
            //weekly api for performance end
            try {
                $url = 'http://10.22.16.119:555/api/HRMS/GetEmployeeAttendance?startDate=' . $start_date_only . '&endDate=' . $end_date_only;

                // Use file_get_contents to send the GET request
                $response = file_get_contents($url);

                if ($response === FALSE) {
                    throw new Exception('Error fetching data from the API');
                }

                // Decode the JSON response
                $attendanceData = json_decode($response, true);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception('Error decoding JSON response: ' . json_last_error_msg());
                }
            } catch (Exception $e) {
                $attendanceData = ['error' => $e->getMessage()];
            }

            // dd($endDatesinglereport);
            // Assuming $userlist is already fetched and contains user data
            $mergedData = [];

            if (is_array($attendanceData) && !isset($attendanceData['error'])) {
                foreach ($userlist as $user) {
                    foreach ($attendanceData as $attendanceGroup) {
                        foreach ($attendanceGroup as $records) {
                            foreach ($records as $record) {
                                if ($record['code'] == $user->employee_id) {

                                    $timespent=number_format($user->total_duration / 60, 0);
                                    // Check if totalLeaves is 1 and totalAbsents is 1, set totalAbsents to 0
                                    if ($record['totalLeaves'] == 1 && $record['totalAbsents'] == 1) {
                                        $record['totalAbsents'] = 0;
                                        $record['attendaceStatus'] = 'Leave';
                                    }

                                    if (is_null($record['attendaceStatus'])) {
                                        $record['attendaceStatus'] = $record['attendaceStatusO'];
                                    }

                                    if ($record['timeDifference'] < $timespent) {
                                       
                                        $inTime= $record['inTime'];
                                        if($inTime!='-'){
                                        
                                        $inTimeCarbon = Carbon::createFromFormat('h:i:s A', $inTime);
                                       // Add the specified hours to the outTime
                                        $newouttime = $inTimeCarbon->addHours($timespent);

                                        // Format the new outTime to the desired format
                                        $record['outTime'] = $newouttime->format('h:i:s A');

                                        
                                        $diffInHours = $newouttime->floatDiffInHours($inTime);

                                        $record['timeDifference']=number_format($diffInHours,2);
                                        }
                                        else{
                                            //in case of osd or off intime is - carbon library does not manipulate it that is why fetch intime from intimeapi 

                                            //api call intime
                                            $currentdate = now()->setTimezone('Asia/Karachi')->format('Y-m-d');
                                            $empid=$user->employee_id;
                                           
                                            try {
                                               

                                                $url = 'http://10.22.16.119:555/api/HRMS/GetEmployeeInTime?empCode=' . $empid . '&date=' . $start_date_only . '';
                                                // dd($currentdate);
                            
                            
                                                //    $url = 'http://10.22.16.119:555/api/HRMS/GetEmployeeInTime?empCode='.$empid.'&date='.$currentdate.'';
                            
                                                // Use file_get_contents to send the GET request
                                                $response = file_get_contents($url);
                            
                                                if ($response === FALSE) {
                                                    throw new Exception('Error fetching data from the API');
                                                }
                            
                                                // Decode the JSON response
                                                $data = json_decode($response, true);
                            
                                                if (json_last_error() !== JSON_ERROR_NONE) {
                                                    throw new Exception('Error decoding JSON response: ' . json_last_error_msg());
                                                }
                            
                                                // Return the response as JSON
                                                $data = json_encode(['data' => $data]);
                                                $dataArray = json_decode($data, true);
                            
                                                // Fetch the 'inTime' value
                                                $inTime = $dataArray['data']['inTime'];
                            
                                              
                            
                                            } catch (Exception $e) {
                                                
                                                $inTime = '09:00:00 AM';
                                               
                                            }
                            
                                            if ($inTime == '') {

                                                $inTime = '09:00:00 AM';
                                            }
                                            //end api call intime
                                            $carbonTimeinn = Carbon::parse($inTime);

                                        // Format the time
                                        $inTime = $carbonTimeinn->format('h:i:s A'); // Outputs: 10:09:15 AM
                                        $record['inTime']=$inTime;

                                            // dd($inTime);

                                        // $inTime =     $record['inTime']=   '09:00:00 AM';
        
                                        $inTimeCarbon = Carbon::createFromFormat('h:i:s A', $inTime);
                                       // Add the specified hours to the outTime
                                        $newouttime = $inTimeCarbon->addHours($timespent);

                                        // Format the new outTime to the desired format
                                        $record['outTime'] = $newouttime->format('h:i:s A');


                                        
                                        $diffInHours = $newouttime->floatDiffInHours($inTime);

                                        $record['timeDifference']=number_format($diffInHours,2);


                                        }

                                        // end for osd and off 
                                    }


                                    
                                    $mergedData[] = [
                                        'sr_no' => null,
                                        'name' => $user->name,
                                        'id' => $user->id,
                                        'designation' => $user->designation,
                                        'employee_id' => $user->employee_id,
                                        'department' => $user->dept->name ?? '',
                                        'time_spent' => $timespent,
                                        'timeDifference' => $record['timeDifference'],
                                        'attendance' => $record['attendaceStatus'],
                                        'date' => $record['date'],
                                        'inTime' => $record['inTime'],
                                        'outTime' => $record['outTime'],
                                        'departmentid' => $user->department ?? '',
                                        'department_type' => $user->department_type ?? '',
                                        'saturday_duration' => number_format($user->saturday_duration / 60, 1),
                                        'totalLeaves' => $record['totalLeaves'],
                                        'totalAbsents' => $record['totalAbsents'],
                                        'totalOffs' => $record['totalOffs'],
                                    ];
                                }
                            }
                        }
                    }
                }
            }
             else {
                // Handle the case where there is an error in attendanceData or it's not an array
                $mergedData = [
                    'error' => $attendanceData['error'] ?? 'No data available'
                ];
            }
            //for one day report depart summary
             // Fetch department names for display
             $departments = Category::whereNotIn('id', [999, 20, 8])->get();

             // Initialize an array to hold department-wise summary
             $departmentSummaryoneday = [];
 
             // Loop through selected departments
             foreach ($depart as $departmentId) {
                 $departmentName = Category::find($departmentId)->name;
                 $departmentids = Category::find($departmentId)->id;
                 $department_type = Category::find($departmentId)->department_type;
 
                 // Calculate department-wise totals
                 $totalTimeSpent = 0;
                 $totalLeaves = 0;
                 $totalAbsents = 0;
                 $totalOffs = 0;
                 $totalUsers = 0;
                 $saturday_duration = 0;
                 $employeeNames = [];
                 $emp_id = [];
                 $offemployee = [];
                 $absentemployee = [];
                 $leaveemployee = [];
 
 
 
                 // dd($employeeNames);
 
 
                 foreach ($mergedData as $data) {
                     if ($data['departmentid'] == $departmentId) {
                         $saturday_duration += (float) $data['saturday_duration'];
                         $totalTimeSpent += (float) $data['time_spent'];
                         $totalLeaves += (int) $data['totalLeaves'];
                         $totalAbsents += (int) $data['totalAbsents'];
                         $totalOffs += (int) $data['totalOffs'];
                         $totalUsers++;
                         $employeeNames[] = $data['name']; // Collecting employee names
                         $emp_id[] = $data['employee_id'];
                         $leaveemployee[] = $data['totalLeaves']; // Collecting employee names
                         $absentemployee[] = $data['totalAbsents']; // Collecting employee names
                         $offemployee[] = $data['totalOffs']; // Collecting employee names
                     }
                 }
 
                 // Store department-wise summary
                 $departmentSummaryoneday[] = [
                     'departmentids' => $departmentids,
                     'department_type' => $department_type,
                     'department_name' => $departmentName,
                     'saturday_duration' => $saturday_duration,
                     'total_time_spent' => $totalTimeSpent,
                     'total_leaves' => $totalLeaves,
                     'total_absents' => $totalAbsents,
                     'total_offs' => $totalOffs,
                     'total_users' => $totalUsers,
                     'employees' => $employeeNames, // This should be an array of employee names
                     'employee_id' => $emp_id,
                     'leaveemployee' => $leaveemployee,
                     'absentemployee'=> $absentemployee,
                     'offemployee' => $offemployee
                 ];
             }
        }
// dd($departmentSummaryoneday);

        return view('portal.users.depart_report', compact('departmentSummary', 'startDatesinglereport', 'endDatesinglereport', 'departmentSummaryoneday', 'saturdaysCount', 'saturdaysCounto', 'weeklyhours', 'weeklyhourso', 'department', 'depart', 'userlist', 'userName', 'startDatew', 'endDatew', 'startDate', 'start_date_only', 'endDate', 'mergedData', 'mergedDataw'));
    }

    public function department_report(Request $request)
    {




        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $dept = $request->input('dept');
        $depart = $request->input('dept');
        $userName = $request->input('user');
        $startdatetime = now()->setTimezone('Asia/Karachi')->format('Y-m-d\T00:00');
        $enddatetime = now()->setTimezone('Asia/Karachi')->format('Y-m-d\T23:59');

        $userlist = User::select('users.id', 'users.name', 'users.employee_id', 'users.designation', 'users.department', DB::raw('SUM(activities.duration) as total_duration'))
            ->leftJoin('activities', function ($join) use ($startdatetime, $enddatetime) {
                $join->on('users.id', '=', 'activities.created_by')
                    ->whereBetween('activities.created_at', [$startdatetime, $enddatetime]);
            })
            ->when($depart, function ($query) use ($depart) {
                return $query->where('users.department', $depart);
            })
            ->groupBy('users.id', 'users.name', 'users.employee_id', 'users.department', 'users.designation')
            ->get();



        // $ctask = Task::whereIn("id", $taskIdsFromSQLstat)->where('status', 1)->get();
        $alluser = User::all();
        $department = Category::whereNotIn('id', [999, 20, 8])->get();

        // Your logic here

        return view('portal.users.departmentreport', compact('alluser', 'department', 'depart', 'userlist', 'userName', 'startDate', 'endDate'));
    }

    public function departmental_report_fetch(Request $request)
    {

        $start_date_only = date('Y-m-d', strtotime($request->start_date));
        $end_date_only = date('Y-m-d', strtotime($request->end_date));
        $department = 0;


        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $dept = $request->dept;
        $depart = $request->dept;
        $userName = $request->user;


        $request->validate([
            'end_date' => 'required|after:' . $startDate,
        ]);


        $userlist = User::select('users.id', 'users.name', 'users.employee_id', 'users.designation', 'users.department', DB::raw('SUM(activities.duration) as total_duration'))
            ->leftJoin('activities', function ($join) use ($startDate, $endDate) {
                $join->on('users.id', '=', 'activities.created_by')
                    ->whereBetween('activities.created_at', [$startDate, $endDate]);
            })
            ->when($depart, function ($query) use ($depart) {
                return $query->where('users.department', $depart);
            })
            ->groupBy('users.id', 'users.name', 'users.employee_id', 'users.department', 'users.designation')
            ->get();





        //combined attendance with user table

        ///end combined attendance with user table

        // $ctask = Task::whereIn("id", $taskIdsFromSQLstat)->where('status', 1)->get();

        $department = Category::whereNotIn('id', [999, 20, 8])->get();

        // Your logic here

        return view('portal.users.departmentreport', compact('department', 'depart', 'userlist', 'userName', 'startDate', 'endDate'));
    }


    public function ajaxdepartmental_report_fetch(Request $request)
    {

        $userId = $request->input('userId');
        $startDate =  $request->input('startDate');
        $endDate = $request->input('endDate');

        Log::info('Received request', [
            'userId' => $userId,
            'startDate' => $startDate,
            'endDate' => $endDate
        ]);

        $results = Activity::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(duration) as total_duration'))
            ->where('created_by', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get()
            ->pluck('total_duration', 'date')
            ->toArray();

        // Fill in missing dates with 0
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
        foreach ($period as $date) {
            $formattedDate = $date->toDateString();
            if (!isset($results[$formattedDate])) {
                $results[$formattedDate] = 0;
            }
        }

        Log::info('Returning results', $results);

        return response()->json($results);
    }


    public function add()
    {

       
        $users = User::all();
        $category = Category::whereNotIn('status', [6])->get();
        return view('portal.users.add', compact('users', 'category'));
    }

    public function edit($id)
    {
        $user = User::findorfail($id);
        $users = User::all();
        $categories = Category::all();
        $category = $user->category;
        return view('portal.users.edit', compact('user', 'users', 'category', 'categories'));
    }

    public function delete($id)
    {

        $product  = User::where('id', $id)->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }

    public function list(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = User::select('count(*) as allcount')->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->orWhere('email', 'like', '%' . $searchValue . '%')->orWhere('designation', 'like', '%' . $searchValue . '%')->orWhere('employee_id', 'like', '%' . $searchValue . '%')->count();
        $records = User::orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%')
                    ->orWhere('employee_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('designation', 'like', '%' . $searchValue . '%');
            })
            // /->where('role', 'Employee') // Add the condition for role
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();

        $data_arr = array();
        $serialNumber = $start + 1;


        foreach ($records as $record) {
            $route = route('user.edit', $record->id);
            $delete_route = route('user.delete', $record->id);


            $user = auth()->user();

                // User has at least one of the required permissions
                $action = '<div class="btn-group">';

                    $action .= '<a href="#" onclick="openRoleModal(' . $record->id . ')" class="mr-1 text-success" title="Grant Role">
                                    <i class="fa fa-plus"></i>
                                </a>';
                

                    $action .= '<a href="' . $route . '" class="mr-1 text-info" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>';
                

                    $action .= '<a href="#" onclick="delete_confirmation(\'' . $delete_route . '\')" class="mr-1 text-danger" title="Cancel">
                                    <i class="fa fa-times"></i>

                                </a>';
                

                $action .= '</div>';
       

            $target_route = 'userdashboard/index';
            $recordid = $record->id;
            $data_arr[] = array(
                "id" => $serialNumber++, // Assuming $iteration is your loop counter variable  "name" => '<a href="'.$target_route.'/'.$recordid.'">'.$record->name.'</a>',
                "name" => $record->name,
                "email" => $record->email,
                "employee_id" => $record->employee_id,
                "designation" => $record->designation,
                "phone" => $record->phone,
                "action" =>
                $action
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return \Response::json($response);
    }

    public function store(Request $request)
    {

            $request->validate([
                'email' => 'required|unique:users',
                'name' => 'required|max:150',
                'designation' => 'required|max:150',
                'phone' => 'required|max:11',
                'employee_id' => 'required|max:20',
                'password' => 'required|min:6|max:20',
                'unit_id' => 'required'

            ]);

            $unitid = $request->unit_id;
            $reportingpersonid = User::where('id', $unitid)->first()->reporting_persons;
            $reportingperonofunitid = array_merge([$unitid], json_decode($reportingpersonid, true) ?? []);
            $reportingperson = json_encode($reportingperonofunitid);
            $user = User::createUser($request->name, $request->employee_id, $request->email, $request->password, $request->designation, $request->phone, $request->unit_id, $request->department, $reportingperson);
            $user->givePermissionTo('view_task');
            $user->givePermissionTo('edit_task');
            $user->givePermissionTo('delete_task');
            $user->givePermissionTo('create_subtask');
            $user->givePermissionTo('edit_subtask');
            $user->givePermissionTo('delete_subtask');
            $user->givePermissionTo('view_subtask');
            $user->givePermissionTo('supervisor_stats');
            /*try {
            Mail::to($request->email)->send(new SignUp($request->name));
        } catch (\Exception $e) {
            return  $e->getMessage();
        }*/
            return redirect()->route('user.index')->with('success', 'User created successfully');
        
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required',
            'name' => 'required|max:100',
            'designation' => 'required|max:150',
            'phone' => 'required|size:11',
            'employee_id' => 'required|max:150',
            'unit_id' => 'required|max:11',

        ]);

        $unitid = $request->unit_id;
        $reportingpersonid = User::where('id', $unitid)->first()->reporting_persons;
        $reportingperonofunitid = array_merge([$unitid], json_decode($reportingpersonid, true) ?? []);
        $reportingperson = json_encode($reportingperonofunitid);

        User::where("id", $id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "employee_id" => $request->employee_id,
            "designation" => $request->designation,
            "phone" => $request->phone,
            "unit_id" => $request->unit_id,
            "department" => $request->department,
            "reporting_persons" => $reportingperson,
        ]);

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }
    public function verify_email($email)
    {
        /*$user = User::where('email', $email)->get();
        /* if ($user->email_verified_at != null) {
            return 'Already Verified';
        } else {*/

        User::where("email", $email)->update([
            "email_verified_at" => now()
        ]);
        /*}*/

        return redirect('/signin');
    }

    public function assign_permission(Request $request)
    {
        $userId = $request->user_id;
        $permissions = $request->permissions;

        // Retrieve the user
        $user = User::find($userId);

        // Attach the selected permissions to the user
        $user->syncPermissions($permissions);


        return redirect()->back()->with('success', 'Permissions assigned successfully');
    }


    public function get_permission($userId)
    {
        $user = User::find($userId);
        $allPermissions = Permission::all();
        $userPermissions = $user->permissions->pluck('name')->toArray();

        return response()->json([
            'allPermissions' => $allPermissions,
            'userPermissions' => $userPermissions,
        ]);
    }
    // UserController.php

    public function subtasks($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            abort(404); // User not found
        }

        $subtasks = $user->subtasks;

        return view('portal.users.subtasks', compact('user', 'subtasks'));
    }
}
