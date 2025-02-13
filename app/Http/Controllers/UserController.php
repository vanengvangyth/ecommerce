<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function register(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'phonenumber' => 'required|unique:users',
        ];
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }
        // create new user in user table
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phonenumber' => $request->phonenumber
        ]);
        $token = $user->createToken('Personal Access Token')->plainTextToken;
        $response = ['user' => $user,'token' => $token];
        return response()->json($response, 200);
    }

    public function login(Request $request)
    {
        // validate input
        $rules = [
            'email' => 'required',
            'password' => 'required|string'
        ];
        $request->validate($rules);
        // find user email in user table
        $user = User::where('email', $request->email)->first();
        // if user email found and password is correct
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $response = ['user' => $user,'token' => $token];
            return response()->json($response, 200);
        }
        $response = ['message' => 'Incrorect email or password'];
        return response()->json($response, 400);
    } 

    public function getAll()
    {
        $users = User::all(); // Retrieve all users
        return response()->json(['users' => $users], 200);
    }
}