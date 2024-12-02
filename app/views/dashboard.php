<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>
    <h1>Welcome, <?= htmlspecialchars($users['name']) ?></h1>
    <p>Email: <?= htmlspecialchars($users['email']) ?></p>
    <p>Role: <?= htmlspecialchars($users['role']) ?></p>
    <?php if ($users['role'] == 'Admin') : ?>
        <p><a href="/user-list">User List Panel</a></p>
    <?php endif; ?>
    <a href="/logout">Logout</a>
</body>

</html>