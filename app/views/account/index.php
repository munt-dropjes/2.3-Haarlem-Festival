<main>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1>Account</h1>
                <a href="/updateaccount">Update your account</a>
            </div>
            <div class="col-12 mt-3">
                <h2>Tickets</h2>
                <?php if (empty($tickets)): ?>
                    <p>You have no tickets.</p>
                <?php else: ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Event</th>
                                <th scope="col">Date</th>
                                <th scope="col">Time</th>
                                <th scope="col">Total Price</th>
                                <th scope="col">Ticket</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tickets as $ticket):
								/** @var \models\Ticket $ticket */
								?>
                                <tr>
                                    <td><?= $ticket->getEvent()->getName() ?></td>
                                    <td><?= $ticket->getEvent()->getDate() ?></td>
                                    <td><?= date('H:i', strtotime($ticket->getEvent()->getStartTime())) ?></td>
                                    <td>&euro;<?= $ticket->getAmount() ?></td>
                                    <td><?= $ticket->getQuantity() ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>