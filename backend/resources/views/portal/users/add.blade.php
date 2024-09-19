@extends('portal.layout.app')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Add User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('user.index')}}">Users</a></li>
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
                <form action="{{route('user.store')}}" method="POST" >
                    {{csrf_field()}}
                    <label  class="form-label required">Name</label>
                    <input type="name" class="form-control" id="name" name="name" value="{{ old('name') }}" required/>
                    
                    <label  class="form-label required">Employee ID</label>
                    <input type="name" class="form-control" id="employee_id" name="employee_id" value="{{ old('employee_id') }}" required/>
                    <label  class="form-label required mt-2">Email </label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required/>
                    <label  class="form-label required mt-2">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}" required/>
                    <label  class="form-label required">Designation</label>
                    <input type="name" class="form-control" id="designation" name="designation" value="{{ old('designation') }}" required/>
                    <label  class="form-label required">Phone</label>
                    <input type="name" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required/>
                    <label  class="form-label required">Reporting Person</label>
                    
                        <select name="unit_id" class="form-control modalsearch">
                            @foreach($users as $user)
                          <option value="{{$user->id}}">{{$user->name}} | {{$user->designation}} | {{$user->employee_id}}</option>
                            @endforeach
                        </select>

                        <label  class="form-label required">Department</label>
                    
                    <select name="department" class="form-control modalsearch">
                        @foreach($category as $categories)
                      <option value="{{$categories->id}}">{{$categories->name}}</option>
                        @endforeach
                    </select>
                  
                    <!-- <input type="name" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required/> -->

                    
                    
                   
                   
                    
                    
             
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



