<?php
session_start();
require 'db.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Add post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_post'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $stmt = $pdo->prepare("INSERT INTO blog_posts (title, content) VALUES (?, ?)");
    $stmt->execute([$title, $content]);
}

// Delete post
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM blog_posts WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: manage_blog.php');
    exit();
}

$posts = $pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Blog Posts</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Manage Blog Posts</h2>
<a href="admin_dashboard.php">Back to Dashboard</a><br><br>

<h3>Add New Post</h3>
<form method="POST">
    <label>Title:</label>
    <input type="text" name="title" required><br>
    <label>Content:</label>
    <textarea name="content" required></textarea><br><br>
    <button type="submit" name="add_post">Add Post</button>
</form>

<h3>Existing Posts</h3>
<table>
    <tr><th>Title</th><th>Actions</th></tr>
    <?php foreach ($posts as $post): ?>
    <tr>
        <td><?= htmlspecialchars($post['title']) ?></td>
        <td><a href="?delete=<?= $post['id'] ?>" onclick="return confirm('Delete this post?');">Delete</a></td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
