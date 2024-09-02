<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Dir;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class LoginController extends Controller
{
    public function alluser(){
        $user=User::all();
        return response()->json(['users'=>$user]);
    }
    // public function alluser(){
    //     $user=Dir::all();
    //     return response()->json(['users'=>$user]);
    // }
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // dd($request->email);
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            // $users=User::all();
            return view('welcome');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
    public function apiLogin(Request $request)
    {   
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Generate an API token or use JWT (JSON Web Token)
            $token = $request->user()->createToken('API Token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'message' => 'Login successful',
            ]);
        }

        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'The provided credentials do not match our records.',
        ], 401);
    }
}
