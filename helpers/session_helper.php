<?php
session_start();

function setWarning($message)
{
    if(!isset($_SESSION['warnings'])) {
        $_SESSION['warnings'] = [];
    }
    array_push($_SESSION['warnings'],$message);
}

function showWarnings()
{
    // Show warnings
    if (!empty($_SESSION['warnings'])) {
        echo '<div class="alert alert-danger" role="alert">';
        array_walk($_SESSION['warnings'], function ($message) {
            echo $message . '</br>';
        });
        echo '</div>';

        // empty warnings array
        $_SESSION['warnings'] = [];
    }
}

function setSession($userId, $userRole) {
    $_SESSION['userId'] = $userId;
    $_SESSION['userRole'] = $userRole;
}

function isAdmin() {
    return isset($_SESSION['userRole']) && $_SESSION['userRole'] === 'admin';
}

function isAuth() {
    return isset($_SESSION['userId']);
}

function redirect($location) {
    header('Location: ' . $location);
    exit();
}
