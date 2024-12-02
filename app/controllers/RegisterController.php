<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        $this->render('register');
    }

    public function register()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $role = 'user'; // Default role

        $userModel = new User();
        if ($userModel->findByEmail($email)) {
            $this->render('register', ['error' => 'Email already registered.']);
        } else {
            $userModel->create($name, $email, $password, $role);
            $this->redirect('/login');
        }
    }
}
