<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        $this->render('login');
    }

    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = (new User())->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            $this->redirect('/dashboard');
        } else {
            $this->render('login', ['error' => 'Invalid credentials.']);
        }
    }

    public function dashboard()
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $user = (new User())->find($_SESSION['user_id']);
        $this->render('dashboard', ['user' => $user]);
    }

    public function logout()
    {
        session_start();
        session_destroy();
        $this->redirect('/login');
    }
}
