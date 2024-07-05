<?php

require_once 'mysql-connection.php';

function getUserData()
{
    if (!isset($_SESSION['user_id'])) {
        return;
    }

    $connection = mysqlConnection();

    $sql = 'SELECT * FROM user WHERE id = :id';
    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $_SESSION['user_id']);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result;
}

function verifyIfUserIsAdmin(): bool
{
    if (!isset($_SESSION['user_id'])) {
        return false;
    }

    $connection = mysqlConnection();

    $sql = 'SELECT user.role_id = 1 AS is_admin FROM user WHERE id = :id';
    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $_SESSION['user_id']);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_ASSOC);

    return $result['is_admin'] === 1;
}
