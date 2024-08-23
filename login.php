<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  @$email = $_POST['email'];
  @$password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];
    header('Location: index.php');
    exit();
  } else {
    echo 'Invalid login credentials';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>login</title>
  <style>
    h1 {
      text-align: center;
    }

    form {
      max-width: 300px;
      margin: 40px auto;
      padding: 20px;
      background-color: #f9f9f9;
      border: 1px solid #ccc;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      height: 40px;
      margin-bottom: 20px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    input[type="email"]:focus,
    input[type="password"]:focus {
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

    a {
      display: block;
      margin-top: 20px;
      text-align: center;
      color: #337ab7;
      text-decoration: none;
    }

    a:hover {
      color: #23527c;
    }

    @media (max-width: 768px) {
      form {
        max-width: 90%;
      }

      input[type="email"],
      input[type="password"] {
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

      input[type="email"],
      input[type="password"] {
        font-size: 14px;
      }

      button[type="submit"] {
        font-size: 14px;
      }
    }
  </style>
</head>

<body>
  <h1>LOGIN IN</h1>
  <form method="post" action="">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <a href="login_google.php">Login with Google</a>
  </form>
</body>

</html>