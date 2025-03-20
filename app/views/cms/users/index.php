<main>
    <div class="container">
        <div class="table-wrapper">
            <div class="table-title">
                <div class="col-sm-6">
                    <h2>Users</h2>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <a href="/cms/users/create" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createNewUser">Add New User</a>
                    </div>
                    <div class="col-sm-6">
                        <form method="get" action="/cms/users">
                            <input type="submit" class="btn btn-success" value="Refresh">
                            <input type="hidden" name="limit" value="<?= $limit ?>">
                            <input type="hidden" name="offset" value="<?= $offset ?>">
                            <input type="search" name="search" class="form-control" value="<?= $search ?>">
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Naam</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Registered At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user):
                        ?>
                            <tr>
                                <td><?= $user->getName() ?></td>
                                <td><?= $user->getEmail() ?></td>
                                <td><?= $user->getRole() ?></td>
                                <td><?= $user->getRegisteredAt() ?></td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateUser"
                                        data-name="<?= htmlspecialchars($user->getName()); ?>"
                                        data-email="<?= htmlspecialchars($user->getEmail()); ?>"
                                        data-phone="<?= htmlspecialchars($user->getPhone()); ?>"
                                        data-country="<?= htmlspecialchars($user->getCountry()); ?>"
                                        data-role="<?= htmlspecialchars($user->getRole()); ?>">
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteUser"
                                        data-id="<?= $user->getId(); ?>"
                                        data-email="<?= htmlspecialchars($user->getEmail()); ?>">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="float-end">
                <div class="hint-text">Showing <b><?= ($offset + count($users)) ?></b> out of
                    <b><?= $totalEntries ?></b> entries
                </div>
                <ul class="pagination">
                    <?php if ($offset + $limit < $totalEntries): ?>
                        <li class="page-item">
                            <a href="?limit=<?= $limit ?>&offset=<?= $offset - $limit ?>&search<?= $search ?>">Previous</a>
                        </li>
                    <?php endif; ?>
                    <li class="page-item active">
                        <a href="?limit=<?= $limit ?>&offset=0" class="page-link"><?= ceil($offset / $limit) + 1 ?></a>
                    </li>
                    <?php if ($offset + $limit < $totalEntries): ?>
                        <li class="page-item">
                            <a href="?limit=<?= $limit ?>&offset=<?= $limit + $offset ?>&search<?= $search ?>"
                                class="page-link">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- Modals, "geleend" van de bootstrap documentatie -->
    <div class="modal fade" id="createNewUser" tabindex="-1" aria-labelledby="createNewUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createNewUserLabel">Create New User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/cms/users/create">
                    <div class="modal-body">
                        <div class="form-content">
                            <div class="modal-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="modal-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="modal-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="modal-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="modal-group">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country" required>
                            </div>
                            <div class="modal-group">
                                <label for="role">Role</label>
                                <select class="form-select" id="role" name="role">
                                    <option value="Administrator">Admin</option>
                                    <option value="Employee">Employee</option>
                                    <option value="Customer">Customer</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Create new user</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="updateUser" tabindex="-1" aria-labelledby="updateUserLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="updateUserLabel">Update User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-content">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
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
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-select" id="role" name="role">
                                <option value="Administrator">Admin</option>
                                <option value="Employee">Employee</option>
                                <option value="Customer">Customer</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-warning">Save changes</button>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="deleteUserLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteUserLabel">Delete user</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/cms/users/delete">
                    <input type="hidden" name="id" id="id" value="9">
                    <div class="modal-body">
                        Are you sure you want to delete: 
                        <div class="form-group">
                            <input type="text" class="form-control" id="email" name="email" disabled required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Delete user</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadEditModalCMS('updateUser');
        });
        document.addEventListener('DOMContentLoaded', function() {
            loadDeleteModalCMS('deleteUser');
        });
    </script>
</main>