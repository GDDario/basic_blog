<?php

require_once 'mysql-connection.php';

function listPosts()
{
    if (!isset($_SESSION['user_id'])) {
        return;
    }

    $connection = mysqlConnection();

    $sql = 'SELECT
                post.uuid, 
                post.title, 
                post.description, 
                post.thumbnail_url, 
                post.created_at,
                post.updated_at,
                user.name as author
            FROM 
                post
                INNER JOIN user ON (post.author_id = user.id)
            ';
    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result;
}
