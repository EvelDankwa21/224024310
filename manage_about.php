<?php
session_start();
require 'db.php';

// Only allow logged-in admins
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}

// Fetch current about info
$stmt = $pdo->query("SELECT * FROM about LIMIT 1");
$about = $stmt->fetch();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = $_POST['bio'];
    $skills = $_POST['skills'];
    $experience = $_POST['experience'];
    $education = $_POST['education'];

    $stmt = $pdo->prepare("UPDATE about SET bio = ?, skills = ?, experience = ?, education = ? WHERE id = 1");
    $stmt->execute([$bio, $skills, $experience, $education]);

    header('Location: manage_about.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage About Section</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Manage About Section</h2>
<a href="admin_dashboard.php">Back to Dashboard</a><br><br>

<form method="POST">
    <label>Bio:</label>
    <textarea name="bio" rows="5"><?= htmlspecialchars($about['bio']) ?></textarea><br>
    <label>Skills (comma-separated):</label>
    <textarea name="skills" rows="3"><?= htmlspecialchars($about['skills']) ?></textarea><br>
    <label>Experience:</label>
    <textarea name="experience" rows="3"><?= htmlspecialchars($about['experience']) ?></textarea><br>
    <label>Education:</label>
    <textarea name="education" rows="3"><?= htmlspecialchars($about['education']) ?></textarea><br><br>
    <button type="submit">Update About</button>
</form>
</body>
</html>
