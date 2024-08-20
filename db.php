<?php
$db = 'mysql:host=localhost:3307;dbname=blog';
$username = 'root';
$password = '';
$options = [];

try {
    $pdo = new PDO($db, $username, $password, $options);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}
?>