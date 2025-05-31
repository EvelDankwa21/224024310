<?php
require 'db.php';
$stmt = $pdo->query("SELECT * FROM projects");
$projects = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Projects</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Manage Projects</h2>
<a href="add_project.php">Add New Project</a> | <a href="admin_dashboard.php">Back to Dashboard</a><br><br>

<table>
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Technologies</th>
        <th>Image</th>
        <th>Actions</th>
    </tr>
    <?php foreach ($projects as $project): ?>
    <tr>
        <td><?= htmlspecialchars($project['title']) ?></td>
        <td><?= htmlspecialchars($project['description']) ?></td>
        <td><?= htmlspecialchars($project['technologies']) ?></td>
        <td>
            <?php if ($project['image']): ?>
                <img src="<?= htmlspecialchars($project['image']) ?>" width="100">
            <?php else: ?>
                No image
            <?php endif; ?>
        </td>
        <td>
            <a href="edit_project.php?id=<?= $project['id'] ?>">Edit</a> |
            <a href="delete_project.php?id=<?= $project['id'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
