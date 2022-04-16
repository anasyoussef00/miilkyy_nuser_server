<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Models\User;

class Authentication extends Controller
{
    public function register(Request $req)
    {
        // dd($req['birthdate']);
        $fields = $req->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'nusername' => 'required|string|unique:users,nusername|min:3|max:17',
            'email' => 'required|email',
            'password' => 'required|string|min:3|max:30',
            'birthdate' => 'required|date_format:Y-m-d|after_or_equal:1930-01-01|before:2004-12-31'
        ]);


        $nuser = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'nusername' => $fields['nusername'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password']),
            'birthdate' => $fields['birthdate']
        ]);

        $token = $nuser->createToken("miilkyy_nuser")->plainTextToken;

        return response()->json([
            'message' => 'Nuser created successfully',
            'token' => $token,
            'nuser_obj' => $nuser
        ]);
    }

    public function login(Request $req)
    {
        $fields = $req->validate([
            'nusername' => 'required|string',
            'password' => 'required|string'
        ]);

        $nuser = User::where('nusername', $fields['nusername'])->first();

        if(!$nuser || !Hash::check($fields['password'], $nuser->password)) {
            throw ValidationException::withMessages([
                'nusername' => ['The provided credentials are incorrect']
            ]);
        }

        $token = $nuser->createToken("miilkyy_nuser")->plainTextToken;

        return response()->json([
            'message' => 'Nuser logged in successfully',
            'token' => $token,
            'nuser_obj' => $nuser
        ]);
    }
}
