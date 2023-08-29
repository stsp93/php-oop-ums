<?php 

require __DIR__.'/classes/UserManagement.php';

$userManagement = new UserManagement;

$users = $userManagement->getAllUsers();


if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['type'] === 'createUser') {
        $userManagement->createUser();
    }

    if($_POST['type'] === 'editUser') {
        $userManagement->editUser();
    }
}

?>