<?php
session_start();
include('../db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $blog = $stmt->fetch();
    
    if (!$blog) {
        echo 'Blog not found!';
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $content = $_POST['content'];

        $stmt = $pdo->prepare("UPDATE blogs SET title = ?, content = ? WHERE id = ?");
        $stmt->execute([$title, $content, $_GET['id']]);

        header('Location: dashboard.php');
        exit();
    }
}
?>

<form method="post" action="">
    <input type="text" name="title" value="<?php echo $blog['title']; ?>" required>
    <textarea name="content" required><?php echo $blog['content']; ?></textarea>
    <button type="submit">Update Post</button>
</form>
