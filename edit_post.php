<?php
session_start();
include('db.php');

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

    //check if form submitted
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
<div class="edit-post-container">
    <h1>Edit Post</h1>
    <form method="post" action="">
        <input type="text" name="title" value="<?php echo $blog['title']; ?>" required>
        <textarea name="content" required><?php echo $blog['content']; ?></textarea>
        <button type="submit">Update Post</button>
    </form>
</div>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f0f0;
    }

    .edit-post-container {
        max-width: 700px;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    form {
        margin-top: 20px;
    }

    input[type="text"] {
        width: 100%;
        height: 40px;
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ccc;
    }

    textarea {
        width: 100%;
        height: 200px;
        margin-bottom: 20px;
        padding: 10px;
        border: 1px solid #ccc;
        resize: vertical;
    }

    button[type="submit"] {
        width: 100%;
        height: 40px;
        background-color: #4CAF50;
        color: #fff;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    button[type="submit"]:hover {
        background-color: #3e8e41;
    }
</style>