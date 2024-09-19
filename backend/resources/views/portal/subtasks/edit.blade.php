@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit SubTask</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{route('subtask.index')}}">SubTask</a></li>
                    <li class="breadcrumb-item active">Edit</li>
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
            <form action="{{route('subtask.update', $subtask->id)}}" method="POST">
                {{csrf_field()}}
                <label class="form-label">Task Name</label>
                <input type="task" class="form-control d-none" id="title" name="task" value="{{old('name') ?? $subtask->task->id}}" />
                <input type="subtask" class="form-control d-none" id="title" name="subtask" value="{{old('name') ?? $subtask->id}}" />
                <input type="name" class="form-control" id="title" name="title" disabled value="{{old('name') ?? $subtask->task->title}}" />
                <label class="form-label mt-2 required">Subtask Name</label>
                <input type="name" class="form-control" id="name" name="name" value="{{old('name') ?? $subtask->name}}" oninput="restrictSpecialChars(this)">
                <label class="form-label mt-2 required">Subtask Description </label>
                <textarea class="form-control" id="assigndescription" rows="3" name="assigndescription" placeholder="Description" oninput="restrictSpecialChars(this)">{{old('description') ?? $subtask->description}}</textarea>
                <!-- <label for="dueDateTime" class="mt-2 required">Due Date</label>
                <input type="date" class="form-control" name="due_date" id="duedate" value="{{ isset($subtask) ? $subtask->due_date : '' }}">

                <label class="form-label required mt-2">Task Assigned to:</label>
                <select class="form-control" id="assigned_to" name="assigned_to" required>
                    @foreach($userassign as $user)
                    <option value="{{ $user->id }}" @if(old('assigned_to', $subtask->assigned_to) == $user->id) selected @endif>{{ $user->name }}</option>
                    @endforeach
                </select> -->
                <!-- <label for="start_datetime" class="mt-2 required">Start Date</label>
                <input type="datetime-local" class="form-control" name="start_datetime" id="start_datetime" value="{{ isset($subtask->start_datetime) ? \Carbon\Carbon::parse($subtask->start_datetime)->format('Y-m-d\TH:i') : '' }}">
                <label for="start_datetime" class="mt-2 required">End Date</label>
                <input type="datetime-local" class="form-control" name="end_datetime" id="end_datetime" value="{{ isset($subtask->end_datetime) ? \Carbon\Carbon::parse($subtask->end_datetime)->format('Y-m-d\TH:i') : '' }}"> -->

                <label class="form-label">Estimated Time(hrs)</label>
                <input type="number" class="form-control" id="estimated_time" name="estimated_time" value="{{old('estimated_time') ?? $subtask->estimated_time}}" />
               
                <div class="form-group mt-2 ">
                    <label class="required">Subtask Status</label>
                    <select name="status" class="form-control">
                        <option value="6" {{ $subtask->status == 6 ? 'selected' : '' }}>Pending</option>
                        <option value="1" {{ $subtask->status == 1 ? 'selected' : '' }}>Completed</option>
                        <option value="0" {{ $subtask->status == 0 ? 'selected' : '' }}>In progress</option>
                        <option value="2" {{ $subtask->status == 2 ? 'selected' : '' }}>On Hold</option>
                        <option value="3" {{ $subtask->status == 3 ? 'selected' : '' }}>Not Started Yet</option>
                        <option value="4" {{ $subtask->status == 4 ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="form-group mt-2 d-none ">
                    <label class="required">Task Status</label>
                    <select name="task_status" class="form-control">
                        <option value="1" {{ $subtask->task->status == 1 ? 'selected' : '' }}>Completed</option>
                        <option value="0" {{ $subtask->task->status == 0 ? 'selected' : '' }}>InProgress</option>
                        <option value="3" {{ $subtask->task->status == 3 ? 'selected' : '' }}>OnHold</option>
                        <option value="4" {{ $subtask->status == 4 ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>

                <div class="custom-control custom-checkbox">
                            <input name="goodwork" class="custom-control-input custom-control-input-success" type="checkbox" id="customCheckbox4" {{ $subtask->is_goodwork == 1 ? 'checked' : '' }}>
                            <label for="customCheckbox4" class="custom-control-label">If you consider this good work, please check the box.</label>
                            </div>
                            <div class="form-group">
                               
                                <textarea class="form-control mt-2" rows="3" name="goodwork_description" id="goodwork_description" placeholder="Good Work Description">{{old('goodwork_remarks') ?? $subtask->goodwork_remarks}}</textarea>
                            </div>


                <button type="submit" class="btn btn-primary my-2 float-right">Save</button>
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
<script>
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