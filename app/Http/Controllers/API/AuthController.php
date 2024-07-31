<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string',
            'username' => 'required|string|min:2|max:12|unique:users,username',
            'email' => 'required|email|string|unique:users,email',
            'password' => 'required|string|min:4|confirmed',
            'number_phone' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = new User();
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->number_phone = $request->number_phone;
        $user->save();

        if ($user->save()) {
            $token = $user->createToken('api_token')->plainTextToken;

            return response()->json([
                'message' => 'Register Successfully',
                'token' => $token,
                'user' => $user
            ], 201);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'credentials' => 'required',
            'password' => 'required|string|min:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Invalid fields',
                'errors' => $validator->errors(),
            ], 400);
        }

        $credentials = $request->credentials;
        $fieldType = filter_var($credentials, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $auth = Auth::attempt([$fieldType => $credentials, 'password' => $request->password]);
        if ($auth) {
            $token = $request->user()->createToken('api_token')->plainTextToken;

            return response()->json([
                'message' => 'Login Successfully',
                'token' => $token,
                'user' => Auth::user()
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout Successfully',
        ], 200);
    }
}
