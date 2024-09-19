@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4><b>

            <h4><b>SubTask Detail</b></h4>

          </b></h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{route('subtask.index')}}">All Subtasks</a></li>
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
    @foreach($data as $task)
    <div class="card-header">
      <div class="row">
        <div class="col-8">
          <div class="d-flex flex-column">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              SubTask Name: <b>{{$task->name}}</b>
            </h3>
            
            <div class="text-muted">
              <!-- <span>&nbsp; Assigned by: <b> dollarsigntask->task->task_creator->name </b>| </span> -->
              <span>&nbsp; <i class="fa fa-user"></i> <b>Performed By: </b> {{$task->sub_task_creator->name}} | </span>
              <span>&nbsp; <i class="fa fa-user"></i> <b>Task Assigned By: </b> {{$task->task->task_creator->name}} | </span>
              <span class="time"><i class="fas fa-clock"></i> <b>Task Due Date: </b> {{$task->task->duedate}} </span>
           
              <!---log button ----->

              <!---end log button---->
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
            </div>
                  <!-- <div class="my-2">
                            <div class="progress" style="width: 180px;">
                                <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="{{$task->progress}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$task->progress}}%">
                                    <span class="sr-only"> {{$task->progress}}</span> {{$task->progress}}%
                                </div>
                            </div>
                        </div> -->
            <div class="pt-2">
              Subtask created at <span style="color:#007bff;">{{$task->created_at}}</span>
            </div>
         
            <div class="pt-2">
              Subtask Status: <span style="color:#007bff;">
              @if($subtask->status==1) Completed @elseif($subtask->status==0) In Progress @elseif($subtask->status==2) On Hold @elseif($subtask->status==3) Not Started Yet @elseif($subtask->status==4) Cancelled @elseif($subtask->status==6) Pending  @endif
              </span>
            </div>
            <div class="pt-2">
              Time Spent: 
              <span style="color:#007bff;">
              @foreach($data as $task)
              @php
                  $totalDuration = 0;
              @endphp
              @foreach($task->activities as $activity)
                  @php
                      $totalDuration += $activity->duration;
                    
                  @endphp
              @endforeach
             
            
              <!-- @if ($hours = floor((($totalDuration % (30 * 24 * 60)) % (7 * 24 * 60) % (24 * 60)) / 60))
                  {{ $hours }} hours,
              @endif
              @if ($minutes = $totalDuration % 60)
                  {{ $minutes }} minutes
              @endif -->

              {{$totalDuration/60}} hours
              </span>
              <div class="pt-2">
              Subtask Estimated Duration <span style="color:#007bff;">{{$task->estimated_time}} hours</span><br>
              

            </div>

            <div class="pt-2">
          
           
            @if($task->status==1)
              @if($task->remaining_time == 0)
              Remaining Duration: <span style="color:#007bff;">0 </span> <br>
              Completed on time
              @elseif($task->remaining_time > 0)
              Remaining Duration: <span style="color:#007bff;">0 </span> <br>
              Completed before time
              @elseif($task->remaining_time < 0)
              Remaining Duration: <span style="color:#007bff;">0 </span> <br>
              Completed late
              @endif
            @else
            Remaining Duration: <span style="color:#007bff;">{{$task->remaining_time}} hours</span> <br>
            @endif

            </div>
           
           
            </div>
            

            @endforeach
            
            </div>
           
          </div>
        </div>
        <div class="col-4 text-center d-none">
        @if($task->status==1) 
          <input type="text" class="knob" value="{{$task->progress}}" data-thickness="0.3" data-width="100" data-height="100" data-fgColor="" data-angleOffset="0" data-linecap="round" data-readOnly="true">
              @else 
              <input type="text" class="knob" value="{{0}}" data-thickness="0.3" data-width="100" data-height="100" data-fgColor="" data-angleOffset="0" data-linecap="round" data-readOnly="true">

              @endif
          <div class="knob-label">Subtask Weightage</div>
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
            @php $serialNumber = 1; @endphp
            @foreach($data as $subtask)

            @foreach($subtask->activities as $activity)
            <?php

            // Assuming $subtask->duration is the duration in minutes
            $durationInMinutes = (int)$activity->duration;
            // Calculate hours and minutes
            $hours = floor($durationInMinutes / 60);
            $minutes = $durationInMinutes % 60;
            // Output the result
            ?>
            <div class="time-label">
                <span class="bg-success">
                <i class="fas fa-clock"></i>
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

            <!-- /.timeline-label -->
            <!-- timeline item -->

            <div>
              <span class="counter bg-info"> {{$serialNumber++}}</span>
              <div class="timeline-item">
              @php
              $activity_created_at = $activity->created_at->timezone('Asia/Karachi');
              $formatted_date_time = $activity_created_at->format('Y-m-d h:i A');
              @endphp
                <!-- <span class="time text-white"><i class="fas fa-user"></i> Assigned to: {{$subtask->sub_task_assign->name ?? ''}} | {{$subtask->sub_task_assign->designation ?? ''}} , &nbsp; Assigned By: {{$subtask->sub_task_creator->name}} | {{$subtask->sub_task_creator->designation}} </span> -->
                <span class="time text-white">
                <i class="fas fa-user"></i>
                Performed by:{{$activity->user->name}}
                <i class="fas fa-clock"></i>
                Logged at:{{$formatted_date_time}}
                </span>
                <h3 class="timeline-header bg-info">{{ $activity->sub_description }}
                </h3>

              </div>
            </div>

            @endforeach
            @endforeach
            <div>
            @foreach($data as $task)
    @php
        $hasActivity = false;
        foreach($task->activities as $activity) {
            if ($activity !== null) {
                $hasActivity = true;
                break;
            }
        }
    @endphp
    
    @if($hasActivity)
        <i class="fas fa-clock bg-gray"></i>
    @else
        <h3 class="card-title">
            <i class="fas fa-edit mr-1"></i>
            <!-- <b style="color:red">No activity Performed yet! </b> -->
            <span>{{$subtask->description}} </span>

        </h3>

    @endif
