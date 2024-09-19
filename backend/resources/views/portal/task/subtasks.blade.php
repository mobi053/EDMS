@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4><b>Task Detail</b></h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{route('task.index')}}">Tasks</a></li>
          <li class="breadcrumb-item active">Task Detail</li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card card-info card-outline">
    @foreach($tasks as $task)
    <div class="card-header">
      <div class="row">
        <div class="col-6">
          <div class="d-flex flex-column">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              <b>Project: {{$task->task_project->name}}</b><br>
              <b>Task: {{$task->title}}</b>
            </h3>
            <div class="text-muted">
              <i class="fas fa-user"></i>
              <span> <b>Assigned by: </b> {{$task->task_creator->name ?? ''}} </span>
              <i class="fas fa-user"></i>
              <span><b>Assigned to: </b> {{$task->task_manager->name ?? ''}} </span>
              <span class="time"><i class="fas fa-clock"></i> Due Date: <b> {{!empty($task->duedate) ? $task->duedate : ''}} </b></span> <br>
              <?php $assignedtasks = json_decode($task->task_assign->collaborators ?? ''); ?>

              @if(is_array($assignedtasks) && !empty($assignedtasks))
              <span>Collaborators:
                @foreach($assignedtasks as $collaboratorId)
                <?php $collaboratorName = \App\Models\User::find($collaboratorId)->name ?? ''; ?>
                <b>{{$collaboratorName ? $collaboratorName : ''}}</b>
                @if(!$loop->last), @endif
                @endforeach
              </span>
              @endif
            </div>



            <div class="pt-2">
              {{$task->description}}
            </div>
            <div class="pt-2">
              Task status: <span style="color:#007bff;"> {{$task->status_name->name ?? ''}} </span>
            </div>
            <div class="pt-2">
              Task Estimated Time: <span style="color:#007bff;"> {{$task->estimated_time ?? ''}} hours</span>
            </div>
            <div class="pt-2">
              Total Duration: <span style="color:#007bff;"> {{$totalDuration/60}} hours</span>
            </div>
          </div>
        </div>
        <div class="col-6">

          <div id="databaseAttachments" style="white-space: nowrap; overflow-x: auto; text-align: center;">
            @if($attachment->isNotEmpty())
            <span>Attachments:</span>
            @endif
            @foreach ($attachment as $attachments)
            <div class="attachment-item" style="display: inline-block; margin-right: 10px; vertical-align: top;">
              @if (strpos($attachments->url, '.jpg') || strpos($attachments->url, '.jpeg') || strpos($attachments->url, '.png') || strpos($attachments->url, '.gif'))
              <a target="_blank" href="{{ asset($attachments->url) }}"><img src="{{ asset($attachments->url) }}" style="max-width: 100px; max-height: 100px; margin: 5px;"></a>
              @elseif (strpos($attachments->url, '.mp4') || strpos($attachments->url, '.avi') || strpos($attachments->url, '.mov'))
              <a target="_blank" href="{{ asset($attachments->url) }}"><video src="{{ asset($attachments->url) }}" controls style="max-width: 100px; max-height: 100px; margin: 5px;"></video></a>
              @elseif (strpos($attachments->url, '.pdf'))
              <a target="_blank" href="{{ asset($attachments->url) }}"><embed src="{{ asset($attachments->url) }}" type="application/pdf" style="max-width: 100px; max-height: 100px; margin: 5px; overflow: hidden;"></a>
              @elseif (strpos($attachments->url, '.xlsx') || strpos($attachments->url, '.xls'))
              <a target="_blank" href="{{ asset($attachments->url) }}"><iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ asset($attachments->url) }}" style="max-width: 100px; max-height: 100px; margin: 5px;"></iframe></a>
              @elseif (strpos($attachments->url, '.docx') || strpos($attachments->url, '.doc'))
              <a target="_blank" href="{{ asset($attachments->url) }}"><iframe src="https://view.officeapps.live.com/op/view.aspx?src={{ asset($attachments->url) }}" style="max-width: 100px; max-height: 100px; margin: 5px;"></iframe></a>
              @else
              <a class="btn btn-secondary" target="_blank" href="{{ asset($attachments->url) }}">Attachment {{ $loop->iteration }}</a>
              @endif
              <!-- Remove button -->
            </div>
            @endforeach
          </div>


          @if(auth()->user()->hasPermissionTo('create_subtask'))
          <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#addActivityModal">
            Add Subtask
          </button>
          @endif

          <!-- Add Activity Modal -->
          <div class="modal fade" id="addActivityModal" tabindex="-1" role="dialog" aria-labelledby="addActivityModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="addActivityModalLabel">Add Subtask</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form action="{{ route('subtask.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                      <label for="task_title">Task*</label>
                      @foreach($tasks as $task)
                      <input type="hidden" name="task" value="{{ $task->id }}">
                      <input type="text" class="form-control" value="{{ $task->title }}" readonly>
                      @endforeach
                    </div>

                    <div class="form-group">
                      <label for="subtaskName">Subtask Name *</label>
                      <input type="text" class="form-control" required name="name" value="{{ old('name') }}" id="subtaskName" placeholder="Name">
                    </div>
                    <div class="form-group">
                      <label for="description">Subtask Description *</label>
                      <textarea class="form-control" rows="3" required name="description" id="description" placeholder="Description">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group d-none">
                      <label for="start_datetime">Start Time/Date *</label>
                      <input type="datetime-local" class="form-control" name="start_datetime" id="start_datetime" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i') }}" placeholder="Start Time/Date">
                    </div>
                    <div class="form-group d-none">
                      <label for="end_datetime">End Time/Date *</label>
                      <input type="datetime-local" class="form-control" name="end_datetime" id="end_datetime" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i') }}" placeholder="End Time/Date">
                    </div>
                    <div class="form-group">
                      <label for="duration">Estimated Time (hrs) *</label>
                      <input type="number" class="form-control" required name="estimated_time" id="duration" placeholder="Estimated Time (hrs)" min="0.5" step="0.5">
                    </div>
                    <div class="form-group d-none">
                      <label for="due_date">Due Date</label>
                      <input type="date" class="form-control" name="due_datetime" id="due_date" placeholder="Due Date">
                    </div>
                    @if(auth()->user()->department_type==1)
                    <div class="form-group">
                      <label>Access Level</label>
                      <select name="deptops_global" class="form-control" required>
                        <option value="">Please choose access level</option>
                        <option value="1">All departments</option>
                        <option value="2">Selected department only</option>
                      </select>
                    </div>
                    @endif
                    <div class="form-group">
                      <label for="status">Subtask Status *</label>
                      <select class="form-control" name="status" id="status" required>
                        <option value="0">In Progress</option>
                        <option value="6">Pending</option>
                        <option value="2">On Hold</option>
                        <option value="3">Not Started Yet</option>
                        <option value="4">Cancelled</option>
                      </select>
                    </div>
                    <div class="form-group d-none">
                      <label for="task_status">Task Status</label>
                      <select class="form-control" name="task_status" id="task_status">
                        <option value="">Please Select Task Status</option>
                        <option value="5">Approved</option>
                        <option value="1">Completed</option>
                        <option value="0">In Progress</option>
                        <option value="3">On Hold</option>
                        <option value="4">Cancelled</option>
                      </select>
                    </div>
                    <div class="custom-control custom-checkbox">
                            <input name="goodwork" class="custom-control-input custom-control-input-success" type="checkbox" id="customCheckbox4">
                            <label for="customCheckbox4" class="custom-control-label">If you consider this good work, please check the box.</label>
                            </div>
                            <div class="form-group">
                               
                                <textarea class="form-control mt-2" rows="3" name="goodwork_description" id="goodwork_description" placeholder="Good Work Description">{{ old('goodwork_description') }}</textarea>
                            </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- End of Add Activity Modal -->


          <!-- <div class="knob-label">
      
      <span>Attachments:</span>
      @foreach ($attachment as $attachments)
        <a class="btn btn-secondary" target="_blank" href="{{ asset($attachments->url) }}"> {{ $loop->iteration }} </a>
        @endforeach
    </div> -->


        </div>
      </div>
    </div>
    @endforeach

    <div class="card-body">
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <div class="timeline" id="timeline-container">
            <!-- timeline time label -->

            @foreach($subtasks as $subtask)

            <div class="time-label">
              <span class="bg-red">{{$subtask->name}}</span>
              @if($subtask->status==0)
              <span class="bg-warning">In progress</span>
              @elseif($subtask->status==1)
              <span class="bg-success">Completed</span>
              @elseif($subtask->status==2)
              <span class="bg-success">On Hold</span>
              @elseif($subtask->status==3)
              <span class="bg-secondary">Not Started Yet</span>
              @elseif($subtask->status==4)
              <span class="bg-secondary">Cancelled</span>

              @elseif($subtask->status==6)
              <span class="bg-secondary">Pending</span>
              @endif
              <span class="bg-secondary">SubTask Estimated Time: {{$subtask->estimated_time}} Hours</span>
              @php
              $Sumofsubtaskduration = 0;
              @endphp
              @foreach($subtask->activities as $activity)
              @php
              $Sumofsubtaskduration += $activity->duration;
              @endphp
              @endforeach
            </div>


            <!-- /.timeline-label -->
            <!-- timeline item -->

            <div>
              <span class="counter bg-info"> {{$loop->iteration}}</span>
              <div class="timeline-item">
                <div class="d-flex timeline-header bg-info justify-content-between" data-toggle="collapse" href="#collapse{{$loop->iteration}}" role="button" aria-expanded="false" aria-controls="collapse{{$loop->iteration}}">
                  <span class="timeline-header bg-info" style="color:#343a40;">{{$subtask->description}}</span>
                  <div class="">

                    @if($Sumofsubtaskduration=='0')
                    <span class="text-white mr-2">
                      <i class="fas fa-clock"></i>
                      Time Spent:
                      0 minutes
                    </span>
                    @else
                    <span class="text-white mr-2">
                      <i class="fas fa-clock"></i>
                      Time Spent:
                      @if ($months = floor($Sumofsubtaskduration / (30 * 24 * 60)))
                      {{ $months }} months,
                      @endif
                      @if ($weeks = floor(($Sumofsubtaskduration % (30 * 24 * 60)) / (7 * 24 * 60)))
                      {{ $weeks }} weeks,
                      @endif
                      @if ($days = floor((($Sumofsubtaskduration % (30 * 24 * 60)) % (7 * 24 * 60)) / (24 * 60)))
                      {{ $days }} days,
                      @endif
                      @if ($hours = floor((($Sumofsubtaskduration % (30 * 24 * 60)) % (7 * 24 * 60) % (24 * 60)) / 60))
                      {{ $hours }} hours,
                      @endif
                      @if ($minutes = $Sumofsubtaskduration % 60)
                      {{ $minutes }} minutes
                      @endif
                    </span>
                    @endif
                    <span class="time text-white"><i class="fas fa-user"></i> Performed By: {{$subtask->sub_task_creator->name}} | {{$subtask->sub_task_creator->designation}} </span>
                  </div>
                </div>


                <div class="collapse" id="collapse{{$loop->iteration}}">
                  @foreach($subtask->activities as $activity)
                  <div class="timeline-header d-flex justify-content-between mt-2">
                    <div class="d-flex">
                      <span class="badge badge-secondary mr-2"> {{$loop->parent->iteration}}.{{$loop->iteration}}</span>
                      <span class="timeline-header"> {{ $activity->sub_description }} </span>
                    </div>
                    <div class="d-flex">
                      <span class="time mr-2"><i class="fas fa-clock"></i>
                        Log Time:
                        <?php
                        $serialNumber = 1;
                        // Assuming $subtask->duration is the duration in minutes
                        $durationInMinutes = (int)$activity->duration;

                        // Calculate hours and minutes
                        $hours = floor($durationInMinutes / 60);
                        $minutes = $durationInMinutes % 60;

                        // Output the result

                        ?>
                        <?php

                        if ($hours > 0) {
                          echo "$hours hours";
                        }

                        if ($minutes > 0) {
                          echo ($hours > 0 ? ' and ' : '') . "$minutes minutes";
                        }

                        // If both hours and minutes are 0
                        if ($hours == 0 && $minutes == 0) {
                          echo "0 minutes";
                        }
                        ?>
                      </span>
                    </div>
                  </div>
                  @endforeach
                </div>
                <!-- <div class="timeline-body">
           
                   
           
              </div> -->
              </div>
            </div>
            @endforeach

          </div>

          <!-- Load More Button -->
          @foreach($tasks as $task)
          @if($task->subtasks->count() > 10)
          <div id="load-more-container" class="text-center">
            <button id="load-more" class="btn btn-primary">Load More</button>
          </div>
          @endif
          @endforeach
        </div>
        <!-- /.col -->
      </div>
    </div>
    <!-- /.card -->
  </div>
</section>
@endsection



@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    let offset = 10; // Number of records already loaded
    const limit = 10; // Number of records to load per request
    const taskid = {{ $taskid }}; // Blade syntax to render the PHP variable into JavaScript
    console.log(taskid);

    $('#load-more').click(function() {
      $.ajax({
        url: '{{ route("subtasks.loadMore") }}', // Adjust route as needed
        type: 'GET',
        data: {
          taskid: taskid,
          offset: offset,
          limit: limit
        },
        
        success: function(response) {

          if (response.subtasks.length > 0) {
            let subtasksHtml = '';
            response.subtasks.forEach(function(subtask, index) {
              const collapseId = `collapse${offset + index}`;
              let activitiesHtml = '';
              let totalDuration = 0;


              // Check if activities exist and are an array 
              if (Array.isArray(subtask.activities)) {
                subtask.activities.forEach(function(activity, activityIndex) {
                   // Add activity duration to totalDuration
                   totalDuration += parseInt(activity.duration);
                  console.log(totalDuration);
                  activitiesHtml += `
                                      <div class="timeline-header d-flex justify-content-between mt-2">
                                          <div class="d-flex">
                                              <span class="badge badge-secondary mr-2">${offset + index + 1}.${activityIndex + 1}</span>
                                              <span class="timeline-header">${activity.sub_description}</span>
                                          </div>
                                          <div class="d-flex">
                                              <span class="time mr-2"><i class="fas fa-clock"></i>
                                                  Log Time: ${formatTime(activity.duration)}
                                              </span>
                                          </div>
                                      </div>`;
                });
              }

              subtasksHtml += `
                            <div class="time-label">
                                <span class="bg-red">${subtask.name}</span>
                                <span class="bg-${getStatusColor(subtask.status)}">${subtask.subtask_status_name.name}</span>
                                <span class="bg-secondary"> SubTask Estimated Time: ${subtask.estimated_time} Hours</span>
                            </div>
                            <div>
                                <span class="counter bg-info">${offset + index + 1}</span>
                                <div class="timeline-item">
                                    <div class="d-flex timeline-header bg-info justify-content-between" data-toggle="collapse" href="#${collapseId}"
                                        role="button" aria-expanded="false" aria-controls="${collapseId}">
                                        <span class="timeline-header bg-info" style="color:#343a40;">${subtask.description}</span>
                                        <div class="">
                                            <span class="text-white mr-2">
                                                <i class="fas fa-clock"></i>
                                                 Time Spent: ${formatTime(totalDuration)},
                                            </span>
                                            <span class="time text-white"><i class="fas fa-user"></i> Performed By: ${subtask.user.name} |  ${subtask.user.designation} </span>
                                        </div>
                                    </div>
                                    <div class="collapse" id="${collapseId}">
                                        ${activitiesHtml} <!-- Activities HTML is inserted here -->
                                    </div>
                                </div>
                            </div>`;
            });
            $('#timeline-container').append(subtasksHtml);
            offset += limit; // Increment the offset
          } else {
            $('#load-more').hide(); // Hide the button if no more records
          }
        },
        error: function(xhr, status, error) {
          console.error('Error loading more subtasks:', error);
        }
      });
    });

    function getStatusColor(status) {
      switch (status) {
        case 0:
          return 'warning'; // In progress
        case 1:
          return 'success'; // Completed
        case 2:
          return 'success'; // On Hold
        case 3:
          return 'secondary'; // Not Started Yet
        case 4:
          return 'secondary'; // Cancelled
        case 6:
          return 'secondary'; // Pending
        default:
          return 'secondary'; // Default
      }
    }

    function formatTime(durationInMinutes) {
      const hours = Math.floor(durationInMinutes / 60);
      const minutes = durationInMinutes % 60;
      let timeString = '';

      if (hours > 0) {
        timeString += `${hours} hours`;
      }

      if (minutes > 0) {
        timeString += `${hours > 0 ? ' and ' : ''}${minutes} minutes`;
      }

      if (hours === 0 && minutes === 0) {
        timeString = '0 minutes';
      }

      return timeString;
    }
  });
</script>



<script>
  // $(function() {
  //   $('.knob').knob({
  //     /*change : function (value) {
  //      //console.log("change : " + value);
  //      },
  //      release : function (value) {
  //      console.log("release : " + value);
  //      },
  //      cancel : function () {
  //      console.log("cancel : " + this.value);
  //      },*/
  //     draw: function() {

  //       // "tron" case
  //       if (this.$.data('skin') == 'tron') {

  //         var a = this.angle(this.cv) // Angle
  //           ,
  //           sa = this.startAngle // Previous start angle
  //           ,
  //           sat = this.startAngle // Start angle
  //           ,
  //           ea // Previous end angle
  //           ,
  //           eat = sat + a // End angle
  //           ,
  //           r = true

  //         this.g.lineWidth = this.lineWidth

  //         this.o.cursor &&
  //           (sat = eat - 0.3) &&
  //           (eat = eat + 0.3)

  //         if (this.o.displayPrevious) {
  //           ea = this.startAngle + this.angle(this.value)
  //           this.o.cursor &&
  //             (sa = ea - 0.3) &&
  //             (ea = ea + 0.3)
  //           this.g.beginPath()
  //           this.g.strokeStyle = this.previousColor
  //           this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
  //           this.g.stroke()
  //         }

  //         this.g.beginPath()
  //         this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
  //         this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
  //         this.g.stroke()

  //         this.g.lineWidth = 2
  //         this.g.beginPath()
  //         this.g.strokeStyle = this.o.fgColor
  //         this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
  //         this.g.stroke()

  //         return false
  //       }
  //     }
  //   })
  //   /* END JQUERY KNOB */
  // })
</script>



@endsection