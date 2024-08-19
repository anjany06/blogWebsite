<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id'])) {
        $blog_id = $_POST['blog_id'];
        $content = $_POST['content'];
        $author_id = $_SESSION['user_id'];

        $stmt = $pdo->prepare("INSERT INTO comments (blog_id, author_id, content) VALUES (?, ?, ?)");
        $stmt->execute([$blog_id, $author_id, $content]);

        header('Location: blog_details.php?id=' . $blog_id);
        exit();
    } else {
        header('Location: login.php');
        exit();
    }
}
?>
