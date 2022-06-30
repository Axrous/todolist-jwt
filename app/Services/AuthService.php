<?php 

namespace App\Services;

interface AuthService {
    
    public function login($request);
    public function register($request);
    public function logout();
    public function refresh();
}