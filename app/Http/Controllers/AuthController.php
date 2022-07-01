<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private AuthService $authService;
    
    public function __construct(AuthService $authService)
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);

        $this->authService = $authService;
    }

    public function login(Request $request) {
        
        $data = $request->only([
            'email',
            'password'
        ]);

        try {
            $result = $this->authService->login($data);
        } catch(Exception $exception) {
            return response()->json([
                'status' =>"error",
                'message' => $exception->getMessage()
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'user' => [
                'id' => $result['user']['id'],
                'name' => $result['user']['name'],
            ],
            'authorisation' => [
                'token' => $result['token'],
                'type' => 'bearer'
            ]
            ],200)->withHeaders([
                'X-USER-TOKEN' => $result['token']
            ]);
            // ->withCookie('X-USER-TOKEN', $result['token']);    
    }

    public function register(Request $request) {

        $data = $request->only(
            'name',
            'email',
            'password',
        );

        try{
            $result = $this->authService->register($data);
        } catch(Exception $exception) {
            return response()->json([
                'status' => 'Failed',
                'message' => $exception->getMessage()
            ],500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User created Successfully',
            'user' => $result['user'],
            'authorisation' => [
                'token' => $result['token'],
                'type' => 'bearer'
            ]
            ]);
    }

    public function logout() {
        $this->authService->logout();

        return response()->json([
            'status' => 'Success',
            'message' => 'Successfully logged out'
        ]);
    }

    public function refresh() {

        $result = $this->authService->refresh();
        return response()->json([
            'status' => 'success',
            'user' => $result['user'],
            'authorisation' => [
                'token' => $result['refresh'],
                'type' => 'bearer',
            ]
        ]);
    }
}
