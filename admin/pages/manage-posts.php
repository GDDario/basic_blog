<?php

require '../../config/config.php';
require_once '../../includes/functions/redirect.php';
require_once '../../includes/functions/user.php';
require_once '../../includes/functions/post.php';

session_start();

verifyIfUserIsNotAdmin();

$posts = listPosts();
$numberOfPosts = count($posts);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage post - Basic Blog</title>

    <link rel="stylesheet" href="../../public/css/global.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/manage-posts.css">

    <!-- <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script> -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet"> -->
</head>

<body>

    <?php include '../../public/components/message.php' ?>
    <?php include "../../public/components/header.php" ?>

    <div class="admin page-body">
        <?php include '../components/side-bar.php' ?>

        <main class="main-content floating-container">
            <h1>Manage posts</h1>

            <section>
                <?php

                foreach ($posts as $index => $post) {
                    if (($index + 1) === $numberOfPosts) {
                        echo "<hr class='posts-separator'>";
                    }

                    $dateText = "Created at <b>{$post['created_at']}</b>";
                    if (!is_null($post['updated_at'])) {
                        $dateText .= " and updated at <b>{$post['updated_at']}</b>";
                    }

                ?>

                    <div class="post-container">
                        <header>
                            <div class="post-details">
                                <p><?= $dateText ?></p>
                                <p>Author: <?= $post['author'] ?></p>
                            </div>
                            <h3><?= $post['title'] ?></h3>
                        </header>

                        <div>
                            <p class="description"><?= $post['description'] ?></p>
                            <img src=<?= "../../uploads/posts/{$post['thumbnail_url']}" ?> />
                        </div>
                    </div>

                <?php
                }

                ?>
            </section>
        </main>
    </div>
</body>

</html>