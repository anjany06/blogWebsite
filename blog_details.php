<?php
include('db.php');

session_start();

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare("SELECT blogs.*, users.username FROM blogs JOIN users ON blogs.author_id = users.id WHERE blogs.id = ?");
    $stmt->execute([$_GET['id']]);
    $blog = $stmt->fetch();
    
    if (!$blog) {
        echo 'Blog not found!';
        exit();
    }

    $commentStmt = $pdo->prepare("SELECT comments.*, users.username FROM comments JOIN users ON comments.author_id = users.id WHERE blog_id = ?");
    $commentStmt->execute([$_GET['id']]);
    $comments = $commentStmt->fetchAll();
}
?>

<h2><?= htmlspecialchars ($blog['title']); ?></h2>
<p>By <?= htmlspecialchars ($blog['username']); ?> on <?php echo $blog['created_at']; ?></p>
<p><?= htmlspecialchars ( $blog['content']); ?></p>

<h3>Comments</h3>
<?php foreach ($comments as $comment): ?>
    <div>
        <p><?= htmlspecialchars($comment['username']); ?>: <?php echo $comment['content']; ?></p>
    </div>
<?php endforeach; ?>

<?php if (isset($_SESSION['user_id'])): ?>
    <form method="post" action="add_comment.php">
        <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
        <textarea name="content" placeholder="Write a comment..." required></textarea>
        <button type="submit">Post Comment</button>
    </form>
<?php endif; ?>
<?php if (isset($_SESSION['user_id'])): ?>
    <form method="post" action="vote.php">
        <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
        <button type="submit" name="vote_type" value="upvote">Upvote</button>
        <button type="submit" name="vote_type" value="downvote">Downvote</button>
    </form>
<?php endif; ?>
<?php
$upvotes = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE blog_id = ? AND vote_type = 'upvote'");
$upvotes->execute([$blog['id']]);
$upvoteCount = $upvotes->fetchColumn();

$downvotes = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE blog_id = ? AND vote_type = 'downvote'");
$downvotes->execute([$blog['id']]);
$downvoteCount = $downvotes->fetchColumn();
?>

<p>Upvotes: <?=  $upvoteCount; ?></p>
<p>Downvotes: <?= $downvoteCount; ?></p>

<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f0f0f0;
}

h2 {
  font-size: 24px;
  margin-bottom: 10px;
}

p {
  font-size: 16px;
  color: #666;
  margin-bottom: 20px;
}

p.blog-content {
  font-size: 18px;
  line-height: 1.5;
  margin-bottom: 30px;
}

h3 {
  font-size: 18px;
  margin-bottom: 10px;
}

.comments {
  margin-bottom: 30px;
}

.comments div {
  margin-bottom: 20px;
  padding: 10px;
  border-bottom: 1px solid #ccc;
}

.comments p {
  font-size: 16px;
  margin-bottom: 10px;
}

form {
  margin-bottom: 30px;
}

form textarea {
  width: 100%;
  height: 100px;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

form button[type="submit"] {
  background-color: #2776ff;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

form button[type="submit"]:hover {
  background-color: #2776ff89;
}

form.vote-buttons {
  margin-bottom: 30px;
}

form.vote-buttons button[type="submit"] {
  background-color: #2776ff;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin-right: 10px;
}

form.vote-buttons button[type="submit"]:hover {
  background-color: #2776ff89;
}

p.vote-counts {
  font-size: 16px;
  margin-bottom: 10px;
}

@media (max-width: 768px) {
  .comments div {
    padding: 10px;
  }
  form textarea {
    height: 80px;
  }
  form button[type="submit"] {
    padding: 10px 15px;
  }
  form.vote-buttons button[type="submit"] {
    padding: 10px 15px;
  }
}

@media (max-width: 480px) {
  .comments div {
    padding: 5px;
  }
  form textarea {
    height: 60px;
  }
  form button[type="submit"] {
    padding: 10px 10px;
  }
  form.vote-buttons button[type="submit"] {
    padding: 10px 10px;
  }
}
</style>
