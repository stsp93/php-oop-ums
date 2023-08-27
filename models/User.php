<?php
include '../config/Database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;
    }

    public function register(array $payload)
    {
        return $this->db->query("INSERT INTO users (username, email,password_hash ) VALUES (?, ?, ?)",$payload['username'], $payload['email'], $payload['password_hash']);
    }

    public function findUsername(string $username) {
        return $this->db->query("SELECT * FROM users WHERE username = ?", $username)[0];
    }
    public function findEmail(string $email) {
        return $this->db->query("SELECT * FROM users WHERE email = ?", $email)[0];
    }
}
