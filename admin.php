<?php include 'header.php' ?>
<?php if (!isAdmin()) {
    redirect('index.php');
} ?>
<?php include './controllers/AdminController.php' ?>


<div class="container mt-5">
    <h2>User Management</h2>
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
            <tr>
                <td>1</td>
                <td>john_doe</td>
                <td>john@example.com</td>
                <td>User</td>
                <td>
                    <button class="editBtn btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" data-userId="5">Edit</button>
                    <button class="deleteBtn btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-userId="5">Delete</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<div class="modal" id="editModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="post">
                    <input id="editInfo" type="hidden" name="user_id" value="1">
                    <input type="hidden" name="type" value="editUser">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="john_doe">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="john@doe.com">
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
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
    ['delete', 'edit'].forEach((str) => {
        $(`.${str}Btn`).on('click', function() {
            $(`#${str}Info`).val($(this).data('userid'));
        });

    })

</script>

<?php include 'footer.php' ?>