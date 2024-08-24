<?php
include('db.php');

session_start();
//checks if variable is set with the an id showing on url
if (isset($_GET['id'])) {
  $stmt = $pdo->prepare("SELECT blogs.*, users.username FROM blogs JOIN users ON blogs.author_id = users.id WHERE blogs.id = ?");
  $stmt->execute([$_GET['id']]);
  // fetch the blog
  $blog = $stmt->fetch();

  if (!$blog) {
    echo 'Blog not found!';
    exit();
  }
  //prepare a statement to fetch all comments of that blog

  $commentStmt = $pdo->prepare("SELECT comments.*, users.username FROM comments JOIN users ON comments.author_id = users.id WHERE blog_id = ?");
  $commentStmt->execute([$_GET['id']]);
  //fetch all the comments of that blog
  $comments = $commentStmt->fetchAll();
}
?>

<h2><?= $blog['title']; ?></h2>
<p>By <?= $blog['username']; ?> on <?php echo $blog['created_at']; ?></p>
<p><?= $blog['content']; ?></p>

<h3>Comments</h3>
<?php foreach ($comments as $comment): ?>
  <div class="comments">
    <p><?= $comment['username']; ?>: <?php echo $comment['content']; ?></p>
  </div>
<?php endforeach; ?>

<?php
//checks the user to add comments
if (isset($_SESSION['user_id'])): ?>
  <form method="post" action="add_comment.php">
    <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
    <textarea name="content" placeholder="Write a comment..." required></textarea>
    <button type="submit">Post Comment</button>
  </form>
<?php endif; ?>
<?php
//checks the user to up and down vote
if (isset($_SESSION['user_id'])): ?>
  <form method="post" action="vote.php">
    <input type="hidden" name="blog_id" value="<?php echo $blog['id']; ?>">
    <button type="submit" name="vote_type" value="upvote">Upvote</button>
    <button type="submit" name="vote_type" value="downvote">Downvote</button>
  </form>

<?php endif; ?>
<?php
//select upvotes for each blog
$upvotes = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE blog_id = ? AND vote_type = 'upvote'");
$upvotes->execute([$blog['id']]);
//fetch the number
$upvoteCount = $upvotes->fetchColumn();
//selec downtvotes for each blog
$downvotes = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE blog_id = ? AND vote_type = 'downvote'");
$downvotes->execute([$blog['id']]);
$downvoteCount = $downvotes->fetchColumn();
?>

<p>Upvotes: <?= $upvoteCount; ?></p>
<p>Downvotes: <?= $downvoteCount; ?></p>
<a href="index.php"><button class="home">Back to Home</button></a>


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

  h3 {
    font-size: 18px;
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

  .home {
    padding: 0.8rem;
    color: #fff;
    font-size: 1.5rem;
    background-color: #2776ff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
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
  }

  @media (max-width: 480px) {
    .comments div {
      padding: 10px;
    }

    form textarea {
      height: 80px;
    }

    form button[type="submit"] {
      padding: 10px 15px;
    }
  }
</style>