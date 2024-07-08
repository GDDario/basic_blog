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

function getPostByUuid(string $uuid)
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
                post.content, 
                post.updated_at
            FROM 
                post
            WHERE
                uuid = :uuid
            LIMIT 1
            ';
    $statement = $connection->prepare($sql);
    $statement->bindParam(':uuid', $uuid);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function getPostIdByUuid(string $uuid)
{
    $connection = mysqlConnection();

    $sql = 'SELECT
                id
            FROM 
                post
            WHERE
                uuid = :uuid
            LIMIT 1
    ';

    $statement = $connection->prepare($sql);
    $statement->bindParam(':uuid', $uuid);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result['id'];
}