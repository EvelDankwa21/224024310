<?php
session_start();
require 'db.php';

// Only allow logged-in admins
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Add new skill
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_skill'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $stmt = $pdo->prepare("INSERT INTO skills (name, description) VALUES (?, ?)");
    $stmt->execute([$name, $description]);
}

// Delete skill
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM skills WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_skills.php');
    exit();
}

// Fetch all skills
$skills = $pdo->query("SELECT * FROM skills ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Skills/Services</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Manage Skills / Services</h2>
<a href="admin_dashboard.php">Back to Dashboard</a><br><br>

<h3>Add New Skill / Service</h3>
<form method="POST">
    <label>Name:</label>
    <input type="text" name="name" required><br>
    <label>Description:</label>
    <textarea name="description" required></textarea><br><br>
    <button type="submit" name="add_skill">Add Skill</button>
</form>

<h3>Existing Skills / Services</h3>
<table>
    <tr><th>Name</th><th>Description</th><th>Actions</th></tr>
    <?php foreach ($skills as $skill): ?>
    <tr>
        <td><?= htmlspecialchars($skill['name']) ?></td>
        <td><?= htmlspecialchars($skill['description']) ?></td>
        <td><a href="?delete=<?= $skill['id'] ?>" onclick="return confirm('Delete this skill?');">Delete</a></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
