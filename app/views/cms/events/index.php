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
                            <th>Name</th>
                            <th>Description</th>
                            <th>Date - Time</th>
                            <th>Location</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event):
                        ?>
                            <tr>
                                <td><?= $event->getName() ?></td>
                                <td><?= $event->getDescription() ?></td>
                                <td><?= $event->getDate() ?> - <?= $event->getTime() ?></td>
                                <td><?= $event->getLocation() ?></td>
                                <td><?= $event->getPrice() ?></td>
                                <td><?= $event->getCategory() ?></td>
                                <td><?= $event->getPrice() > 0 ? 'Available' : 'Sold out' ?></td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#updateEvent"
                                        data-id="<?= $event->getEventID(); ?>"
                                        data-name="<?= htmlspecialchars($event->getName()); ?>"
                                        data-description="<?= htmlspecialchars($event->getDescription()); ?>"
                                        data-date="<?= htmlspecialchars($event->getDate()); ?>"
                                        data-time="<?= htmlspecialchars($event->getTime()); ?>"
                                        data-duration="<?= htmlspecialchars($event->getDuration()); ?>"
                                        data-location="<?= htmlspecialchars($event->getLocation()); ?>"
                                        data-price="<?= htmlspecialchars($event->getPrice()); ?>"
                                        data-category="<?= htmlspecialchars($event->getCategory()); ?>">                                       
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteEvent"
                                        data-id="<?= $event->getEventID(); ?>"
                                        data-name="<?= htmlspecialchars($event->getName()); ?>">
                                        Delete
                                    </button>
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
    <div class="modal fade" id="createNewEvent" tabindex="-1" aria-labelledby="createNewEventLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="createNewEventLabel">Create New Event</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/cms/events/create">
                    <div class="modal-body">
                        <div class="form-content">
                            <div class="modal-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="modal-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" id="description" name="description" required>
                            </div>
                            <div class="modal-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="modal-group">
                                <label for="time">Time</label>
                                <input type="time" class="form-control" id="time" name="time" required>
                            </div>
                            <div class="modal-group">
                                <label for="duration">Duration</label>
                                <input type="text" class="form-control" id="duration" name="duration" required>
                            </div>
                            <div class="modal-group">
                                <label for="duration">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                            <div class="modal-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="modal-group">
                                <label for="category">Category</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="Jazz">Jazz</option>
                                    <option value="Yummy">Yummy</option>
                                    <option value="Dance">Dance</option>
                                    <option value="A Stroll through History">Stroll</option>
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
    <div class="modal fade" id="updateEvent" tabindex="-1" aria-labelledby="updateEventLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="/cms/events/edit">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="updateEventLabel">Update Event</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-content">
                            <input type="hidden" class="form-control" name="id" id="id" required>
                            <div class="modal-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="modal-group">
                                <label for="description">Description</label>
                                <input type="text" class="form-control" id="description" name="description" required>
                            </div>
                            <div class="modal-group">
                                <label for="date">Date</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="modal-group">
                                <label for="time">Time</label>
                                <input type="time" class="form-control" id="time" name="time" required>
                            </div>
                            <div class="modal-group">
                                <label for="duration">Duration</label>
                                <input type="text" class="form-control" id="duration" name="duration" required>
                            </div>
                            <div class="modal-group">
                                <label for="duration">Location</label>
                                <input type="text" class="form-control" id="location" name="location" required>
                            </div>
                            <div class="modal-group">
                                <label for="price">Price</label>
                                <input type="text" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="modal-group">
                                <label for="category">Category</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="Jazz">Jazz</option>
                                    <option value="Yummy">Yummy</option>
                                    <option value="Dance">Dance</option>
                                    <option value="A Stroll through History">Stroll</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteEvent" tabindex="-1" aria-labelledby="deleteEventLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="deleteEventLabel">Delete event</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="post" action="/cms/events/delete">
                    <input type="hidden" class="form-control" name="id" id="id" required>
                    <div class="modal-body">
                        Are you sure you want to delete: 
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Delete event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadEditEventModalCMS('updateEvent');
        });
        document.addEventListener('DOMContentLoaded', function() {
            loadDeleteEventModalCMS('deleteEvent');
        });
    </script>
</main>