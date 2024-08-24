<?php
session_start();
include('db.php');

//checks if variable sets or not
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  @$title = trim($_POST['title']);
  @$content = trim($_POST['content']);
  $author_id = $_SESSION['user_id'];

  // Validate the input fields should not empty
  if (empty($title) || empty($content)) {
    echo 'Please fill in all fields.';
  } else {
    $stmt = $pdo->prepare("INSERT INTO blogs (title, content, author_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $author_id]);

    header('Location: index.php');
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Post</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
    }

    form {
      max-width: 600px;
      margin: 40px auto;
      padding: 20px;
      background-color: #fff;
      border: 1px solid #ccc;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    input[type="text"],
    textarea {
      width: 100%;
      height: 40px;
      margin-bottom: 20px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    input[type="text"]:focus,
    textarea:focus {
      border-color: #aaa;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    button[type="submit"] {
      width: 100%;
      height: 40px;
      background-color: #2776ff;
      color: #fff;
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    button[type="submit"]:hover {
      background-color: #2776ff89;
    }

    @media (max-width: 768px) {
      form {
        max-width: 90%;
      }

      input[type="text"],
      textarea {
        font-size: 16px;
      }

      button[type="submit"] {
        font-size: 16px;
      }
    }

    @media (max-width: 480px) {
      form {
        max-width: 100%;
      }

      input[type="text"],
      textarea {
        font-size: 14px;
      }

      button[type="submit"] {
        font-size: 14px;
      }
    }
  </style>
</head>

<body>
  <form method="post" action="create_post.php">
    <input type="text" name="title" placeholder="Title" required>
    <textarea name="content" placeholder="Content" required></textarea>
    <button type="submit">Create Post</button>
  </form>

</body>

</html>