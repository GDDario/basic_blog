<?php

function mysqlConnection(): PDO
{
    $serverName = $_ENV['DB_SERVERNAME'];
    $databaseName = $_ENV['DB_NAME'];
    $username = $_ENV['DB_USERNAME'];
    $password = $_ENV['DB_PASSWORD'];

    try {
        $connection = new PDO("mysql:host=$serverName;dbname=$databaseName", $username, $password);

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $connection;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
}
