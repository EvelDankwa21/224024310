<?php
session_start();
require 'db.php';

if (!isset($_GET['id'])) {
    header('Location: manage_projects.php');
    exit();
}

$id = $_GET['id'];

// Fetch existing project data
$stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if (!$project) {
    echo "Project not found.";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $technologies = $_POST['technologies'] ?? '';
    $image = $project['image']; // Keep existing image

    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $new_image = basename($_FILES['image']['name']);
        $target_file = $target_dir . $new_image;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $new_image;
        } else {
            echo "Error uploading new image.";
            exit();
        }
    }

    $stmt = $pdo->prepare("UPDATE projects SET title = ?, description = ?, technologies = ?, image = ? WHERE id = ?");
    $stmt->execute([$title, $description, $technologies, $image, $id]);
    header('Location: manage_projects.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Project</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Edit Project</h2>
<a href="manage_projects.php">Back to Projects</a><br><br>

<form method="POST" enctype="multipart/form-data">
    <label>Title:</label>
    <input type="text" name="title" value="<?= htmlspecialchars($project['title']) ?>" required><br>
    <label>Description:</label>
    <textarea name="description" required><?= htmlspecialchars($project['description']) ?></textarea><br>
    <label>Technologies:</label>
    <input type="text" name="technologies" value="<?= htmlspecialchars($project['technologies']) ?>" required><br>
    <label>Current Image:</label><br>
    <?php if ($project['image']): ?>
        <img src="uploads/<?= htmlspecialchars($project['image']) ?>" width="100"><br>
    <?php else: ?>
        No image<br>
    <?php endif; ?>
    <label>Upload New Image:</label>
    <input type="file" name="image"><br><br>
    <button type="submit">Update Project</button>
</form>
</body>
</html>
