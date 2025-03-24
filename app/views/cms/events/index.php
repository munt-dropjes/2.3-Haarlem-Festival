<main>
<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="col-sm-6">
                <h2>Events</h2>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <a href="/cms/events/create" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createNewEvent">Add New Event</a>
                </div>
                <div class="col-sm-6">
                    <form method="get" action="/cms/events">
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
                        <th>Beschrijving</th>
                        <th>Datum</th>
                        <th>Locatie</th>
                        <th>Categorie</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): 
                        ?>
                        <tr>
                            <td><?= $event->getName() ?></td>
                            <td><?= $event->getDescription() ?></td>
                            <td><?= $event->getDate() ?></td>
                            <td><?= $event->getLocation() ?></td>
                            <td><?= $event->getCategory() ?></td>
                            <td>
                                <a href="/cms/events/edit?id=<?= $event->getId() ?>" class="edit" data-bs-toggle="modal" data-bs-target="#updateEvent"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                <button 
                                    type="button" 
                                    class="btn btn-warning btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#updateevent"
                                    data-name="<?= htmlspecialchars($event->getName()); ?>"
                                    data-description="<?= htmlspecialchars($event->getDescription()); ?>"
                                    data-dateTime="<?= htmlspecialchars($event->getDate()); ?>"
                                    data-location="<?= htmlspecialchars($event->getLocation()); ?>"
                                    data-category="<?= htmlspecialchars($event->getCategory()); ?>">
                                    Edit
                                </button>
                                <a href="/cms/events/delete?id=<?= $event->getId() ?>" class="delete" data-bs-toggle="modal" data-bs-target="#deleteEvent"><i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="float-end">
            <div class="hint-text">Showing <b><?= ($offset + count($events)) ?></b> out of
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
<div class="modal fade" id="createNewevent" tabindex="-1" aria-labelledby="createNeweventLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="createNeweventLabel">Create New event</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="/cms/events/create">
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
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-warning">Create new event</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="modal fade" id="updateevent" tabindex="-1" aria-labelledby="updateeventLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="updateeventLabel">Update event</h1>
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
        <button type="button" class="btn btn-warning">Save changes</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteevent" tabindex="-1" aria-labelledby="deleteeventLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteeventLabel">Yeet event</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        U sure?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-warning">Delete event</button>
      </div>
    </div>
  </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadEditModalCMS('updateevent');
    });
</script>
</main>
