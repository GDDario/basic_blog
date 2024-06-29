<?php

require_once '../../config/config.php';
require_once '../functions/mysql-connection.php';
require_once '../functions/password.php';
require_once '../functions/cookie.php';

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
    header('Location: ../../public/pages/login.php');
}

if (verifyPassword($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['message'] = ['type' => 'success', 'content' => 'Logged-in successfully!'];

    createKeepMeLoggedInCookie($user['id']);
    header("Location: ../../public/pages/posts.php?keep-logged=$keepLogged");
} else {
    $_SESSION['field'] = ['password' => ['Invalid password.']];
    header('Location: ../../public/pages/login.php');
}
