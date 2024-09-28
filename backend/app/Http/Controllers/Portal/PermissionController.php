<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\User;
use App\Mail\SignUp;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Exception;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
 public function index()

    {   
          
        return view('portal.permission.index');
    }

    public function add()
    {       
        return view('portal.permission.add'); 
    }

    public function edit($id)
    {

        $user = Permission::findorfail($id);
        return view('portal.permission.edit', compact('user'));
    }

    public function delete($id)
    {

        $permission  = Permission::where('id', $id)->delete();
        return redirect()->route('permission.index')->with('success', 'Permission deleted successfully');
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
        $totalRecords = Permission::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Permission::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();
        $records = Permission::orderBy($columnName, $columnSortOrder)
            ->where('name', 'like', '%' . $searchValue . '%')
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $route = route('permission.edit', $record->id);
            $delete_route = route('permission.delete', $record->id); 
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
    public function store(Request $request)
    {   
        $request->validate([
            'name' => 'required|max:150',
        ]);
    
        // Create a new permission
        $permission = Permission::create(['name' => $request->name]);
    
        // Assign the permission to a role (if roles are provided in the request)
        if ($request->has('role')) {
            $role = Role::findByName($request->role);
            $role->givePermissionTo($permission);
        }
    
        return redirect()->route('permission.index')->with('success', 'Permission created successfully');
    }
    public function update(Request $request, $id)
    {
        

        Permission::where("id", $id)->update([
            "name" => $request->name,           
        ]);

        return redirect()->route('permission.index')->with('success', 'User updated successfully');
    }       
}


