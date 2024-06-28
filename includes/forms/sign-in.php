<?php

require '../../config/config.php';
require '../functions/mysql-connection.php';
require '../functions/password.php';

session_start();

$connection = mysqlConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['message'] = ['type' => 'error', 'content' => 'Invalid method.'];
    header('Location: ../../public/pages/login.php');
    return;
}

$usernameEmail = $_POST['username-email'];
$password = $_POST['password'];

$sql = 'SELECT * FROM user WHERE username = :usernameEmail OR email = :usernameEmail';
$statement = $connection->prepare($sql);
$statement->bindParam(':usernameEmail', $usernameEmail);
$statement->execute();

$user = $statement->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['field'] = ['username-email' => ['No users found.']];
    // $_SESSION['message'] = ['type' => 'error', 'content' => 'Username and email does not exist.'];
    header('Location: ../../public/pages/login.php');
}

if (verifyPassword($password, $user['password'])) {
    $_SESSION['message'] = ['type' => 'success', 'content' => 'Logged-in successfully!'];
    header('Location: ../../public/pages/posts.php');
} else {
    $_SESSION['field'] = ['password' => ['Invalid password.']];
    header('Location: ../../public/pages/login.php');
}
