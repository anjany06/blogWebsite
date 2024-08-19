<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_SESSION['user_id'])) {
        $blog_id = $_POST['blog_id'];
        $vote_type = $_POST['vote_type'];
        $user_id = $_SESSION['user_id'];

        $stmt = $pdo->prepare("SELECT * FROM votes WHERE blog_id = ? AND user_id = ?");
        $stmt->execute([$blog_id, $user_id]);
        $vote = $stmt->fetch();

        if ($vote) {
            $stmt = $pdo->prepare("UPDATE votes SET vote_type = ? WHERE id = ?");
            $stmt->execute([$vote_type, $vote['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO votes (blog_id, user_id, vote_type) VALUES (?, ?, ?)");
            $stmt->execute([$blog_id, $user_id, $vote_type]);
        }

        header('Location: blog_details.php?id=' . $blog_id);
        exit();
    } else {
        header('Location: login.php');
        exit();
    }
}
?>
