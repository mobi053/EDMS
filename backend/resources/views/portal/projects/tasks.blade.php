@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4><b>

            <h4><b>Project Detail</b></h4>

          </b></h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{route('project.index')}}">Project</a></li>
          <li class="breadcrumb-item active">Project Detail</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card card-info card-outline">
    @foreach($project as $proj)
    <div class="card-header">
      <div class="row">
        <div class="col-8">
          <div class="d-flex flex-column">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              <b>Project: {{$proj->name}}</b><br>
            </h3>
            <div class="text-muted">
              <span>&nbsp; <i class="fa fa-user"></i><b> Assigned by: </b> {{$proj->createdByUser->name ?? ''}} | </span>
              <span>&nbsp; <i class="fa fa-user"></i> <b> Assigned to: </b> {{$proj->project_manager->name ?? ''}}  | </span>
              <span class="time"><i class="fas fa-clock"></i> <b>Due Date: </b> {{!empty($proj->due_date) ? $proj->due_date : ''}} </span> <br>
            </div>
            <br>
            <div>
              <span> Project started from: {{$proj->start_date}}</span><br>
              @php
              $durationsumofactivities = 0;
              @endphp
              @foreach($tasks as $task)
              @foreach($task->subtasks as $subtask)
              @foreach($subtask->activities as $activity)
              @php
              $durationsumofactivities +=$activity->duration;
              @endphp
              @endforeach
              @endforeach
              @endforeach
              @php
              if (!function_exists('convertMinutesToTime')) {
                function convertMinutesToTime($minutes) {
                $months = floor($minutes / (30 * 24 * 60)); // Assuming a month is 30 days
                $days = floor(($minutes % (30 * 24 * 60)) / (24 * 60));
                $hours = floor(($minutes % (24 * 60)) / 60);
                $minutes = $minutes % 60;

                  return [
                  'months' => $months,
                  'days' => $days,
                  'hours' => $hours,
                  'minutes' => $minutes
                  ];
                }
              }

              $convertedTime = convertMinutesToTime($durationsumofactivities);
              @endphp

              <span>Project Duration:
                @if ($convertedTime['months'] > 0)
                {{ $convertedTime['months'] }} months
                @endif
                @if ($convertedTime['days'] > 0)
                {{ $convertedTime['days'] }} days
                @endif
                @if ($convertedTime['hours'] > 0)
                {{ $convertedTime['hours'] }} hours
                @endif
                @if ($convertedTime['minutes'] > 0)
                {{ $convertedTime['minutes'] }} minutes
                @endif
              </span>
            </div>
            <div>
                @php
                $completeTasks = 0;
                $ownedTasks = 0;
                $inProgressTasks  = 0;
                $blockedTasks   = 0;
                $onHoldTasks  = 0;
                $cancelledTasks  = 0;
                $approvedTasks = 0;
                $notStartedYet = 0;
                @endphp

                @foreach($tasks as $task)
                  @php
                    if($task->status == 1) {
                      $completeTasks++;
                    } elseif($task->status == 2) {
                      $ownedTasks++;
                    } elseif($task->status == 3) {
                      $inProgressTasks++;
                    } elseif($task->status == 4) {
                      $blockedTasks++;
                    } elseif($task->status == 5) {
                      $onHoldTasks++;
                    } elseif($task->status == 6) {
                      $cancelledTasks++;
                    } elseif($task->status == 7) {
                      $approvedTasks++;
                    } elseif($task->status == 8) {
                      $notStartedYet++;
                    }
                  
                  @endphp
                @endforeach
                  @php
                    $allTasks= ($tasks->count());
                    if($allTasks>0){
                      $projectProgress= ($completeTasks/$allTasks)*100;
                    } else{
                      $projectProgress=0;
                    }
                  @endphp
                  <br>
                  <span> Total Tasks: {{$allTasks}}</span><br>
                  <span> Completed Tasks: {{$completeTasks}}</span><br>
                  <span> Others Tasks: {{$allTasks-$completeTasks}}</span><br>
              </div>
          </div>
        </div>
        @php
        $totalCompletedSubtaskProgress = 0;
        $totalTasks = count($tasks);
        @endphp
        <div class="col-4">
          <div class="row">
            <!-- Display average of completed subtask progress -->
            <div class="col-12 text-center">
              <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                <span> Project Progress: {{number_format($projectProgress, 2)}}%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <!-- The time line -->
            <div class="timeline">
              <!-- timeline time label -->
              @php
              $totalCompletedSubtaskProgress = 0;
              @endphp
              @foreach($tasks as $task)
              <div class="time-label">
                <span class="bg-primary">{{$task->title}}</span>
                @if($task->status==1)  <span class="bg-green"> Completed</span> @elseif($task->status==2)  <span class="bg-danger"> Owned</span> @elseif($task->status==4)  <span class="bg-danger"> Blocked</span>  @elseif($task->status==3)  <span class="bg-danger"> In progress</span> @elseif($task->status==5)  <span class="bg-warning"> On Hold</span> @elseif($task->status==6) <span class="bg-gray"> Cancelled</span> @elseif($task->status==7) <span class="bg-green"> Approved</span>   @endif
                @php
                $completedSubtaskProgress = 0;
                @endphp
                @foreach($task->subtasks as $subtask)
                @if($subtask->status == 1)
                @php
                $completedSubtaskProgress += $subtask->progress;
                $totalCompletedSubtaskProgress += $subtask->progress;
                @endphp
                @endif
                @endforeach
                <!-- <span class="bg-info">Overall Task Progress: {{$completedSubtaskProgress}}</span> -->

              </div>
              <div>
                <span class="counter bg-info"> {{$loop->iteration}}</span>
                <div class="timeline-item task-item" data-toggle="collapse" href="#collapse{{$loop->iteration}}" role="button" aria-expanded="false" aria-controls="collapse{{$loop->iteration}}">
                  <span class="time text-white"><i class="fas fa-user"></i>
                    Assigned to: {{$task->task_manager->name ?? ''}} | {{$task->task_manager->designation ?? ''}} &nbsp;
                    <?php
