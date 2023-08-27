<?php
include '../models/User.php';
include '../helpers/session_helper.php';

class UserManagement
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = new User;
    }

    public function register()
    {
        $payload['username'] = $_POST['username'];
        $payload['email'] = $_POST['email'];
        $payload['password'] = $_POST['password'];
        $payload['rePassword'] = $_POST['rePassword'];

        $payload['password_hash'] = password_hash($payload['password'], PASSWORD_BCRYPT);

        // Validations

        // if empty field
        array_walk($payload, function ($value) {
            if (empty($value)) {
                setWarning('Fill all fields');
                redirect('../register.php');
            }
        });
        // invalid mail
        if (!filter_var($payload['email'], FILTER_VALIDATE_EMAIL)) {
            setWarning('Invalid email');
        }
        // username < 3 chars
        if (strlen($payload['username']) < 3) {
            setWarning('Username should be atleast 3 chars');
        }
        // pass < 3 chars
        if (strlen($payload['password']) < 3) {
            setWarning('Password should be atleast 3 chars');
        }
        // pass dont match
        if ($payload['password'] !== $payload['rePassword']) {
            setWarning('Passwords don\'t match');
        }

        // username taken
        if (!empty($this->userModel->findUsername($payload['username']))) {
            setWarning('Username is taken');
        }
        // email taken
        if (!empty($this->userModel->findEmail($payload['email']))) {
            setWarning('Email is taken');
        }

        // Check for warnings guard clause
        if (!noWarnings()) {
            redirect('../register.php');
        }

        try {
            $this->userModel->register($payload);
            redirect('../login.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function login()
    {
        $payload['username'] = $_POST['username'];
        $payload['password'] = $_POST['password'];

        try {
            // validate login
            $user = $this->userModel->findUsername($payload['username']);



            if (password_verify($payload['password'], $user['password_hash'])) {
                // save session
                setSession($user['user_id']);
                redirect('../index.php');
            } else {
                setWarning('Invalid Username or Password');
                redirect('../login.php');
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }
}

$userManagement = new UserManagement;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['type'] === 'register') {
        $userManagement->register();
    } else if ($_POST['type'] === 'login') {
        $userManagement->login();
    }
}
