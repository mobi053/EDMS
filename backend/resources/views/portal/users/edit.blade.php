@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Users</a></li>
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
            <form action="{{route('user.update', $user->id)}}" method="POST">
                {{csrf_field()}}
                <label class="form-label required">Name</label>
                <!-- <input type="name" class="form-control" id="nameshow" name="nameshow" value="{{old('name') ?? $user->name}}" readonly /> -->
                <input type="name" class="form-control " id="name" name="name" value="{{old('name') ?? $user->name}}" required />

                <label class="form-label required mt-2">Employee ID</label>
                <!-- <input type="name" class="form-control" id="employee_idshow" name="employee_idshow" value="{{old('employee_id') ?? $user->employee_id}}" readonly /> -->
                <input type="name" class="form-control " id="employee_id" name="employee_id" value="{{old('employee_id') ?? $user->employee_id}}" required />

                <label class="form-label required mt-2">Email </label>
                <input type="email" class="form-control" id="email" name="email" value="{{old('email') ?? $user->email}}" required />
                <label class="form-label required mt-2">Designation</label>
                <input type="name" class="form-control" id="designation" name="designation" value="{{ old('designation') ?? $user->designation }}" required />
                <label class="form-label required mt-2">Phone</label>
                <input type="number" class="form-control" id="phone" name="phone" value="{{ old('phone') ?? $user->phone }}" required />
                <label class="form-label required mt-2">Reporting Person</label>
                <select name="unit_id" class="form-control modalsearch">

                    @foreach($users as $userall)
                    <option value="{{ $userall->id }}" @if(old('unit_id', $user->unit_id) == $userall->id) selected @endif>{{ $userall->name }}</option>
                    @endforeach
                </select>


                <label  class="form-label required mt-2">Department</label>
                <select name="department"  class="form-control modalsearch">
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $user->department == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
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


@endsection