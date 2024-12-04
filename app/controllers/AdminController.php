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

    public function getUserList($request)
    {
        // print_r($request['user']->role);
        if ($request['user']->role !== 'Admin') {
            //$this->redirect('/api/user-details');
            echo json_encode(['error' => 'Unauthorized access.']);
            return;
        }
        $users = (new User())->getAll();
        echo json_encode(['users' => $users]);
    }

    public function editUser($request)
    {
        if ($request['user']->role !== 'Admin') {
            // $this->redirect('/api/user-details');
            echo json_encode(['error' => 'Unauthorized access.']);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? null;
        $name = $data['name'] ?? null;
        $email = $data['email'] ?? null;
        $role = $data['role'] ?? null;

        if (!$id || !(new User())->find($id)) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found.']);
            return;
        }

        (new User())->update($id, $name, $email, $role);
        echo json_encode(['message' => 'User updated successfully']);
    }

    public function deleteUser($request)
    {
        if ($request['user']->role !== 'Admin') {
            // $this->redirect('/api/user-details');
            echo json_encode(['error' => 'Unauthorized access.']);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $id = $data['id'] ?? null;

        if (!$id || !(new User())->find($id)) {
            http_response_code(404);
            echo json_encode(['error' => 'User not found.']);
            return;
        }

        (new User())->delete_user($id);
        echo json_encode(['message' => 'User deleted successfully']);
    }
}
