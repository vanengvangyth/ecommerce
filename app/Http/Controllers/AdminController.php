<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function register(Request $request)
    {
        // Validation rules
        $rules = [
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6',
            'phonenumber' => 'required|unique:admins',
        ];
        
        // Validator instance
        $validator = Validator::make($request->all(), $rules);
        
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        
        // Create new admin
        $admin = Admin::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phonenumber' => $request->phonenumber
        ]);
        
        // Generate API token
        $token = $admin->createToken('Personal Access Token')->plainTextToken;
        
        // Response with admin data and token
        $response = ['admin' => $admin, 'token' => $token];
        return response()->json($response, 201); // Changed to 201 (Created)
    }

    public function login(Request $request)
    {
        // Validation rules
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string'
        ];
        
        $request->validate($rules);
        
        // Find admin by email
        $admin = Admin::where('email', $request->email)->first();
        
        // Check if admin exists and password is correct
        if ($admin && Hash::check($request->password, $admin->password)) {
            // Generate API token
            $token = $admin->createToken('Personal Access Token')->plainTextToken;
            
            // Response with admin data and token
            $response = ['admin' => $admin, 'token' => $token];
            return response()->json($response, 200);
        }
        
        // If credentials are incorrect
        $response = ['message' => 'Incorrect email or password'];
        return response()->json($response, 400);
    }
}
