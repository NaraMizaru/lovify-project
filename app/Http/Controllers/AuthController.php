<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
            'profile_image' => ['required', 'file', 'image', 'mimes:jpg, png, jpeg'],
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
    }
}
