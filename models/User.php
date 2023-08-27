<?php
include '../config/Database.php';

class User
{
    private $username;
    private $email;
    private $password_hash;
    private $role;
    private $id;

    private $db;

    public function __construct($username,$password_hash = null, $email = null, $role = 'user' ,$id = null)
    {
        $this->db = new Database;
        $this->username = $username;
        $this->password_hash = $password_hash;
        $this->email = $email;
        $this->role = $role;
        $this->id = $id;
    }
    // getters
    public function getUsername() {
        return $this->username;
    }
    public function getPasswordHash() {
        return $this->password_hash;
    }
    public function getEmail() {
        return $this->email;
    }
    public function getRole() {
        return $this->role;
    }
    public function getId() {
        return $this->id;
    }

    // setters
    public function setUsername($username) {
        $this->username = $username;
    }

    public function setPasswordHash($password_hash) {
        $this->password_hash = $password_hash;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setRole($role) {
        $this->role = $role;
    }
    public function setId($id) {
        $this->id = $id;
    }

    // create user(CREATE)
    public function save()
    {
        return $this->db->query("INSERT INTO users (username, email,password_hash ) VALUES (?, ?, ?)",$this->username, $this->email, $this->password_hash);
    }

    // find user(READ)
    public function findUser() {
        // TODO:
        $user = $this->db->query("SELECT * FROM users WHERE username = ?", $this->username)[0];
        if(!empty($user)) {
            $this->setEmail($user['email']);
            $this->setPasswordHash($user['password_hash']);
            $this->setRole($user['user_role']);
            $this->setId($user['user_id']);
            return $this;
        }
    }
    public function findEmail() {
        // TODO:
        return $this->db->query("SELECT * FROM users WHERE email = ?", $this->email)[0];
    }
}
