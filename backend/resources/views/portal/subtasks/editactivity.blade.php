@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Activity</h1>
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
            <form action="{{route('activity.update', $activity->id)}}" method="POST">
                {{csrf_field()}}
                <label class="form-label">Task Name</label>
                <input type="task" class="form-control d-none" id="title" name="task" value="{{old('name') ?? $activity->task->id}}" />
                <input type="subtask" class="form-control  d-none" id="" name="activity" value="{{old('name') ?? $activity->id}}" />
                <input type="name" class="form-control" id="title" name="title" disabled value="{{old('name') ?? $activity->task->title}}" />

                <label class="form-label mt-2 required">Subtask Name</label>
                @if($subtaskId)
                    @php
                        $subtask = App\Models\Subtask::find($subtaskId);
                    @endphp
                    <input type="name" class="form-control" id="name" name="name" disabled value="{{ $subtask ? $subtask->name : old('name') }}" />
                @else
                    <input type="name" class="form-control" id="name" name="name" disabled value="{{ old('name') }}" />
                @endif
                <label class="form-label mt-2 required">Activity Description </label>
                <textarea class="form-control" id="sub_description" rows="3" name="sub_description" placeholder="Description">{{old('sub_description') ?? $activity->sub_description}}</textarea>
                <label for="start_datetime" class="mt-2 required">Activity Start Date</label>
                <input type="datetime-local" class="form-control" name="start_datetime" id="start_datetime" value="{{ isset($activity->start_datetime) ? \Carbon\Carbon::parse($activity->start_datetime)->format('Y-m-d\TH:i') : '' }}">
                <label for="start_datetime" class="mt-2 required">Activity End Date</label>
                <input type="datetime-local" class="form-control" name="end_datetime" id="end_datetime" value="{{ isset($activity->end_datetime) ? \Carbon\Carbon::parse($activity->end_datetime)->format('Y-m-d\TH:i') : '' }}">


               

                <div class="form-group mt-2 ">
                    <label class="required">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ $activity->status == 1 ? 'selected' : '' }}>Completed</option>
                        <option value="0" {{ $activity->status == 0 ? 'selected' : '' }}>InProgress</option>
                        <option value="2" {{ $activity->status == 2 ? 'selected' : '' }}>OnHold</option>
                        <option value="3" {{ $activity->status == 3 ? 'selected' : '' }}>NotStarted</option>
                    </select>
                </div>


                <button type="submit" class="btn btn-primary my-2 float-right">Submit</button>
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