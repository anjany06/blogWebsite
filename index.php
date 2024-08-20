<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Blog Website</title>
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <header>
    <h1>Blogworld.com</h1>
    <nav>
      <form action="admin_login.php" method="post">
        <button type="submit" id="adminLoginBtn">Admin Login</button>
      </form>
      <form action="login.php" method="post">
        <button type="submit" id="loginBtn">Login</button>
      </form>
      <form action="register.php" method="post">
        <button type="submit" id="registerBtn">Register</button>
      </form>
      <form action="create_post.php" method="post">
        <button type="submit" id="createPostBtn">Create Blog</button>
      </form>
    </nav>
  </header>


  <main id="blogContainer" class="grid-container">
    <?php
    include('db.php');

    $stmt = $pdo->query("SELECT blogs.*, users.username FROM blogs JOIN users ON blogs.author_id = users.id ORDER BY created_at DESC");
    $blogs = $stmt->fetchAll();
    ?>

    <?php foreach ($blogs as $blog): ?>
      <div>
        <h2><?php echo $blog['title']; ?></h2>
        <p>By <?php echo $blog['username']; ?> on <?php echo $blog['created_at']; ?></p>
        <p><?php echo substr($blog['content'], 0, 150); ?>...</p>
        <a href="blog_details.php?id=<?php echo $blog['id']; ?>">Read More</a>
      </div>
    <?php endforeach; ?>

  </main>

  <footer>
    <p>© 2024 Blogworld.com</p>
  </footer>

</body>

</html>