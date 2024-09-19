@extends('portal.layout.app')

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Department</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Department</a></li>
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
            <form action="{{route('category.update', $category->id)}}" method="POST">
                {{csrf_field()}}
                <label class="form-label required">Department Name</label>
                <input type="name" class="form-control" id="name" name="name" value="{{old('name') ?? $category->name}}" required />

              
                <label class="form-label required mt-2">Department Head</label>
                <select name="unit_id" class="form-control">

                    @foreach($users as $userall)
                    <option value="{{ $userall->id }}" @if(old('unit_id', $category->user_id) == $userall->id) selected @endif>{{ $userall->name }}</option>
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