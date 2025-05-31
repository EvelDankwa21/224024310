<?php
session_start();
require 'db.php';

// Only super admin can access
if (!isset($_SESSION['admin_id']) || $_SESSION['role'] != 'super_admin') {
    header("Location: admin_login.php");
    exit();
}

// Add admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_admin'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $stmt = $pdo->prepare("INSERT INTO admins (username, password, role) VALUES (?, ?, ?)");
    $stmt->execute([$username, $password, $role]);
}

// Delete admin
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $pdo->prepare("DELETE FROM admins WHERE id = ?")->execute([$id]);
}

// Fetch all admins
$admins = $pdo->query("SELECT * FROM admins")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Admins</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Manage Admins</h2>
<a href="admin_dashboard.php">Back to Dashboard</a><br><br>

<form method="POST">
    <label>Username:</label>
    <input type="text" name="username" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <label>Role:</label>
    <select name="role">
        <option value="admin">Admin</option>
        <option value="super_admin">Super Admin</option>
    </select><br>
    <button type="submit" name="add_admin">Add Admin</button>
</form>

<h3>Existing Admins</h3>
<table>
    <tr><th>ID</th><th>Username</th><th>Role</th><th>Action</th></tr>
    <?php foreach ($admins as $admin): ?>
        <tr>
            <td><?= htmlspecialchars($admin['id']) ?></td>
            <td><?= htmlspecialchars($admin['username']) ?></td>
            <td><?= htmlspecialchars($admin['role']) ?></td>
            <td>
                <?php if ($admin['id'] != $_SESSION['admin_id']) : // prevent deleting self ?>
                    <a href="?delete=<?= $admin['id'] ?>" onclick="return confirm('Delete this admin?');">Delete</a>
                <?php else: ?>
                    (You)
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
