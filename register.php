<?php include 'header.php' ?>
<?php include './helpers/session_helper.php' ?>
<div class="container mt-5">
    <h2>Register</h2>
    <?php showWarnings() ?>
    <form action="./controllers/UserManagement.php" method="post">
    <input type="hidden" name="type" value="register">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="rePassword">Repeat Password</label>
            <input type="password" class="form-control" id="rePassword" name="rePassword" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
    <p class="mt-3">Already have an account? <a href="login.php">Login here</a></p>
</div>
<?php include 'footer.php' ?>