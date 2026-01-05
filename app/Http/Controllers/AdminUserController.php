<?php

namespace App\Http\Controllers;

use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => User::select('id', 'name', 'email', 'role', 'created_at')
                        ->orderBy('created_at', 'desc')
                        ->get()
        ]);
    }
}
