<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Utils\JWTUtil;

class ApiController extends Controller
{
    private $userModel;
    private $jwtUtil;

    public function __construct()
    {
        $this->userModel = new User();
        //$jwtConfig = include 'config.php';
        $this->jwtUtil = new JWTUtil(CONFIG); //$jwtConfig['jwt']
    }

    public function login()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        $user = $this->userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid email or password.']);
            return;
        }

        $token = $this->jwtUtil->generateToken(['id' => $user['id'], 'role' => $user['role']]);
        echo json_encode(['token' => $token, 'message' => 'Login successful']);
    }

    public function register()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        if ($this->userModel->findByEmail($email)) {
            http_response_code(400);
            echo json_encode(['error' => 'Email already exists.']);
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->userModel->create(['name' => $name, 'email' => $email, 'password' => $hashedPassword]);

        echo json_encode(['message' => 'Registration successful']);
    }

    public function getUserDetails($request)
    {
        $user = $request['user'];
        echo json_encode(['user' => $user]);
    }
}
