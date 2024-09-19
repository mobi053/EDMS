@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Collaborartor</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('task.index')}}">Tasks</a></li>
                    <li class="breadcrumb-item active">Add Collaborartor</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="card card-info card-outline">
        {{-- <div class="card-header">
               <h4>General Information</h4>
            </div> --}}
        <div class="card-body">
        <form id="updateCollaboratorForm" data-action="{{ route('task.updatecollaborator', $task->id) }}" method="POST">
    {{ csrf_field() }}
    <!-- Hidden Fields -->
    <input type="hidden" name="title" value="{{ old('name') ?? $task->title }}" />
    <input type="hidden" name="duedate" value="{{ isset($task) ? date('Y-m-d\TH:i', strtotime($task->duedate)) : '' }}" />
    <textarea name="description" class="form-control d-none" rows="3" >{{ old('description') ?? $task->description }}</textarea>
    <input type="hidden" name="priority" value="{{ old('priority') ?? $task->priority }}" />
    <input type="hidden" name="assigned_to" value="{{ $task->assigned_to ?? '' }}" />

    <!-- Disabled Fields for Display -->
    <label class="form-label required">Task Name</label>
    <input type="text" class="form-control" value="{{ old('name') ?? $task->title }}" disabled />

    <label for="dueDateTime mt-2">Due Date</label>
    <input type="datetime-local" class="form-control" value="{{ isset($task) ? date('Y-m-d\TH:i', strtotime($task->duedate)) : '' }}" disabled />

    <label class="form-label required mt-2">Description</label>
    <textarea class="form-control" rows="3" disabled>{{ old('description') ?? $task->description }}</textarea>

    <label>Priority</label>
    <input type="text" class="form-control" value="{{ old('priority') ?? $task->priority }}" disabled />

    <label>Assigned to</label>
    <input type="text" class="form-control" value="{{ $task->task_manager->name ?? '' }} | {{ $task->task_manager->designation ?? '' }}" disabled />

    <!-- Collaborators -->
    <div class="form-group mt-2">
        <label for="collaborators">Select Collaborators</label>
        <select class="form-control collaboratorsearch" id="collaborators" name="collaborators[]" multiple="multiple" style="width: 100%;">
            <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }} | {{ auth()->user()->designation }}</option>
            @foreach($reportinguser as $userassigned)
            <option value="{{ $userassigned->id }}">{{ $userassigned->name }} | {{ $userassigned->designation }}</option>
            @endforeach
        </select>
    </div>

    <button type="button" id="saveCollaborator" class="btn btn-primary my-2 float-right">Save</button>
</form>

        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <div class="d-flex justify-content-center">
            </div>
        </div>
    </div>
    <!-- /.card -->

</section>

@endsection

@section('script')
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<script>
    $(document).ready(function() {
        $('#saveCollaborator').click(function() {
            
            var formData = {
                '_token': $('input[name=_token]').val(),
                'title': $('input[name=title]').val(),
                'duedate': $('input[name=duedate]').val(),
                'description': $('textarea[name=description]').val(),
                'priority': $('input[name=priority]').val(),
                'assigned_to': $('input[name=assigned_to]').val(),
                'collaborators': $('#collaborators').val(),
            };

            $.ajax({
                url: $('#updateCollaboratorForm').data('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message);
                        // Optional: Redirect or refresh part of the page
                        window.location.href = "{{ route('task.index') }}";
                    } else {
                        toastr.error('Failed to add Collaborator');
                    }
                },
                error: function(response) {
                    alert('An error occurred while updating collaborator.');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2();


        $('.usersearch').select2({
            placeholder: "Please Select the User"
        });
        $('.collaboratorsearch').select2({
            placeholder: "Please Select the Collaborator"
        });


    });
</script>
@endsection