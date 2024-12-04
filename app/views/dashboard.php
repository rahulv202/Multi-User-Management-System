<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Welcome, <?= htmlspecialchars($users['name']) ?></h1>
        <p><strong>Email:</strong> <?= htmlspecialchars($users['email']) ?></p>
        <p><strong>Role:</strong> <?= htmlspecialchars($users['role']) ?></p>

        <?php if ($users['role'] == 'Admin') : ?>
            <p><a href="/user-list" class="btn btn-info">User List Panel</a></p>
        <?php endif; ?>

        <a href="/logout" class="btn btn-danger">Logout</a>
    </div>

    <!-- Bootstrap JS and dependencies (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>