@extends('portal.layout.app')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Role</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Role</a></li>
                        <li class="breadcrumb-item active">Edit Role</li>
                       
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
            
                <form action="{{ route('role.update', $role->id) }}" method="POST">
                    @csrf
                    @method('PUT') <!-- This is important for the update method -->
                    <label class="form-label required">Role Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') ?? $role->name }}" required />
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
    function openRoleModal(userId) {
        // Use JavaScript/jQuery to open the modal
        // For example, if you're using Bootstrap modal:
        $('#grantRoleModal').modal('show');

        // You can pass the user ID to the modal for further processing
        // For example, set the user ID as a value in an input field inside the modal
        $('#userIdInput').val(userId);

        // Ajax request to fetch permissions for the specific user
        $.ajax({
            url: "{{ route('user.getPermission', ['userId' => ':userId']) }}".replace(':userId', userId),
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // Clear existing list
                $('#availablePermissionsList').empty();

                // Populate the list with fetched permissions
                $.each(data.allPermissions, function(index, permission) {
                    var isChecked = data.userPermissions.includes(permission.name);
                    $('#availablePermissionsList').append(
                        '<li><label><input type="checkbox" name="permissions[]" value="' +
                        permission.name +
                        '" ' + (isChecked ? 'checked' : '') +
                        '>' +
                        permission.name +
                        '</label></li>'
                    );
                });
            },
            error: function(error) {
                console.log('Error fetching permissions: ', error);
            }
        });
    }
</script>
@endsection



