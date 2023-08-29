<?php
include '../models/User.php';
include '../helpers/session_helper.php';

// Taking care of login/register and validations logic
class AuthManagement
{

    public function register()
    {
        $payload = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $newUser = new User($payload['username'],  $payload['password'],$payload['email']);

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
        if (!empty($newUser->findUser('username'))) {
            setWarning('Username is taken');
        }
        // email taken
        if (!empty($newUser->findUser('email'))) {
            setWarning('Email is taken');
        }

        // Check for warnings guard clause
        if (!empty($_SESSION['warnings'])) {
            redirect('../register.php');
        }

        try {
            $newUser->create();
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
            $user = $exsistingUser->findUser('username');

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

        redirect('../index.php');
    }
}


