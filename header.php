<?php include './helpers/session_helper.php' ?>
<!DOCTYPE html>
<html>

<head>
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <link rel="stylesheet" href="style.css">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <h1 class="navbar-brand p-3" href="#">User Management System</h1>
    <div class="navbar-collapse p-2" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>
        <?php if (!isAuth()) {
          echo '<li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Register</a>
        </li>';
        } else {
          echo '
          <li class="nav-item">
          <a class="nav-link" href="./controllers/AuthController.php?q=logout">Logout</a>
        </li>';
        } ?>
        <?php if(isAdmin()) {
          echo '
          <li class="nav-item">
          <a class="nav-link" href="admin.php">Admin Panel</a>
        </li>';
        } 
        ?>
      </ul>
    </div>
  </nav>