<?php

include '../../config/config.php';
include '../functions/mysql-connection.php';
include '../functions/comment.php';
include '../functions/post.php';

session_start();

$connection = mysqlConnection();

$content = $_POST['content'];
$uuid = $_POST['post_uuid'];
$userId = $_SESSION['user_id'];

$postId = getPostIdByUuid($uuid);

$sql = 'INSERT INTO comment (uuid, post_id, user_id, content, created_at)
        VALUES (UUID(), :postId, :userId, :content, NOW())';

$statement = $connection->prepare($sql);
$statement->bindParam(':postId', $postId);
$statement->bindParam(':userId', $userId);
$statement->bindParam(':content', $content);
$result = $statement->execute();

if (!$result) {
    echo 'Error on comment creation.';
} else {
    $commentId = $connection->lastInsertId();
    
    $sql = 'SELECT
                comment.uuid,
                comment.post_id,
                comment.content,
                comment.likes,
                comment.dislikes,
                comment.created_at,
                comment.updated_at,
                comment.deleted_at,
                user.name
            FROM 
                comment
                INNER JOIN user ON (comment.user_id = user.id)
            WHERE
                comment.id = :commentId
            LIMIT 1
            ';
    $statement = $connection->prepare($sql);
    $statement->bindParam(':commentId', $commentId);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    echo json_encode($result);
}
