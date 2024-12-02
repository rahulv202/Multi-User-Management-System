<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $user_id = $_SESSION['user_id'];
        $user = new User();
        $users = $user->find($user_id);
        $this->render('dashboard', array('users' => $users));
    }

    public function user_list()
    {
        if ($_SESSION["role"] == "Admin") {
            $user = new User();
            $users = $user->getAll();
            $this->render('user_list', array('users' => $users));
        } else {
            $this->redirect('dashboard'); // redirect to dashboard
        }
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/login'); // redirect to login page
    }
}
