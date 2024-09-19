@extends('portal.layout.app')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Project</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Project</a></li>
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
                <form action="{{route('project.update', $project->id)}}" method="POST">
                    {{csrf_field()}}
                    <label  class="form-label required">Name</label>
                    <input type="name" class="form-control" id="name" name="name" value="{{old('name') ?? $project->name}}" required oninput="restrictSpecialChars(this)">

                    <label  class="form-label required mt-2">Location </label>
                    <select class="form-control" id="location" name="location" required>
                        <option value="PSCA LAHORE" {{ old('location', $project->location) == 'PSCA LAHORE' ? 'selected' : '' }}>PSCA LAHORE</option>
                        <option value="PPIC3 Kasur" {{ old('location', $project->location) == 'PPIC3 Kasur' ? 'selected' : '' }}>PPIC3 Kasur</option>
                        <option value="PPIC3 Nankana" {{ old('location', $project->location) == 'PPIC3 Nankana' ? 'selected' : '' }}>PPIC3 Nankana</option>
                    </select>

                    <label for="start_datev">Start Time</label>
                    <input type="date" class="form-control" name="start_date" id="start_datev" value="<?= isset($project) ? date('Y-m-d', strtotime($project->start_date)) : '' ?>">
                    <label for="dueDateTimev">Due Time</label> 
                    <input type="date" class="form-control" name="due_date" id="due_datev" value="<?= isset($project) ? date('Y-m-d', strtotime($project->due_date)) : '' ?>">

                    <label class="form-label required">Manager</label>
                    <select class="form-control modalsearch" id="manager" name="manager" required>
                   
                            <option value="{{auth()->user()->id}}">{{auth()->user()->name}} | {{auth()->user()->designation}} </option>
                        @foreach($reportinguser as $user)
                            <option value="{{ $user->id }}" @if(old('manager', $project->manager) == $user->id) selected @endif>{{ $user->name }} | {{$user->designation}}</option>
                        @endforeach
                    </select>
                    <label class="form-label required">Department</label>
                    <select class="form-control" id="category" name="category" required>
                    <option value="999">Global Project (visible to all departments)</option>
                    @foreach($categories as $category)
                            <option value="{{$category->id}}" @if(old('category', $project->category) == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <label class="form-label required">Status</label>
                    <select class="form-control" id="status" name="status" required>
                    @foreach($status as $status)
                            <option value="{{ $status->id }}" @if(old('status', $project->status) == $status->id) selected @endif>{{ $status->name }}</option>
                        @endforeach
                    </select>
                     
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



