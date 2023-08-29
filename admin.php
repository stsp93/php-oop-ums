<?php include 'header.php' ?>
<?php if (!isAdmin()) {
    header('Location: index.php');
    exit();
} ?>
<?php include './controllers/AdminController.php' ?>


<div class="container mt-5">
    <h2>User Management</h2>
    <?php showWarnings() ?>
    <button class="createBtn btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Create User</button>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($users as $user){ ?>
            <tr>
                <td id="curId"><?= $user['user_id'] ?></td>
                <td id="curUsername"><?= $user['username'] ?></td>
                <td id="curEmail"><?= $user['email'] ?></td>
                <td id="curRole"><?= $user['user_role'] ?></td>
                <td>
                    <button class="editBtn btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" data-userId="<?= $user['user_id'] ?>">Edit</button>
                    <button class="deleteBtn btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-userId="<?= $user['user_id'] ?>">Delete</button>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div class="modal" id="createModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="./controllers/AdminController.php" method="post">
                    <input type="hidden" name="type" value="createUser">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="rePassword" class="form-label">Repeat Password</label>
                        <input type="password" class="form-control" id="rePassword" name="rePassword">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="user">User</option>
                            <option value="admin" selected>Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="./controllers/AdminController.php" method="post">
                    <input id="editId" type="hidden" name="user_id" >
                    <input type="hidden" name="type" value="editUser">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="editUsername" name="username" >
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" >
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="editRole" name="role">
                            <option value="user">User</option>
                            <option value="admin" selected>Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="post">
                    <input id="deleteInfo" type="hidden" name="user_id" value="1">
                    <input type="hidden" name="type" value="deleteUser">
                    <div class="mb-3">
                        <label for="username" class="form-label">Are you sure?</label>
                    </div>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(`.editBtn`).on('click', function() {
        console.log($(`#username`));
        $(`#editId`).val($(this).parent().parent().find('#curId').text());
        $(`#editUsername`).val($(this).parent().parent().find('#curUsername').text());
        $(`#editEmail`).val($(this).parent().parent().find('#curEmail').text());
        $(`#editRole`).val($(this).parent().parent().find('#curRole').text());
    });
    $(`.deleteBtn`).on('click', function() {
        $(`#deleteInfo`).val($(this).data('userid'));
    });



</script>

<?php include 'footer.php' ?>