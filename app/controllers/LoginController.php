<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class LoginController extends Controller
{
    public function index()
    {
        //echo "LoginController@index called successfully";
        $this->render('login');
    }

    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = (new User())->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            // session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];

            $this->redirect('/dashboard');
        } else {
            $this->render('login', ['error' => 'Invalid credentials.']);
        }
    }
}
