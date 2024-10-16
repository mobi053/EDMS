<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Dir;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // dd($request->email);
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            $users=User::all();
            // dd($users);
            return view('portal.users.index', compact('users'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            // Assuming tokens are stored in a `personal_access_tokens` table
            DB::table('personal_access_tokens')->where('token', $request->bearerToken())->delete();

            // Alternatively, if you store tokens in a different table or in a different way, adjust accordingly
            // e.g., $user->tokens()->where('token', $request->bearerToken())->delete();

            return view('welcome');
        }
        return view('welcome');
    }

    public function apiLogout(Request $request)
    {
        $token = $request->bearerToken();
        \Log::info('Logout token:', [$token]);
        $user = Auth::user();
        if ($user) {
            DB::table('personal_access_tokens')->where('token', $token)->delete();
            return response()->json(['message' => 'Logged out successfully'], 200);
        }
        \Log::info('User not authenticated');
        return response()->json(['message' => 'User not authenticated'], 401);
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
                'user' =>[
                    'id' =>$request->user()->id,
                    'name' => $request->user()->name,
                ],
                'message' => 'Login successful',
            ], 200);
        }

        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'The provided credentials do not match our records.',
        ], 401);
    }
}
