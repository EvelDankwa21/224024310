<?php
session_start();
require 'db.php';

// Only allow logged-in admins
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Mark message as read
if (isset($_GET['mark_read'])) {
    $id = $_GET['mark_read'];
    $stmt = $pdo->prepare("UPDATE messages SET is_read = 1 WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_messages.php');
    exit();
}

// Delete message
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_messages.php');
    exit();
}

// Fetch all messages
$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Contact Messages</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Manage Contact Messages</h2>
<a href="admin_dashboard.php">Back to Dashboard</a><br><br>

<table>
    <tr>
        <th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Status</th><th>Actions</th>
    </tr>
    <?php foreach ($messages as $msg): ?>
    <tr>
        <td><?= htmlspecialchars($msg['name']) ?></td>
        <td><?= htmlspecialchars($msg['email']) ?></td>
        <td><?= htmlspecialchars($msg['subject']) ?></td>
        <td><?= htmlspecialchars($msg['message']) ?></td>
        <td><?= $msg['is_read'] ? 'Read' : 'Unread' ?></td>
        <td>
            <?php if (!$msg['is_read']): ?>
                <a href="?mark_read=<?= $msg['id'] ?>">Mark as Read</a> |
            <?php endif; ?>
            <a href="?delete=<?= $msg['id'] ?>" onclick="return confirm('Delete this message?');">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
