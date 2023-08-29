<?php
include_once dirname(dirname(__DIR__)) . '/models/User.php';
include_once dirname(dirname(__DIR__)) . '/helpers/session_helper.php';

class UserManagement
{

    public function getAllUsers()
    {
        $userModel = new User();
        return $userModel->getAll();
    }

    public function createUser()
    {
        $payload = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

        $newUser = new User($payload['username'],  $payload['password'], $payload['email'], $payload['role']);

        // Validations
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

        if (!empty($newUser->findUser('username'))) {
            setWarning('Username is taken');
        }
        if (!empty($newUser->findUser('email'))) {
            setWarning('Email is taken');
        }

        // Check for warnings guard clause
        if (!empty($_SESSION['warnings'])) {
            header('Location: ../admin.php');
            exit();
        }

        try {
            $newUser->create();
            redirect('../admin.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function editUser()
    {
        $payload = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $newUser = new User($payload['username'],  $payload['password'], $payload['email'], $payload['role']);

        if (!empty($newUser->findUser('username'))) {
            setWarning('Username is taken');
        }
        if (!empty($newUser->findUser('email'))) {
            setWarning('Email is taken');
        }

        // Check for warnings guard clause
        if (!empty($_SESSION['warnings'])) {
            header('Location: ../admin.php');
            exit();
        }

        try {
            $newUser->edit($payload['user_id']);
            redirect('../admin.php');
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }
}
