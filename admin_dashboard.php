<?php
session_start();
require 'db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch site stats
$projectCount = $pdo->query("SELECT COUNT(*) FROM projects")->fetchColumn();
$messageCount = $pdo->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Welcome, <?= htmlspecialchars($_SESSION['role']) ?>!</h2>

<h3>Site Statistics</h3>
<ul>
    <li>Total Projects: <?= $projectCount ?></li>
    <li>Total Messages: <?= $messageCount ?></li>
</ul>

<h3>Manage Sections</h3>
<ul>
    <li><a href="manage_projects.php">Manage Projects</a></li>
    <li><a href="manage_admins.php">Manage Admins</a></li>
    <li><a href="manage_about.php">Manage About Section</a></li>
    <li><a href="manage_messages.php">Manage Contact Messages</a></li>
    <li><a href="manage_skills.php">Manage Skills/Services</a></li>
    <li><a href="manage_blog.php">Manage Blog Posts</a></li>
</ul>

<a href="logout.php">Logout</a>
</body>
</html>
