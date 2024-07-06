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

            <section class="manage-post">
                <?php

                foreach ($posts as $index => $post) {

                    if (($index + 1) === $numberOfPosts) {
                        echo "<hr class='posts-separator'>";
                    }

                    echo "
                    <div class='wrapper'>
                        <div class='post-container'>
                    ";

                    $dateText = "Created at <b>{$post['created_at']}</b>";
                    if (!is_null($post['updated_at'])) {
                        $dateText .= " and updated at <b>{$post['updated_at']}</b>";
                    }
                ?>
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

                    <div class="post-operations">
                        Operations
                        <br>
                        <br>
                        <ul>
                            <li><a href="edit-post.php?uuid=<?= $post['uuid'] ?>"><button class="default">Edit</button></a></li>
                            <li><button class="warning" onclick="openModal('<?= $post['uuid'] ?>')">Delete</button></li>
                        </ul>
                    </div>
                </div>
            <?php
                }
            ?>
            </section>
        </main>
    </div>

    <div class="modal-container dialog" id="delete-modal">
        <div class="modal">
            <div class="modal-header">
                <h3>Delete post</h3>
                <button class="close-modal">x</button>
            </div>

            <div class="modal-body">
                <p>Are you sure you want to delete it? This action <b>cannot</b> be undone.</p>
            </div>

            <form action="../../includes/forms/delete-post.php" method="post">
                <input type="hidden" name="uuid" id='uuid' />
                <div class="modal-footer">
                    <button type="submit" class="confirm-deletion warning">Delete</button>
                    <button type="button" class="close-modal default">Cancel</button>
                </div>
            </form>
            </div>
    </div>

    <script src="../js/manage-posts.js"></script>
</body>

</html>