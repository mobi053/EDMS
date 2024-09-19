@extends('portal.layout.app')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card card-info card-outline">
         <div class="card-header">
            <h3 class="card-title">Reset Password</h3>
         </div>
            <div class="card-body">
                <form action="{{route('password.change')}}" method="POST" >
                    {{csrf_field()}}
                    <label  class="form-label required mt-2"> Old Password</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" required/>

                    <label  class="form-label required mt-2">New Password</label>
                    <input type="password" class="form-control" id="new_password" name=" new_password" required/>

                    <label  class="form-label required mt-2">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required/>

                      <button type="submit" class="btn btn-primary my-2 float-right">Update</button>
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



