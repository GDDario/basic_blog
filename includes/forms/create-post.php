<?php

include '../../config/config.php';
include '../functions/mysql-connection.php';

use Ramsey\Uuid\Uuid;

session_start();

$connection = mysqlConnection();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['message'] = ['type' => 'error', 'content' => 'Invalid method.'];
    header('Location: ../../public/pages/login.php');
    exit;
}

$title = $_POST['title'];
$description = $_POST['description'];
$thumbnail = uploadImage();
$content = $_POST['content'];

$sql = 'INSERT INTO post (uuid, title, description, thumbnail_url, content, author_id, created_at)
        VALUES (UUID(), :title, :description, :thumbnailUrl, :content, :author_id, NOW())';

$statement = $connection->prepare($sql);
$statement->bindParam(':title', $title);
$statement->bindParam(':description', $description);
$statement->bindParam(':thumbnailUrl', $thumbnail);
$statement->bindParam(':content', $content);
$statement->bindParam(':author_id', $_SESSION['user_id']);
$result = $statement->execute();

if (!$result) {
    $_SESSION['message'] = ['type' => 'error', 'content' => 'The server could not create the post. Try again later.'];
    header('Location: ../../public/pages/login.php');
} else {
    $_SESSION['message'] = ['type' => 'success', 'content' => 'Post created successfully!'];
    header('Location: ../../public/pages/login.php');
}

function uploadImage(): string
{
    $imageUuid = Uuid::uuid4();
    $fileName = $imageUuid . '-' . basename($_FILES['thumbnail']['name']);
    $targetDir = '../../uploads/posts/';
    $targetFile = $targetDir . $fileName;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    if (file_exists($targetFile)) {
        $_SESSION['field'] = ['thumbnail' => ['Sorry, the image already exists.']];
        header('Location: ../../admin/pages/create-post.php');
    }

    if ($_FILES['thumbnail']['size'] > 5000000) {
        $_SESSION['field'] = ['thumbnail' => ['The file is too big!']];
        header('Location: ../../admin/pages/create-post.php');
    }

    $allowedTypes = ['jpg', 'png', 'jpeg', 'gif'];
    if (!in_array($imageFileType, $allowedTypes)) {
        $_SESSION['field'] = ['thumbnail' => ['The thumbnail must of type: JPG, JPEG, PNG, GIF.']];
        header('Location: ../../admin/pages/create-post.php');
    }

    if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetFile)) {
        return $fileName;
    } else {
        $_SESSION['field'] = ['thumbnail' => ['The file failed to be loaded, try again later']];
        header('Location: ../../admin/pages/create-post.php');
    }
}
