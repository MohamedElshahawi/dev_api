<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
        // User Register (POST, form data)
        public function register(Request $request){

            // data validation
            $request->validate([
                "name" => "required",
                "phone_number" =>['required', 'regex:/^[0-9]{11}$/'],
                "email" => "required|email|unique:users",
                'password' => [
                    'required',
                    'confirmed',
                    'min:8',              // Minimum length of 8 characters
                    'regex:/^(?=.*[A-Z])/',  // At least one uppercase letter
                    'regex:/^(?=.*[a-z])/',  // At least one lowercase letter
                    'regex:/^(?=.*[@$!%*?&])/', // At least one special character
                    'regex:/^\S*$/',          // Disallow spaces
                    'regex:/^(?=.*\d)/',      // Require at least one numeric digit
                ],
            ]);

            // User Model
            User::create([
                "name" => $request->name,
                "phone_number" => $request->phone_number,
                "email" => $request->email,
                "password" => Hash::make($request->password)
            ]);

            // Response
            return response()->json([
                "status" => "success",
                "message" => "User Registered Successfully"
            ], 201); // 201 is the HTTP status code for Created
        }

        // User Login (POST, form data)
        public function login(Request $request){

            // data validation
            $request->validate([
                "email" => "required|email",
                "password" => "required"
            ]);

            // JWTAuth
            $token = JWTAuth::attempt([
                "email" => $request->email,
                "password" => $request->password
            ]);

            if(!empty($token)){

                return response()->json([
                    "status" => "success",
                    "message" => "User Logged in Successfully",
                    "token" => $token
                ], 200); // 200 is the HTTP status code for OK
            }

            return response()->json([
                "status" => "error",
                "message" => "Invalid Email or Password"
            ], 401); // 401 is the HTTP status code for Unauthorized

        }




        // User Logout (GET)
        public function logout(){

            auth()->logout();

            return response()->json([
                "status" => 'success',
                "message" => "User Logged out Successfully"
            ] , 200);
        }
}
