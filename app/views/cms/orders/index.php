<main>
    <div class="container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="/cms/users">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/cms/events">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/cms/orders">Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Tickets</a>
            </li>
        </ul>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="col-sm-6">
                    <h2>Orders</h2>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <a href="/cms/orders/export" class="btn btn-success">Export Orders</a>
                    </div>
                    <div class="col-sm-6">
                        <form method="get" action="/cms/orders">
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
                            <th>OrderID</th>
                            <th>UserID</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>PaymentMethod</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order):
                        ?>
                            <tr>
                                <td><?= $order->getOrderID() ?></td>
                                <td><?= $order->getUserID() ?></td>
                                <td><?= $order->getStatus() ?></td>
                                <td><?= $order->getCreatedAt() ?></td>
                                <td><?= $order->getPaymentMethod() ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="float-end">
                <div class="hint-text">Showing <b><?= ($offset + count($orders)) ?></b> out of
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
</main>