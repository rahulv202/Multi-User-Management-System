<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Details</title>
</head>

<body>
    <h1>Edit User Details</h1>
    <form method="post" action="/submit-edit_user">
        <input type="hidden" name="id" value="<?php echo $users['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $users['name']; ?>" placeholder="Name" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $users['email']; ?>" placeholder="Email" required>
        <label for="user_role">Role:</label>
        <input type="text" id="role" name="role" value="<?php echo $users['role']; ?>" placeholder="Role" required>
        <button type="submit">Submit User Data</button>
    </form>
</body>

</html>