if ($task->task_assign) {
    $assignedtasks = json_decode($task->task_assign->collaborators);
} else {
    $assignedtasks = [];
}
?>
@if(is_array($assignedtasks))
    <i class="fas fa-user"></i> <span>Collaborator:
    @foreach($assignedtasks as $collaboratorId)
        <?php
        $collaborator = \App\Models\User::find($collaboratorId);
        $collaboratorName = $collaborator ? $collaborator->name : '';
        ?>
        {{$collaboratorName ? $collaboratorName : ''}}
        @if(!$loop->last), @endif
    @endforeach
    </span>
@endif
&nbsp;
<i class="fas fa-user"></i>

                    Assigned By: {{$task->task_creator->name ?? ''}} | {{$task->task_creator->designation ?? ''}}

                  </span>
                  <span class="time text-white"><i class="fas fa-clock"></i>
                    @php
                    $durationsumofsubtask = 0;
                    @endphp

                    @foreach($task->subtasks as $subtask)
                    @foreach($subtask->activities as $activity)
                    @php
                    $durationsumofsubtask += $activity->duration;
                    @endphp
                    @endforeach
                    @endforeach

                    <span>Task Duration:
                      @php
                      $convertedTaskTime = convertMinutesToTime($durationsumofsubtask);
                      @endphp

                      @if ($convertedTaskTime['months'] > 0)
                      {{ $convertedTaskTime['months'] }} months
                      @endif
                      @if ($convertedTaskTime['days'] > 0)
                      {{ $convertedTaskTime['days'] }} days
                      @endif
                      @if ($convertedTaskTime['hours'] > 0)
                      {{ $convertedTaskTime['hours'] }} hours
                      @endif
                      @if ($convertedTaskTime['minutes'] > 0)
                      {{ $convertedTaskTime['minutes'] }} minutes
                      @endif
                    </span>


                  </span>
                  <h3 class="timeline-header bg-info">{{$task->description}}</h3>
                </div>
                <div class="collapse" id="collapse{{$loop->iteration}}">
                @foreach($task->subtasks as $subtask)
                <div class="timeline-item subtask-item mt-3 px-3">
                  <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                      <span class="badge badge-danger mr-2"> {{$loop->parent->iteration}}.{{$loop->iteration}}</span>
                      <b class="text-danger">Subtask:{{$subtask->name}}</b>
                    </div>
                    <div class="d-flex">


                      <span class="time text-gray" style="padding-right: 10px;"><i class="fas fa-user"></i>
                        Performed By: {{$subtask->sub_task_creator->name ?? ''}} | {{$subtask->sub_task_creator->designation ?? ''}}
                      </span>
                      <span class="time text-danger mr-2"><i class="fas fa-clock"></i>
                        @php
                        $sumofallactivities=0;
                        @endphp

                        @foreach($subtask->activities as $activity)
                        @php
                        $sumofallactivities += $activity->duration;
                        @endphp
                        @endforeach

                        <span>
                          Time spent:
                          @php
                          $convertedTime = convertMinutesToTime($sumofallactivities);
                          @endphp

                          @if ($convertedTime['months'] > 0)
                          {{ $convertedTime['months'] }} months
                          @endif
                          @if ($convertedTime['days'] > 0)
                          {{ $convertedTime['days'] }} days
                          @endif
                          @if ($convertedTime['hours'] > 0)
                          {{ $convertedTime['hours'] }} hours
                          @endif
                          @if ($convertedTime['minutes'] > 0)
                          {{ $convertedTime['minutes'] }} minutes
                          @endif
                        </span>

                      </span>
                      <span class="">@if($subtask->status==1)
                        <i class="fas fa-check-circle text-success"></i>
                        @else

                        <i class="fas fa-exclamation-circle text-warning"></i>
                        @endif</span>
                    </div>
                  </div>


                  <h3 class="timeline-header" style="color:#343a40;">{{$subtask->description}} </h3>
                </div>
                @foreach($subtask->activities as $activity)
                <div class="timeline-item bg-secondary activity-item d-flex justify-content-between align-items-center mt-1 px-3">
                  <div class="d-flex align-items-center">
                    <span class="badge badge-activity"> {{$loop->parent->parent->iteration}}.{{$loop->parent->iteration}}.{{$loop->iteration}}</span>
                    <span class="timeline-header text-white ml-2">REMARKS:{{$activity->sub_description}} </span>
                  </div>

                  <span class="time text-white p-0">
                    <i class="fas fa-clock"></i>
                    {{$activity->created_at}}
                    <i class="fas fa-clock"></i>
                    @php
                    $convertedActivityTime = convertMinutesToTime($activity->duration);
                    @endphp

                    <span>
                      Log Time:
                      @if ($convertedActivityTime['months'] > 0)
                      {{ $convertedActivityTime['months'] }} months
                      @endif
                      @if ($convertedActivityTime['days'] > 0)
                      {{ $convertedActivityTime['days'] }} days
                      @endif
                      @if ($convertedActivityTime['hours'] > 0)
                      {{ $convertedActivityTime['hours'] }} hours
                      @endif
                      @if ($convertedActivityTime['minutes'] > 0)
                      {{ $convertedActivityTime['minutes'] }} minutes
                      @endif
                    </span> </span>

                </div>
                @endforeach
                @endforeach
                </div>
                
                <div>
                </div>
              </div>

              @endforeach

            </div>
          </div>
          <!-- /.col -->
        </div>
      </div>
      <!-- /.card -->
    </div>
