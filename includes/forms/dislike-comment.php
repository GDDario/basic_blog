<?php

include '../../config/config.php';
include '../functions/mysql-connection.php';
include '../functions/comment.php';
include '../functions/post.php';

session_start();

$commentId = $_POST['comment_id'];

// If removed successfully, do not proceed (it was already disliked)
if (removeDislike($commentId)) {
    echo 'removed-dislike';
    exit;
}

$connection = mysqlConnection();

$sql = 'INSERT INTO comment_dislike (comment_id, user_id) VALUES (:commentId, :userId)';
$statement = $connection->prepare($sql);
$statement->bindParam(':commentId', $commentId);
$statement->bindParam(':userId', $_SESSION['user_id']);
$result = $statement->execute();

$sql = 'UPDATE comment SET dislikes = dislikes + 1 WHERE id = :commentId';
$statement = $connection->prepare($sql);
$statement->bindParam(':commentId', $commentId);
$result = $statement->execute();

if (removeLike($commentId)) {
    echo 'removed-like';
    exit;
}

echo 'added-dislike';
