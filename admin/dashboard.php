<?php
session_start();
include('../db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit();
}

$stmt = $pdo->query("SELECT blogs.*, users.username FROM blogs JOIN users ON blogs.author_id = users.id ORDER BY created_at DESC");
$blogs = $stmt->fetchAll();
?>

<h1>Admin Dashboard</h1>
<a href="create_post.php">Create New Post</a>

<?php foreach ($blogs as $blog): ?>
    <div>
        <h2><?php echo $blog['title']; ?></h2>
        <p>By <?php echo $blog['username']; ?> on <?php echo $blog['created_at']; ?></p>
        <a href="edit_post.php?id=<?php echo $blog['id']; ?>">Edit</a> | 
        <a href="delete_post.php?id=<?php echo $blog['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
    </div>
<?php endforeach; ?>
