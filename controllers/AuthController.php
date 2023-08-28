<?php 
require './classes/AuthManagement.php';

$authManagement = new AuthManagement;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['type'] === 'register') {
        $authManagement->register();
    } elseif ($_POST['type'] === 'login') {
        $authManagement->login();
    }
} else {
    if($_GET['q'] === 'logout') {
        $authManagement->logout();
    }
}
