<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit();
}

$stmt = $pdo->query("SELECT blogs.*, users.username FROM blogs JOIN users ON blogs.author_id = users.id ORDER BY created_at DESC");
$blogs = $stmt->fetchAll();
?>
<div class="dashboard-container">
    <h1>Admin Dashboard</h1>
    <a href="create_post.php">Create New Post</a>

    <?php foreach ($blogs as $blog): ?>
        <div class="blog-post">
            <h2><?php echo $blog['title']; ?></h2>
            <p>By <?php echo $blog['username']; ?> on <?php echo $blog['created_at']; ?></p>
            <a href="edit_post.php?id=<?php echo $blog['id']; ?>">Edit</a> |
            <a href="delete_post.php?id=<?php echo $blog['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
        </div>
    <?php endforeach; ?>
</div>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    a {
        text-decoration: none;
        color: #337ab7;
    }

    a:hover {
        color: #23527c;
    }

    .dashboard-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .blog-post {
        margin-bottom: 20px;
        padding: 20px;
        border-bottom: 1px solid #ccc;
    }

    .blog-post h2 {
        font-size: 24px;
        margin-bottom: 10px;
    }

    .blog-post p {
        font-size: 16px;
        color: #666;
    }
</style>