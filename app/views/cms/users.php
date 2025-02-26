<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Users</h2>
                </div>
                <div class="col-sm-6">
                    <form method="get" action="/cms/users">
                        <input type="submit" class="btn btn-success" value="Refresh">
                        <input type="hidden" name="limit" value="<?= $limit ?>">
                        <input type="hidden" name="offset" value="<?= $offset ?>">
                        <input type="search" name="search" class="form-control" value="<?= $search ?>">
                    </form>
                </div>
                <div class="col-sm-6">
                    <a href="/cms/users/create" class="btn btn-success"><i class="material-icons">&#xE147;</i> <span>Add New User</span></a>
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
                            <td>
                                <a href="/cms/users/edit?id=<?= $user->getId() ?>" class="edit"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <a href="/cms/users/delete?id=<?= $user->getId() ?>" class="delete"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="clearfix">
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