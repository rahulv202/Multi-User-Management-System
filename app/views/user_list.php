<!DOCTYPE html>
<html>

<head>
    <title>User List</title>
</head>

<body>
    <h1>All Users</h1>
    <table border="1">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['name']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['role']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="/dashboard">Back to Dashboard</a>
</body>

</html>