@endforeach




            </div>
          </div>
        </div>
        <!-- /.col -->
      </div>
    </div>
    <!-- /.card -->
       <!-- Activity Modal -->
       <div class="modal fade" id="addActivityModal" tabindex="-1" role="dialog" aria-labelledby="addActivityModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addActivityModalLabel">Log Time </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>


                        
                    </div>
                    <div class="modal-body">
                        <form action="{{route('activity.store')}}" method="POST" role="form" enctype="multipart/form-data" id="LogTimeForm">
                            @csrf
                            <div class="form-group ">
                                <label for="Name">Task *</label>
                          
                                <input type="text" class="form-control" id="taskTitle" readonly>
                                <input type="text" name="task" id="taskId" class="form-control " hidden >

                            </div>

                            <div class="form-group">
                                <label for="Name"> Subtask Name</label>
                                <input type="text" class="form-control" id="subtaskName" readonly>
                                <input type="text" name="subtask" id="subtaskId" class="form-control hidden" hidden>


                            </div>
                            <!-- <div class="form-group">
                                <label for="Name">Activity Name *</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="Name" placeholder="Name">
                            </div> -->
                            <div class="form-group">
                                <label>Remarks *</label>
                                <textarea class="form-control" rows="3" name="sub_description" placeholder="Description" required>{{ old('sub_description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="Name"> Time Spent(hrs)*</label>
                                <input type="number" name="duration" id="duration" class="form-control" min="0.5" step="0.5" required>
                                <input type="text" name="subduration" id="subduration" class="form-control d-none" value="{{ $totalDuration/60 }}">
                                <input type="text" name="subtaskestimated" id="subtaskestimated" class="form-control d-none" value="{{ $subtask->estimated_time }}">

                            </div>

                            <div>

                            <label for="Name"> More Time Required (hrs)</label>
                                <input type="number" name="moreDuration" id="moreDuration" class="form-control" >
                            </div>
                            
                            <div class="form-group">
                                <label for="Name"> Remaining Time (hrs)</label>
                                <input type="number" name="remainingtime" id="remainingtime" class="form-control " value="{{ $subtask->remaining_time }}" readonly>
                                
                            </div>
                            <!-- <div class="form-group d-none">
                                <label for="Name"> Time Remaining</label>
                                <input type="text" name="subtask" id="duration" class="form-control ">
                            </div> -->
                            <div class="form-group d-none">
                                <label for="dueDateTime">Start Time/Date *</label>
                                <input type="datetime-local" class="form-control" name="start_datetime" id="start_datetime" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i') }}" placeholder="Start Time/Date">
                            </div>
                            <div class="form-group d-none">
                                <label for="dueDateTime">End Time/Date *</label>
                                <input type="datetime-local" class="form-control" name="end_datetime" id="end_datetime" value="{{ now()->setTimezone('Asia/Karachi')->format('Y-m-d\TH:i') }}" placeholder="Start Time/Date">
                            </div>

                            <!-- <div class="form-group">
                                <label>Activity Status*</label>
                                <select class="form-control" name="status" id=" ">
                                    <option value="">Please select Activity status below </option>

                                    <option value="1">Completed</option>
                                    <option value="0">inProgress</option>
                                </select>
                            </div> -->
                            <div class="form-group">
                                <label>Subtask Status*</label>
                                <select class="form-control " name="subtask_status" id="status" required>
                                    <option value="">Please select Subtask status below </option>
                                    <option value="1">Completed</option>
                                    <option value="0">In progress</option>
                                    <option value="2">On Hold</option>
                                    <option value="3">Not Started Yet</option>
                                </select>
                            </div>

                            <div class="form-group">

                              <label>File </label>

                              <!-- <input type="file" class="form-control-file" id="attachment_file" name="attachment_file" accept="image/*,video/*" required /> -->

                              <!-- <input type="file" multiple  class="form-control-file" id="attachment_file" name="attachment_file[]" accept="image/*,video/*,.pdf,.doc,.txt" required /> -->
                              <input type="file" class="form-control-file" id="attachment_file" name="attachment_file[]" accept="image/*,video/*,.pdf,.doc,.txt" multiple />



                              <small class="form-text text-muted">File size must be less than 5MB.</small>

                              </div>
                            <!-- <div class="form-group">
                                <label>Task Progress *</label>
                                <div class="slider-red">
                                    <input id="progressSliderModal" type="text" value="0" name="progress" class="slider form-control" data-slider-min="0" data-slider-max="100" data-slider-step="5" data-slider-orientation="horizontal" data-slider-selection="before" data-slider-tooltip="show">
                                </div>
                            </div> -->
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="submitButton">Add</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
  </div>
</section>
@endsection



@section('script')
<script>
    $(document).ready(function() {
        // Function to update total duration
        var remainingTimeInitialValue= parseFloat($('#remainingtime').val()) || 0;
        function updateTotalDuration() {
            var durationValue = parseFloat($('#duration').val()) || 0; // Get value of duration input
            var subDurationValue = parseFloat($('#subduration').val()) || 0; // Get value of subduration input
            var subtaskestimatedValue= parseFloat($('#subtaskestimated').val()) || 0;
            var moreDurationValue= parseFloat($('#moreDuration').val()) || 0;
            //$('#moreDuration').val(moreDurationValue);
            let u = parseFloat($('#moreDuration').val()) || 0;
            var totalDuration = durationValue + subDurationValue; // Calculate total duration
            $('#totalDuration').val(totalDuration); // Update total duration input field
            // var remainingDuration= subtaskestimatedValue - totalDuration + u;
            // $('#remainingDuration').val(remainingDuration);
            var remainingTimeUpdatedValue = remainingTimeInitialValue - durationValue + u ;
            $('#remainingtime').val(remainingTimeUpdatedValue);
        }

        // Call the function initially to calculate the initial total duration
        updateTotalDuration();

        // Listen for changes in the duration and subduration input fields
        $('#duration, #subduration, #moreDuration, #remainingtime').on('input', function() {
            updateTotalDuration(); // Update total duration when input changes
        });
    });

   function handleFormSubmit(formId, buttonId) {
        document.getElementById(formId).addEventListener('submit', function(event) {
            event.preventDefault();  // Prevent the form from submitting immediately

            const button = document.getElementById(buttonId);
            button.disabled = true;

            setTimeout(function() {
                button.disabled = false;
                // Optionally, you can submit the form here after 5 seconds
                // document.getElementById(formId).submit(); 
            }, 30000);

            // Submit the form immediately after disabling the button
            document.getElementById(formId).submit();
        });
    }

    // Handle LogTimeForm submission and modal
    handleFormSubmit('LogTimeForm', 'submitButton');
    // Handle AddSubtaskForm submission and modal
    handleFormSubmit('AddSubtaskForm', 'addSubtaskButton');
</script>

<script>
     

   // Fetch data-task-id when the modal is opened
   $('#addActivityModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var taskId = button.data('task-id'); // Extract info from data-* attributes
            var taskTitle = button.data('task-title'); // Extract info from data-* attributes
            var subtaskId = button.data('subtask-id'); // Extract subtaskId from data-* attribute
            var subtaskName = button.data('subtask-name'); // Extract subtaskId from data-* attribute
            var subtaskestimated = button.data('subtask-estimated');

            // Update the element within the modal with the taskId

            $('#taskId').val(taskId);
            $('#taskTitle').val(taskTitle);
            $('#subtaskId').val(subtaskId);
            $('#subtaskName').val(subtaskName);
            $('#subtaskeastimated').val(subtaskestimated);

            // console.log(taskTitle);
            // console.log(taskId);
            // console.log(subtaskName);
            // console.log(subtaskId); // You can use this taskId variable as per your requirement
            console.log(subtaskestimated);
        });
</script>
<script>
  // Date Picker
  $(function() {
    $('#dueDate').daterangepicker({
      singleDatePicker: true,
    });
  });

  // Slider
  $('#progressSlider').slider({
    formatter: function(value) {
      return 'Current value: ' + value;
    }
  });
  $(function() {
    $('.knob').knob({
      /*change : function (value) {
       //console.log("change : " + value);
       },
       release : function (value) {
       console.log("release : " + value);
       },
       cancel : function () {
       console.log("cancel : " + this.value);
       },*/
      draw: function() {

        // "tron" case
        if (this.$.data('skin') == 'tron') {

          var a = this.angle(this.cv) // Angle
            ,
            sa = this.startAngle // Previous start angle
            ,
            sat = this.startAngle // Start angle
            ,
            ea // Previous end angle
            ,
            eat = sat + a // End angle
            ,
            r = true

          this.g.lineWidth = this.lineWidth

          this.o.cursor &&
            (sat = eat - 0.3) &&
            (eat = eat + 0.3)

          if (this.o.displayPrevious) {
            ea = this.startAngle + this.angle(this.value)
            this.o.cursor &&
              (sa = ea - 0.3) &&
              (ea = ea + 0.3)
            this.g.beginPath()
            this.g.strokeStyle = this.previousColor
            this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false)
            this.g.stroke()
          }

          this.g.beginPath()
          this.g.strokeStyle = r ? this.o.fgColor : this.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false)
          this.g.stroke()

          this.g.lineWidth = 2
          this.g.beginPath()
          this.g.strokeStyle = this.o.fgColor
          this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false)
          this.g.stroke()

          return false
        }
      }
    })
    /* END JQUERY KNOB */
  })
</script>

@endsection