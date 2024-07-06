<?php

include '../../config/config.php';
include '../functions/mysql-connection.php';
include '../functions/user.php';

session_start();

if (!verifyIfUserIsAdmin()) {
    $_SESSION['message'] = ['type' => 'error', 'content' => 'Access denied.'];
    header('Location: ../../public/pages/login.php');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['message'] = ['type' => 'error', 'content' => 'Invalid method.'];
    header('Location: ../../public/pages/login.php');
    exit;
}

$connection = mysqlConnection();

$postId = $_POST['uuid'];

$sql = 'DELETE FROM post WHERE uuid = :uuid';

$statement = $connection->prepare($sql);
$statement->bindParam(':uuid', $postId);
$result = $statement->execute();

if (!$result) {
    $_SESSION['message'] = ['type' => 'error', 'content' => 'The server could not delete the post. Try again later.'];
    header('Location: ../../admin/pages/manage-posts.php');
} else {
    $_SESSION['message'] = ['type' => 'success', 'content' => 'Post deleted successfully!'];
    header('Location: ../../admin/pages/manage-posts.php');
}
