<?php
include '../models/User.php';
include '../helpers/session_helper.php';

class UserManagement
{

    public function register()
    {
        $payload = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $payload['password_hash'] = password_hash($payload['password'], PASSWORD_BCRYPT);

        $newUser = new User($payload['username'],  $payload['password_hash'],$payload['email']);

        // Validations

        // if empty field
        array_walk($payload, function (string $value) {
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
        if (!empty($newUser->findUser())) {
            setWarning('Username is taken');
        }
        // email taken
        if (!empty($newUser->findEmail($payload['email']))) {
            setWarning('Email is taken');
        }

        // Check for warnings guard clause
        if (!noWarnings()) {
            redirect('../register.php');
        }

        try {
            $newUser->save($payload);
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

        $exsistingUser = new User($payload['username']);

        try {
            // validate login
            $user = $exsistingUser->findUser();

            if (password_verify($payload['password'], $user->getPasswordHash())) {
                // save session
                setSession($user->getId(), $user->getRole());
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

    public function logout() {
        unset($_SESSION['user_id']);
        session_destroy();

        $session = $_SESSION;
        redirect('../index.php');
    }
}

$userManagement = new UserManagement;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['type'] === 'register') {
        $userManagement->register();
    } else if ($_POST['type'] === 'login') {
        $userManagement->login();
    }
} else {
    if($_GET['q'] === 'logout') {
        $userManagement->logout();
    }
}
