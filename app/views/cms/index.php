<h1>Content Management System</h1>

<?php echo $this->content; ?>

    <h2>Users</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
        </tr>
        <?php foreach ($this->users as $user): ?>
            <tr>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['email']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

