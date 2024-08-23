<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  @$username = trim($_POST['username']);
  @$email = trim($_POST['email']);
  @$password = trim($_POST['password']);

  // Validate the input fields
  if (empty($username) || empty($email) || empty($password)) {
    echo 'Please fill in all fields.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Invalid email address.';
  } else {
    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $password]);

    header('Location: login.php');
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <style>
    h1 {
      text-align: center;
    }

    a {
      position: relative;
      left: 45%;
      right: 50%;
      text-align: center;
      font-size: 2rem;
    }

    .login {
      padding: 0.8rem;
      color: #fff;
      font-size: 1.5rem;
      background-color: #2776ff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
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

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      height: 40px;
      margin-bottom: 20px;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    input[type="text"]:focus,
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

    @media (max-width: 768px) {
      form {
        max-width: 90%;
      }

      input[type="text"],
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

      input[type="text"],
      input[type="email"],
      input[type="password"] {
        font-size: 14px;
      }

      button[type="submit"] {
        font-size: 14px;
      }
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f0f0f0;
    }

    form {
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
      transition: border-color 0.2s ease;
    }

    button[type="submit"] {
      transition: background-color 0.2s ease;
    }
  </style>
</head>

<body>
  <h1>Register</h1>
  <form method="post" action="register.php">
    <input type="text" name="username" placeholder="Username" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Register</button>
  </form>
  <a href="login.php"><button class="login">Login In</button></a>
</body>

</html>