</section>
@endsection

@section('script')
 <!-- Include Chart.js library -->
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
      // Define donutData
      var donutData = {
        labels: [
          'Completed',
          'Owned',
          'In progress',
          'Blocked',
          'On hold',
          'Cancelled',
          'Approved',
          'Not started yet'
        ],
       
        datasets: [{
          data: [
            {{$completeTasks}},
            {{$ownedTasks}},
            {{$inProgressTasks}},
            {{$blockedTasks}},
            {{$onHoldTasks}},
            {{$cancelledTasks}},
            {{$approvedTasks}},
            {{$notStartedYet}},
          ],
          backgroundColor: [
            '#FF6384',
            '#36A2EB',
            '#FFCE56',
            '#4BC0C0',
            '#9966FF',
            '#6c757d',
            '#28a745',
            '#800080'
          ],
        }]
      };

      // Get context with jQuery - using jQuery's .get() method.
      var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
      var pieOptions = {
        maintainAspectRatio: false,
        responsive: true,
         legend: {
          display: false
        },
        plugins: {
          legend: {
            display: false
          }
        }
        
      };

      // Create pie or doughnut chart
      new Chart(pieChartCanvas, {
        type: 'pie',
        data: donutData,
        options: pieOptions
      });
      
    });
</script>


@endsection