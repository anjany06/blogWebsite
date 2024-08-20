<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    @$email = $_POST['email'];
    @$password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['user_id'] = $admin['id'];
        $_SESSION['username'] = $admin['username'];
        $_SESSION['role'] = $admin['role'];
        header('Location: dashboard.php');
        exit();
    } else {
        echo 'Invalid login credentials';
    }
}
?>
<form method="post" action="admin_login.php">
    <input type="email" name="email" placeholder="Admin Email" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
<style>
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
</style>