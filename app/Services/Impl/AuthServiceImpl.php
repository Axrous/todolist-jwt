<?php

namespace App\Services\Impl;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Services\AuthService;

class AuthServiceImpl implements AuthService {

    public function login($request)
    {
        $validation = Validator::make($request,[
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        if($validation->fails()) {
            throw new Exception($validation->errors()->first());
        }

        $token = Auth::attempt($request);

        if(!$token) {
            throw new Exception('Unauthorized');
        }

        $user = Auth::user();

        return [
            'token' => $token,
            'user' => $user
        ];

    }

    public function register($request)
    {
        $validation = Validator::make($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if($validation->fails()) {
            throw new Exception($validation->errors()->first());
        }

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']) 
        ]);

        $token = Auth::login($user);

        return [
            'user' => $user,
            'token' => $token
        ];

    }

    public function logout()
    {
        Auth::logout();
    }

    public function refresh()
    {
        $user = Auth::user();
        $refresh = Auth::refresh();

        return [
            'user' => $user,
            'refresh' => $refresh
        ];
    }
}