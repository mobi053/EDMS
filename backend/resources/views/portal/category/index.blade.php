@extends('portal.layout.app')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> Departments </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Department</li>
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
           
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addTaskModal">
                Add Department
            </button>
           
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="table1" width="100%">
                    <thead>
                        <tr>
                            <th> ID </th>
                            <th> Name </th>
                             <th> Department Head </th>
                          <!--  <th> Designation </th>
                            <th> Phone </th> -->
                            
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
               </table>
           </div>

             <!-- Add Activity Modal -->
        <div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="addTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTaskModalLabel">Add Department</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('category.store')}}" method="POST">
                            @csrf
                          
                            <div class="form-group">
                                <label for="Name">Department Name *</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" id="Name" placeholder="Name">
                            </div>
                            <div class="form-group">
                                <label>Department Head</label>
                                <select name="department_head" class="form-control">
                                    @foreach($userassign as $userassigned)
                                    <option value="{{$userassigned->id}}">{{$userassigned->name}} | {{$userassigned->designation}} | {{$userassigned->employee_id}}</option>
                                    @endforeach
                                </select>
                            </div>

                        
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- End of Add Activity Modal -->
           <!-- Role Grant Modal -->
           <div class="modal fade" id="grantRoleModal" tabindex="-1" role="dialog" aria-labelledby="grantRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="grantRoleModalLabel">Grant Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
    <form action="{{ route('user.assign_permission') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" id="userIdInput">

        <h4>Permissions:</h4>
        <ul style="list-style-type:none;" id="availablePermissionsList">
            <!-- Permissions will be dynamically populated here -->
        </ul>
    
</div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Grant Permissions</button>
                </div>
            </form>
        </div>
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
@endsection
@section('script')
<script type="text/javascript">
    $(function () {

        $('#table1').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('category.list')}}",
           responsive:true,
           columns: [
                { data: 'id' },
                { data: 'name'},
                { data: 'user_id'},
                // { data: 'email' },
                // { data: 'designation' },
                // { data: 'phone' },
                {
                    "orderable": false,
                    targets: -1,
                    data: 'action',
                },
            ],
            columnDefs: [ {
                'targets': [1], // column index (start from 0)
                'orderable': false, // set orderable false for selected columns
            }],
            order: [[0, 'asc']],
        });
    });
</script>

<script>
    function openRoleModal(userId) {
        // Use JavaScript/jQuery to open the modal
        // For example, if you're using Bootstrap modal:
        $('#grantRoleModal').modal('show');

        // You can pass the user ID to the modal for further processing
        // For example, set the user ID as a value in an input field inside the modal
        $('#userIdInput').val(userId);

        // Ajax request to fetch permissions for the specific user
        
    }

    
</script>

@endsection