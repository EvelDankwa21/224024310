<?php
session_start();
require 'db.php';

if (!isset($_GET['id'])) {
    header('Location: manage_projects.php');
    exit();
}

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
$stmt->execute([$id]);

header('Location: manage_projects.php');
exit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Deleting Project...</h2>
<p>If you are not redirected automatically, <a href="manage_projects.php">click here</a>.</p>
</body>
</html>
