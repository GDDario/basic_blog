<?php

include '../../config/config.php';
include '../functions/mysql-connection.php';
include '../functions/comment.php';
include '../functions/post.php';

session_start();

$commentId = $_POST['comment_id'];

// If removed successfully, do not proceed (it was already liked)
if (removeLike($commentId)) {
    echo 'removed-like';
    exit;
}

$connection = mysqlConnection();

$sql = 'INSERT INTO comment_like (comment_id, user_id) VALUES (:commentId, :userId)';
$statement = $connection->prepare($sql);
$statement->bindParam(':commentId', $commentId);
$statement->bindParam(':userId', $_SESSION['user_id']);
$result = $statement->execute();

$sql = 'UPDATE comment SET likes = likes + 1 WHERE id = :commentId';
$statement = $connection->prepare($sql);
$statement->bindParam(':commentId', $commentId);
$result = $statement->execute();

if (removeDislike($commentId)) {
    echo 'removed-dislike';
    exit;
}

echo 'added-like';
