@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h4><b>

            <h4><b>Meeting Details</b></h4>

          </b></h4>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{route('meeting.index')}}">Meeting</a></li>
          <li class="breadcrumb-item active">Meeting Details</li>
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
      <div class="row">
        <div class="col-xl-12">
          <div class="card bg-info">
            <div class="card-header">
              <h3 class="card-title">
                <i class="far fa-calendar-alt"></i>
                <b>{{$meeting->title}}</b>
              </h3>
              <div class="card-tools">
                <span>Status: {{$meeting->status_name->name ?? ''}} | </span>
                <span>
                  <i class="fas fa-user-tie" data-toggle="tooltip" data-placement="top" title="Organizer"></i>
                   {{$meeting->task_creator->name ?? ''}} | </span>
                <span>
                  <i class="fas fa-chalkboard-teacher" data-toggle="tooltip" data-placement="top" title="Headed by"></i>
                   {{$meeting->task_manager->name ?? ''}}</span>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="participants">
                <h5 class="text-center text-warning">
                  <i class="fas fa-users"></i> 
                  Participants
                </h5>
                <div class="row justify-content-center">
                @php
                $participants = json_decode($meeting->participants);

                // Initialize $participantsname as an empty array to avoid undefined variable error
                $participantsname = [];

                // Check if $participants is an array before looping
                if (is_array($participants)) {
                  foreach ($participants as $part) {
                  $user = \App\Models\User::find($part);
                    if ($user) {
                      $participantsname[] = $user->name;
                    }
                  }
                }
                @endphp
                @foreach ($participantsname as $participant)
                  <div class="col-6 col-sm-4 col-md-4 col-xl-2 text-center">
                    <img class="img-fluid rounded-circle d-block mx-auto" src="{{url('/portal')}}/dist/img/user2.png" alt="Message User Image" style="width: 60px;">
                    <span class="user-name">{{ $participant }}</span>
                  </div>
                @endforeach
                </div>
              </div>
              <h5 class="text-warning text-center">
                <i class="fas fa-info-circle"></i> 
                  Description
              </h5>
              <div class="text-center">
                {{$meeting->description}}
              </div>
              <div class="attachments mt-3">
                @if($attachment->isNotEmpty())
                <h5 class="text-warning">
                  <i class="fas fa-paperclip"></i> 
                  Attachments
                </h5>
                <ul>
                  @foreach ($attachment as $attachments)
                    <li>
                      <a href="{{ asset($attachments->url) }}" target="_blank" class="text-white">File</a>
                    </li>
                  @endforeach
                </ul>
                @endif
              </div>
            </div>
            <div class="card-footer text-right">
              <div>
                <span>
                  <i class="far fa-clock" data-toggle="tooltip" data-placement="top" title="Start Time"></i>
                   {{!empty($meeting->start_date) ? $meeting->start_date : ''}}
                </span>
                <span> | </span>
                <span>
                  <i class="fas fa-clock" data-toggle="tooltip" data-placement="top" title="End Time"></i>
                   {{!empty($meeting->end_date) ? $meeting->end_date : ''}}
                  </span>
                <span> | </span>
                @php
                use Carbon\Carbon;

                // Parse start and end dates using Carbon
                $startDate = Carbon::parse($meeting->start_date);
                $endDate = Carbon::parse($meeting->end_date);

                // Calculate the difference in hours and minutes
                $duration = $startDate->diff($endDate);

                // Format the duration as desired
                $durationFormatted = $duration->format(' %h hour(s), %i minute(s)');
                @endphp

                <span>
                  <i class="fas fa-people-arrows" data-toggle="tooltip" data-placement="top" title="Duration"></i>
                   {{ $durationFormatted }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- /.card -->
  </div>
</section>
@endsection

@section('script')
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