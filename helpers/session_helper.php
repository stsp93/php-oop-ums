<?php
session_start();

function setWarning($message)
{
    if(!isset($_SESSION['warnings'])) {
        $_SESSION['warnings'] = [];
    }
    array_push($_SESSION['warnings'],$message);
}

function noWarnings() {
    return empty($_SESSION['warnings']);
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

function setSession($userId) {
    $_SESSION['userId'] = $userId;
}


function redirect($location) {
    header('Location: ' . $location);
    exit();
}
