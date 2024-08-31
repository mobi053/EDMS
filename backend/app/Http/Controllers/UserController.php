<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
    public function show()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
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

       
            // $request->validate([
            //     // 'email' => 'required|unique:users',
            //     // 'name' => 'required|max:150',
            //     // 'designation' => 'required|max:150',
            //     // 'phone' => 'required|max:11',
            //     // 'employee_id' => 'required|max:20',
            //     // 'password' => 'required|min:6|max:20',
            //     // 'unit_id' => 'required'

            // ]);

            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                // Add other fields as needed
            ]);
            $user->save();
        
            return redirect()->route('users.index')->with('success', 'User created successfully');
       
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

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
