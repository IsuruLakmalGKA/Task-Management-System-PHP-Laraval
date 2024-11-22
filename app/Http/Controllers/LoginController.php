<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

    public function login()
    {
        return view('login');
    }
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('username', 'password');

    //     if (LoginController::attempt($credentials)) {
    //         return response()->json(['status' => 200, 'message' => 'Login successful']);
    //     } else {
    //         return response()->json(['status' => 401, 'message' => 'Invalid username or password']);
    //     }
    // }
}
