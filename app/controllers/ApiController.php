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
        $users = $this->userModel->updateLogoutTimeRomve($user['id']);
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
        $role = $data['role'] ?? null;

        if ($this->userModel->findByEmail($email)) {
            http_response_code(400);
            echo json_encode(['error' => 'Email already exists.']);
            return;
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->userModel->create($name, $email, $hashedPassword, $role);

        echo json_encode(['message' => 'Registration successful']);
    }

    public function getUserDetails($request)
    {
        //print_r($request);
        $user = $request; //['user'];
        echo json_encode(['user' => $user]);
    }
    public function logout($request)
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (strpos($authHeader, 'Bearer ') !== 0) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid Authorization header.']);
            return;
        }

        $token = substr($authHeader, 7); // Extract token

        // Decode the token to identify the user
        $jwtUtil = new JWTUtil(CONFIG);
        try {
            $decoded = $jwtUtil->verify($token, null);
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(['message' => 'Invalid token.']);
            return;
        }

        // Update user's logout_time in the database
        $userModel = new User();
        $userModel->updateLogoutTime($decoded->id);

        http_response_code(200);
        echo json_encode(['message' => 'Successfully logged out.']);
    }
}
