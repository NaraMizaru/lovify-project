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
            'fullname' => ['required','string'],
            'username' => ['required','string', 'min:2', 'max:12'],
            'email' => ['required','string','email','max:255', 'unique:users,email'],
            'password' => ['required','string','min:8','confirmed'],
            'number_phone' => ['required','string'],
        ]);

        if ($credential->fails())
        {
            return redirect()->back()->withErrors($credential->errors())->withInput($request->all());
        }

        $image = $request->file('profile_image');
        $path = $image->store('profile_image' . $request->username, 'public');

        $user = new User();
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->fullname;
        $user->number_phone = $request->fullname;
        $user->profile_image = $path;
        $user->save();

        Auth::login($user);
        return redirect()->route('home');
    }

    public function login(Request $request)
    {
        $check = Auth::attempt(['username' => $request->username, 'password' => $request->password]); 
        if ($check) {
            $user = Auth::user();
            if ($user->role == 'admin') return redirect()->route('homeAdmin');

            return redirect()->route('home');
        };
        return redirect()->back()->with('error', 'Username or Password is incorrect!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
