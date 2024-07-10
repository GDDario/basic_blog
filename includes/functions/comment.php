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
                comment.id,
                comment.uuid,
                comment.post_id,
                comment.content,
                comment.likes,
                comment.dislikes,
                comment.created_at,
                comment.updated_at,
                comment.deleted_at,
                user.name,
                comment_like.id AS liked,
                comment_dislike.id AS disliked
            FROM 
                comment
                INNER JOIN user ON (comment.user_id = user.id)
                LEFT JOIN comment_like ON (comment_like.user_id = user.id AND comment_like.comment_id = comment.id)
                LEFT JOIN comment_dislike ON (comment_dislike.user_id = user.id AND comment_dislike.comment_id = comment.id)
            WHERE
                comment.post_id = :postId
            ORDER BY created_at ASC
            ';

    $statement = $connection->prepare($sql);
    $statement->bindParam(':postId', $postId);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}

function removeLike(int $commentId): bool
{
    $connection = mysqlConnection();

    $sql = 'SELECT id AS already_liked FROM comment_like WHERE comment_id = :commentId AND user_id = :userId LIMIT 1';

    $statement = $connection->prepare($sql);
    $statement->bindParam(':commentId', $commentId);
    $statement->bindParam(':userId', $_SESSION['user_id']);
    $statement->execute();
    $fetch = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$fetch) {
        return false;
    }

    $sql = 'DELETE FROM comment_like WHERE comment_id = :commentId AND user_id = :userId';
    $statement = $connection->prepare($sql);
    $statement->bindParam(':commentId', $commentId);
    $statement->bindParam(':userId', $_SESSION['user_id']);
    $statement->execute();

    $sql = 'UPDATE comment SET likes = likes - 1 WHERE id = :commentId';
    $statement = $connection->prepare($sql);
    $statement->bindParam(':commentId', $commentId);
    $statement->execute();

    return true;
}

function removeDislike(int $commentId): bool
{
    $connection = mysqlConnection();

    $sql = 'SELECT id AS already_disliked FROM comment_dislike WHERE comment_id = :commentId AND user_id = :userId LIMIT 1';
    $statement = $connection->prepare($sql);
    $statement->bindParam(':commentId', $commentId);
    $statement->bindParam(':userId', $_SESSION['user_id']);
    $statement->execute();
    $fetch = $statement->fetch(PDO::FETCH_ASSOC);

    if (!$fetch) {
        return false;
    }

    $sql = 'DELETE FROM comment_dislike WHERE comment_id = :commentId AND user_id = :userId';
    $statement = $connection->prepare($sql);
    $statement->bindParam(':commentId', $commentId);
    $statement->bindParam(':userId', $_SESSION['user_id']);
    $statement->execute();

    $sql = 'UPDATE comment SET dislikes = dislikes - 1 WHERE id = :commentId';
    $statement = $connection->prepare($sql);
    $statement->bindParam(':commentId', $commentId);
    $statement->execute();

    return true;
}
