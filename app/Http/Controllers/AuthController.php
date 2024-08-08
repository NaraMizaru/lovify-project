<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $credential = Validator::make($request->all(), [
            'fullname' => ['required', 'string'],
            'username' => ['required', 'string', 'min:2', 'max:12', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'number_phone' => ['required', 'string'],
        ]);

        if ($credential->fails()) {
            return redirect()->back()->withErrors($credential->errors())->withInput($request->all());
        }

        $user = new User();
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->fullname;
        $user->number_phone = $request->fullname;
        $user->save();

        Auth::login($user);
        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $login = $request->login;
        $type = filter_var($login, FILTER_VALIDATE_EMAIL);
        if ($type) {
            if (Auth::attempt(['email' => $request->login, 'password' => $request->password])) {
                $user = Auth::user();
                if ($user->role == 'admin') {
                    return redirect()->route('home.admin');
                }
                return redirect()->route('home');
            } else {
                return redirect()->back()->with('message', 'Invalid Credentials');
            }
        } else {
            if (Auth::attempt(['username' => $request->login, 'password' => $request->password])) {
                $user = Auth::user();
                if ($user->role == 'admin') {
                    return redirect()->route('home.admin');
                }
                return redirect()->route('home');
            } else {
                return redirect()->back()->with('message', 'Invalid Credentials');
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }
}
