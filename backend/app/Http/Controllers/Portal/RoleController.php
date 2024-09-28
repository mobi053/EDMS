<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
// use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('permission:view role', ['only' => ['index']]);
    //     $this->middleware('permission:create role', ['only' => ['create','store','addPermissionToRole','givePermissionToRole']]);
    //     $this->middleware('permission:update role', ['only' => ['update','edit']]);
    //     $this->middleware('permission:delete role', ['only' => ['destroy']]);
    // }

    public function index()
    {
        $roles = Role::get();
        // dd($roles);
        return view('portal.role.index', ['roles' => $roles]);
    }
    public function get_permission($userId)
    {
        $user = Role::find($userId);
        $allPermissions = Permission::all();
        $userPermissions = $user->permissions->pluck('name')->toArray();

        return response()->json([
            'allPermissions' => $allPermissions,
            'userPermissions' => $userPermissions,
        ]);
    }
    public function assign_permission(Request $request)
    {
        $userId = $request->user_id;
        $permissions = $request->permissions;

        // Retrieve the user
        $user = Role::find($userId);

        // Attach the selected permissions to the user
        $user->syncPermissions($permissions);

        return redirect()->back()->with('success', 'Permissions assigned successfully');
    }
    public function list(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Role::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Role::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();
        $records = Role::orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $route = route('role.edit', $record->id);
            $delete_route = route('role.delete', $record->id); 
            $data_arr[] = array(
                "id" => $record->id,
                "name" => $record->name,
                "action" =>
                    '<div class="btn-group">
                   
                    <a href="' . $route . '" class="mr-1 text-info" title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="#" onclick="delete_confirmation(\'' . $delete_route . '\')" class="mr-1 text-danger" title="Cancel">
                        <i class="fa fa-times"></i>

                    </a>
                    <a href="#" onclick="openRoleModal(' . $record->id . ')" class="mr-1 text-success" title="Grant Permission">
                                    <i class="fa fa-plus"></i>
                    </a>
                </div>' 
            );
        }
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );
        return \Response::json($response);
    }
    public function add()
    {       
        return view('portal.role.add'); 
    }
    public function create()
    {
        return view('role-permission.role.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:roles,name'
            ]
        ]);

        Role::create([
            'name' => $request->name
        ]);

        return redirect('roles')->with('status','Role Created Successfully');
    }

    public function edit(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        // dd($role);
        return view('portal.role.edit',compact('role'));
    }

    public function update(Request $request, $role)
    {
        // dd($request->name);
        Role::where("id", $role)->update([
            "name" => $request->name,           
        ]);

        return redirect('roles')->with('status','Role Updated Successfully');
    }

    public function destroy($roleId)
    {
        $role = Role::find($roleId);
        $role->delete();
        return redirect('roles')->with('status','Role Deleted Successfully');
    }

    public function addPermissionToRole($roleId)
    {
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
                                ->where('role_has_permissions.role_id', $role->id)
                                ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
                                ->all();

        return view('role-permission.role.add-permissions', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function givePermissionToRole(Request $request, $roleId)
    {
        $request->validate([
            'permission' => 'required'
        ]);

        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);

        return redirect()->back()->with('status','Permissions added to role');
    }
}
