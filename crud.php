<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'crud_app');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];

    if (isset($_POST['id']) && $_POST['id']) { // Update
        $id = $_POST['id'];
        $conn->query("UPDATE users SET name='$name', email='$email' WHERE id=$id");
    } else { // Create
        $conn->query("INSERT INTO users (name, email) VALUES ('$name', '$email')");
    }
    header("Location: crud.php");
    exit;
}

// Handle delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: crud.php");
    exit;
}

// Fetch users
$users = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP CRUD</title>
</head>
<body>
    <h1>PHP CRUD</h1>
    <form method="POST" action="crud.php">
        <input type="hidden" name="id" value="<?= isset($_GET['edit']) ? $_GET['edit'] : '' ?>">
        <input type="text" name="name" placeholder="Name" required value="<?= isset($_GET['edit']) ? $conn->query("SELECT name FROM users WHERE id=" . $_GET['edit'])->fetch_assoc()['name'] : '' ?>">
        <input type="email" name="email" placeholder="Email" required value="<?= isset($_GET['edit']) ? $conn->query("SELECT email FROM users WHERE id=" . $_GET['edit'])->fetch_assoc()['email'] : '' ?>">
        <button type="submit"><?= isset($_GET['edit']) ? 'Update' : 'Add' ?></button>
    </form>
    <table border="1" cellspacing="0" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php while ($user = $users->fetch_assoc()): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['name'] ?></td>
            <td><?= $user['email'] ?></td>
            <td>
                <a href="crud.php?edit=<?= $user['id'] ?>">Edit</a>
                <a href="crud.php?delete=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
