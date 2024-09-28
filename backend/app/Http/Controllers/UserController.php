<?php

namespace App\Http\Controllers;

use App\Models\User;
use finfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Models\Role;


class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this-> middleware('permission:view user', ['only' => ['index']]);
    //     $this->middleware('permission:create user', ['only' => ['create','store']]);
    //     $this->middleware('permission:update user', ['only' => ['update','edit']]);
    //     $this->middleware('permission:delete user', ['only' => ['destroy']]);
    // }

    public function index()
<<<<<<< Updated upstream
    {
        $users = User::all();
        return view('users.index', compact('users'));
=======
    {   
        if(auth()->user()->hasRole('supervisor')){

            // dd(auth()->user());
            $users = User::all();
            return view('portal.users.index', compact('users'));
        }else{
            return redirect()->back()->with(['error', 'You are not authorised to view this page']);
        }
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
        $totalRecords = User::select('count(*) as allcount')->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->orWhere('email', 'like', '%' . $searchValue . '%')->count();
        $records = User::orderBy($columnName, $columnSortOrder)
            ->where(function ($query) use ($searchValue) {
                $query->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%');
            })
            // /->where('role', 'Employee') // Add the condition for role
            ->select('*')
            ->skip($start)
            ->take($rowperpage)
            ->orderBy($columnName, $columnSortOrder)
            ->get();

        $data_arr = array();
        $serialNumber = $start + 1;


        foreach ($records as $record) {
            $route = route('users.edit', $record->id);
            $delete_route = route('users.delete', $record->id);


            $user = auth()->user();

                // User has at least one of the required permissions
                $action = '<div class="btn-group">';
                    if(auth()->user()->hasRole('supervisor')){
                    $action .= '<a href="#" onclick="openRoleModal(' . $record->id . ')" class="mr-1 text-success" title="Grant Role">
                                    <i class="fa fa-plus"></i>
                                </a>';
                    }

                    $action .= '<a href="' . $route . '" class="mr-1 text-info" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>';
                

                    $action .= '<a href="#" onclick="delete_confirmation(\'' . $delete_route . '\')" class="mr-1 text-danger" title="Cancel">
                                    <i class="fa fa-times"></i>

                                </a>';
                

                $action .= '</div>';
          

            $target_route = 'userdashboard/index';
            $recordid = $record->id;
            $data_arr[] = array(
                "id" => $serialNumber++, // Assuming $iteration is your loop counter variable  "name" => '<a href="'.$target_route.'/'.$recordid.'">'.$record->name.'</a>',
                "name" => $record->name,
                "email" => $record->email,
                "action" =>
                $action
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return \Response::json($response);
>>>>>>> Stashed changes
    }
    public function assign_role(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'array',
            'roles.*' => 'exists:roles,name',
        ]);
    
        $user = User::find($request->user_id);
        $user->syncRoles($request->roles); // Sync roles with the user
    
        return redirect()->route('users.index')->with('success', 'Roles assigned successfully');
    }
    public function get_role($userId)
    {
        $user = User::find($userId);
        $roles = Role::all();
        $userRoles = $user->roles()->pluck('name')->toArray(); // Fetch role names instead of IDs
    
        return response()->json([
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
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

    public function alluser(Request $request) {
        // Get the page number and items per page from the request
        $page = $request->input('page', 1); // Default to page 1 if not provided
        $limit = $request->input('limit', 10); // Default to 10 items per page if not provided
    
        // Apply pagination
        $users = User::paginate($limit, ['*'], 'page', $page);
    
        // Return the paginated data as JSON
        return response()->json([
            'users' => $users->items(), // Return the paginated items
            'total' => $users->total(), // Total number of items
            'current_page' => $users->currentPage(), // Current page number
            'last_page' => $users->lastPage(), // Last page number
        ]);
    }


    public function show()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $users=User::all();
        $roles=Role::all();
        return view('portal.users.add', compact('users','roles'));
    }

    public function store(Request $request)
    {
        try {
            // Validate request data
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);
    
            // Create a new user
            $user = new User([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);
    
            // Save the user
            $user->save();
    
            // Return success response
            return response()->json(['success' => 'User added successfully'], 201);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error creating user: ' . $e->getMessage());
    
            // Return error response
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }
    

    public function stored(Request $request)
    {

            // dd($request->role);
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                // Add other fields as needed
            ]);
            $user->save();
            // $role = Role::findById($request->role);
            $user->assignRole($request->role); 
            return redirect()->route('users.index')->with('success', 'User created successfully');
       
    }

    public function edit($user)
    {
        $user=User::find($user);
        $users=User::all();
        $roles=Role::all();
        return view('portal.users.edit', compact('user','users','roles'));
    }

    public function update(Request $request, User $user)
    {
        

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $del=User::where('id', $id)->delete();
        return response()->json(['success' => 'User deleted successfully'], 200);
    }
    
}
