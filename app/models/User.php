<?php

namespace App\Models;

use App\Core\Database;

class User extends Database
{
    protected $table = 'users';
    public function __construct()
    {
        parent::__construct(CONFIG); // Ensure Model's constructor is called
    }

    public function findByEmail($email)
    {

        return $this->db->query("SELECT * FROM {$this->table} WHERE email = '$email'")->fetch();
    }

    public function find($id)
    {
        return $this->db->query("SELECT * FROM {$this->table} WHERE id = $id",)->fetch();
    }

    public function create($name, $email, $password, $role)
    {
        $this->db->query("INSERT INTO {$this->table} (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')");
    }
    public function update($id, $name, $email, $role)
    {
        $this->db->query("UPDATE {$this->table} SET name = '$name', email = '$email', role = '$role' WHERE id = $id");
    }

    public function getAll()
    {
        return $this->db->query("SELECT * FROM {$this->table}")->fetchAll();
    }

    public function delete_user($id)
    {
        $this->db->query("DELETE FROM {$this->table} WHERE id = $id");
    }
}
