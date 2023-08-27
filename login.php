<?php include 'header.php' ?>
<?php include './helpers/session_helper.php' ?>
<div class="container mt-5">
    <h2>Login</h2>
    <?php showWarnings(); ?>
    <form action="./controllers/UserManagement.php" method="post">
        <input type="hidden" name="type" value="login">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <p class="mt-3">Don't have an account? <a href="register.php">Register here</a></p>
</div>
<?php include 'footer.php' ?>