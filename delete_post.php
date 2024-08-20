<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM votes WHERE blog_id = ?");
    $stmt->execute([$_GET['id']]);

    $stmt = $pdo->prepare("DELETE FROM comments WHERE blog_id = ?");
    $stmt->execute([$_GET['id']]);

    $stmt = $pdo->prepare("DELETE FROM blogs WHERE id = ?");
    $stmt->execute([$_GET['id']]);

    if ($stmt->rowCount() > 0) {
        header('Location: dashboard.php');
        exit();
    } else {
        echo 'Error deleting post!';
        exit();
    }
}
?>