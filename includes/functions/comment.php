<?php

require_once 'mysql-connection.php';

function getCommentsByPostUuid(string $uuid)
{
    if (!isset($_SESSION['user_id'])) {
        return;
    }

    $connection = mysqlConnection();

    $postId = getPostIdByUuid($uuid);

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
                comment.post_id = :postId
            ';

    $statement = $connection->prepare($sql);
    $statement->bindParam(':postId', $postId);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}
