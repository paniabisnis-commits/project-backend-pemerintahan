<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * REGISTER USER
     */
    public function register(Request $r)
{
    $data = $r->validate([
        'name'     => 'required|string',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'phone'    => 'nullable|string'
        
    ]);

    $user = User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => bcrypt($data['password']),
        'phone'    => $data['phone'] ?? null,
        'role'     => 'user',  // ← otomatis user
    ]);

    return response()->json([
        'message' => 'Register success',
        'user' => $user
    ], 201);
}

    /**
     * LOGIN
     */
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Email atau password salah'
        ], 401);
    }

    // ⬇️ TOKEN SANCTUM
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
}

    public function updateProfile(Request $request)
{
    $user = $request->user();

    $request->validate([
        'name' => 'sometimes|string',
        'email' => 'sometimes|email|unique:users,email,' . $user->id,
        'password' => 'sometimes|confirmed|min:6',
    ]);

    if ($request->name) {
        $user->name = $request->name;
    }

    if ($request->email) {
        $user->email = $request->email;
    }

    if ($request->password) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return response()->json([
        'message' => 'Profile updated successfully',
        'user' => $user
    ]);
}

    /**
     * GET USER LOGGED IN
     */
    public function user(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }
}
