@extends('portal.layout.app')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Role</a></li>
                        <li class="breadcrumb-item active">Add</li>
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
                <form action="{{route('role.store')}}" method="POST" >
                    {{csrf_field()}}
                    <label  class="form-label required">Role Name</label>
                    <input type="name" class="form-control" id="name" name="name" value="{{ old('name') }}" required/>
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



