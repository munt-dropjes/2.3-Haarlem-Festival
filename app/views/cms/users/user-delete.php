<main>

<div class="modal fade" id="deleteUser" tabindex="-1" aria-labelledby="deleteUserLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="/cms/users/delete">
                <input type="hidden" name="id" id="id" value="<?= $selectedUser->getId() ?>">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteUserLabel">Delete user</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete: <?= $user->email ?> ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-warning">Delete user</button>
                </div>
            </form>
        </div>
    </div>
</div>

</main>