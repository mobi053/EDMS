@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Task</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('task.index')}}">Tasks</a></li>
                    <li class="breadcrumb-item active">Edit Task</li>
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
            <form action="{{route('task.update', $task->id)}}" method="POST" role="form" enctype="multipart/form-data">
                {{csrf_field()}}
                <label class="form-label required">Task Name</label>
                <input type="text" class="form-control" id="name" name="title" value="{{old('name') ?? $task->title}}" required oninput="restrictSpecialChars(this)">
              


                <label class="form-label required mt-2">Description</label>
                    <textarea class="form-control" rows="3" name="description" placeholder="Description" oninput="restrictSpecialChars(this)">{{ old('description') ?? $task->description }}</textarea>

                    <label for="dueDateTime mt-2">Start Date</label>
                <input type="date" class="form-control" name="start_date" id="start_dater" value="<?= isset($task) ? date('Y-m-d', strtotime($task->start_date)) : '' ?>">
                <label for="dueDate" class="mt-2">Due Date</label>
                <input type="date" class="form-control" name="duedate" id="duedater" value="<?= isset($task) ? date('Y-m-d', strtotime($task->duedate)) : '' ?>">
                   

                
                <label class="form-label">Estimated Time (hrs)</label>
                <input type="number" class="form-control" id="estimated_time" name="estimated_time" value="{{old('estimated_time') ?? $task->estimated_time}}" />
                <div class="form-group mt-2 ">
                    <label class="required">Priority</label>
                    <select name="priority" class="form-control">
                        <option value="Medium" {{ $task->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                        <option value="High" {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
                        <option value="Critical" {{ $task->priority == 'Critical' ? 'selected' : '' }}>Critical</option>
                        <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
                    </select>
                </div>
                <label class="form-label required">Task Assigned to:</label>
                    <select class="form-control" id="assigned_to" name="assigned_to" required>
                    <option value="">Please select the user </option>

                @if(old('assigned_to', $task->assigned_to) == auth()->user()->id)
                        <option value="{{ auth()->user()->id }}" selected>{{ auth()->user()->name }} | {{ auth()->user()->designation }}</option>
                    @else
                        <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }} | {{ auth()->user()->designation }}</option>
                    @endif

                        @foreach($reportinguser as $user)
                            <option value="{{ $user->id }}" @if(old('assigned_to', $task->assigned_to) == $user->id) selected @endif>{{ $user->name }}</option>
                        @endforeach
                    </select>  
                <div class="form-group mt-2 ">
                    <label class="required">Task Status</label>
                    <select name="status" class="form-control">
                        @foreach($status as $status)
                            <option value="{{ $status->id }}" @if(old('status', $task->status) == $status->id) selected @endif>{{ $status->name }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="form-group">
    <label>File</label>
    <input type="file" class="form-control-file" id="attachment_file" name="attachment_file[]" accept="image/*,video/*,.pdf,.doc,.txt" multiple />
    <small class="form-text text-muted">File size must be less than 5MB.</small>
</div>
<div id="preview"></div>




               


        

                <button type="submit" class="btn btn-primary my-2 float-right">Save</button>
            </form>

            <span>Previously Attached:</span>
<div id="databaseAttachments">
    @foreach ($attachment as $attachments)
        <div class="attachment-item">
            @if (strpos($attachments->url, '.jpg') || strpos($attachments->url, '.jpeg') || strpos($attachments->url, '.png') || strpos($attachments->url, '.gif'))
                <img src="{{ asset($attachments->url) }}" style="max-width: 100px; max-height: 100px; margin: 5px;" />
            @elseif (strpos($attachments->url, '.mp4') || strpos($attachments->url, '.avi') || strpos($attachments->url, '.mov'))
                <video src="{{ asset($attachments->url) }}" controls style="max-width: 100px; max-height: 100px; margin: 5px;"></video>
            @else
                <a class="btn btn-secondary" target="_blank" href="{{ asset($attachments->url) }}">Attachment {{ $loop->iteration }}</a>
            @endif
            <!-- Remove button -->
            <button class="remove-button" data-id="{{ $attachments->id }}">×</button>
        </div>
    @endforeach
</div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
            <div class="d-flex justify-content-center">
            </div>
        </div>
    </div>
    <!-- /.card -->

</section>
<script>
    document.getElementById('attachment_file').addEventListener('change', function() {
        var preview = document.getElementById('preview');
        preview.innerHTML = ''; // Clear previous previews

        var files = this.files;
        var fileInputs = []; // Array to store corresponding file input indexes

        for (var i = 0; i < files.length; i++) {
            var file = files[i];
            var reader = new FileReader();

            reader.onload = (function(file, index) {
                return function(e) {
                    var fileType = file.type.split('/')[0];
                    var previewElement = document.createElement('div');
                    previewElement.classList.add('preview-item');

                    if (fileType === 'image') {
                        previewElement.innerHTML = '<img src="' + e.target.result + '" style="max-width: 100px; max-height: 100px; margin: 5px;" />';
                    } else if (fileType === 'video') {
                        previewElement.innerHTML = '<video src="' + e.target.result + '" controls style="max-width: 100px; max-height: 100px; margin: 5px;"></video>';
                    } else {
                        previewElement.innerHTML = '<p>' + file.name + '</p>';
                    }

                    var removeButton = document.createElement('button');
                    removeButton.innerHTML = '&times;';
                    removeButton.classList.add('remove-button');
                    removeButton.onclick = function() {
                        preview.removeChild(previewElement);
                        // Detach the corresponding file from the input field
                        fileInputs.splice(index, 1);
                        var remainingFiles = [];
                        for (var j = 0; j < fileInputs.length; j++) {
                            remainingFiles.push(files[fileInputs[j]]);
                        }
                        var newFileList = new DataTransfer();
                        for (var k = 0; k < remainingFiles.length; k++) {
                            newFileList.items.add(remainingFiles[k]);
                        }
                        document.getElementById('attachment_file').files = newFileList.files;
                    };

                    previewElement.appendChild(removeButton);
                    preview.appendChild(previewElement);
                };
            })(file, i);

            reader.readAsDataURL(file);
            fileInputs.push(i); // Store the index of the corresponding file input
        }
    });
</script>
<script>
    // Add event listener to remove buttons
    var removeButtons = document.querySelectorAll('.remove-button');
removeButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var id = this.getAttribute('data-id');

        // Include CSRF token in the headers
        var headers = {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        // Send AJAX request to delete the attachment
        fetch('/admin/task/deleteattachment/' + id, {
            method: 'POST',
            headers: headers
        })
        .then(response => {
            if (response.ok) {
                // On successful deletion, remove the attachment from the DOM
                this.parentNode.remove(); // Remove the parent element containing the attachment
            } else {
                console.error('Error deleting attachment:', response.status);
            }
        })
        .catch(error => {
            console.error('Error deleting attachment:', error);
        });
    });
});

    function restrictSpecialChars(input) {
        // Define the allowed characters: letters, numbers, spaces, and hyphens
        const regex = /^[a-zA-Z0-9\s-.]*$/;
        
        // If the value doesn't match the allowed characters, replace the value with the filtered value
        if (!regex.test(input.value)) {
            input.value = input.value.replace(/[^a-zA-Z0-9\s-.]/g, '');
        }
    }


</script>










@endsection