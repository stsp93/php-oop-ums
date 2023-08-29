<?php
include dirname(__DIR__) . '/config/Database.php';

class User
{
    private $username;
    private $email;
    private $password_hash;
    private $role;
    private $id;

    private $db;

    public function __construct(string $username = null, string $password = null, string $email = null, string $role = 'user', int $id = null)
    {
        $this->db = new Database;
        $this->setUsername($username);
        $this->setPasswordHash($password);
        $this->setEmail($email);
        $this->setRole($role);
        $this->setId($id);
    }
    // getters
    public function getUsername()
    {
        return $this->username;
    }
    public function getPasswordHash()
    {
        return $this->password_hash;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function getId()
    {
        return $this->id;
    }

    // setters
    private function setUsername(string | null $username)
    {
        $this->username = htmlspecialchars($username);
    }
    private function setPasswordHash(string | null $password)
    {
        // Hash Password
        $this->password_hash = password_hash($password, PASSWORD_BCRYPT);
    }
    private function setEmail(string | null $email)
    {
        $this->email = $email;
    }
    private function setRole(string $role)
    {
        $this->role = $role;
    }
    private function setId(int | string | null $id)
    {
        $this->id = $id;
    }

    // create user(CREATE)
    public function create()
    {
        return $this->db->insert(['username', 'email', 'password_hash', 'user_role'], [$this->getUsername(), $this->getEmail(), $this->getPasswordHash(), $this->getRole()]);
    }

    // find user(READ)
    public function findUser($searchBy, $value = null)
    {
        if ($searchBy === 'username') {
            $user = $this->db->selectOne($searchBy, $this->getUsername());
        } elseif ($searchBy === 'email') {
            $user = $this->db->selectOne($searchBy, $this->getEmail());
        } elseif ($searchBy === 'user_id') {
            $user = $this->db->selectOne($searchBy, $value ?? $this->getId());
        }
        if (!empty($user)) {
            $this->setUsername($user['username']);
            $this->setEmail($user['email']);
            $this->password_hash = $user['password_hash'];
            $this->setRole($user['user_role']);
            $this->setId($user['user_id']);
            return $this;
        }
    }

    public function getAll()
    {
        return $this->db->selectAll();
    }

    // edit user(UPDATE)
    public function edit($userId)
    {
        return $this->db->update($userId, [$this->getUsername(), $this->getEmail(), $this->getRole()]);
    }

    // remove user(UPDATE)
    public function remove($userId)
    {
        return $this->db->delete($userId);
    }
}
