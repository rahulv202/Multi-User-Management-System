<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>
    <h1>Welcome, <?= htmlspecialchars($user['name']) ?></h1>
    <p>Email: <?= htmlspecialchars($user['email']) ?></p>
    <p>Role: <?= htmlspecialchars($user['role']) ?></p>
    <a href="/logout">Logout</a>
</body>

</html>