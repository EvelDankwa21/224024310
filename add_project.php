<?php
session_start();
require 'db.php'; // Ensure this connects to your database

// Show errors for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $technologies = $_POST['technologies'] ?? '';

    // Handle image upload
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $image = basename($_FILES['image']['name']);
        $target_file = $target_dir . $image;

        // Move uploaded file
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Success
        } else {
            echo "Error uploading image.";
            exit();
        }
    }

    // Insert project into DB
    $stmt = $pdo->prepare("INSERT INTO projects (title, description, technologies, image) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$title, $description, $technologies, $image])) {
        header('Location: manage_projects.php');
        exit();
    } else {
        echo "Error adding project.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Add Project</h2>
<a href="manage_projects.php">Back to Projects</a><br><br>

<form method="POST" enctype="multipart/form-data">
    <label>Title:</label>
    <input type="text" name="title" required><br>
    <label>Description:</label>
    <textarea name="description" required></textarea><br>
    <label>Technologies:</label>
    <input type="text" name="technologies" required><br>
    <label>Image:</label>
    <input type="file" name="image" required><br><br>
    <button type="submit">Add Project</button>
</form>
</body>
</html>
