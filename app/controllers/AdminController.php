<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AdminController extends Controller
{
    public function userList()
    {

        if ($_SESSION['role'] !== 'Admin') {
            $this->redirect('/dashboard');
        }

        $users = (new User())->getAll();
        $this->render('user_list', ['users' => $users]);
    }

    public function edit_user()
    {
        if ($_SESSION['role'] !== 'Admin') {
            $this->redirect('/dashboard');
        }
        $id = $_GET['id'];
        // echo $id;
        // exit();
        $user = (new User())->find($id);
        $this->render('edit_user', ['users' => $user]);
    }

    public function submit_edit_user()
    {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        (new User())->update($id, $name, $email, $role);
        $this->redirect('/user-list');
    }

    public function delete_user()
    {
        if ($_SESSION['role'] !== 'Admin') {
            $this->redirect('/dashboard');
        }
        $id = $_GET['id'];
        (new User())->delete_user($id);
        $this->redirect('/user-list');
    }
}
