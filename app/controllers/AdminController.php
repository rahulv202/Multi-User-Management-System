<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AdminController extends Controller
{
    public function userList()
    {
        session_start();
        if ($_SESSION['role'] !== 'admin') {
            $this->redirect('/dashboard');
        }

        $users = (new User())->getAll();
        $this->render('user_list', ['users' => $users]);
    }
}