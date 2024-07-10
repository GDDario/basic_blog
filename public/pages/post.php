<?php

require '../../config/error.php';
require_once '../../includes/functions/redirect.php';
require_once '../../includes/functions/post.php';
require_once '../../includes/functions/comment.php';
require_once '../../includes/functions/user.php';

session_start();

verifyItsNotLogged();

$uuid = $_GET['uuid'];
$post = getPostByUuid($uuid);

$comments = getCommentsByPostUuid($uuid);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts - Basic Blog</title>

    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/post.css">
</head>

<body>
    <script>
        const uuid = "<?= $uuid ?>";
    </script>

    <?php include '../components/message.php' ?>
    <?php include "../components/header.php" ?>

    <div class="page-body">
        <main class="main-content floating-container">
            <section>
                <h1><?= $post['title'] ?></h1>

                <br>

                <p><?= $post['description'] ?></p>
                <img src="../../uploads/posts/<?= $post['thumbnail_url'] ?>" />

                <?= $post['content'] ?>
            </section>

            <hr class="separator">

            <section class="comments">
                <h4>Comments</h4>

                <button id="create-comment">Create comment</button>

                <div id="new-comment" class="floating-container">
                    <div class="header">
                        <p>New comment</p>
                        <button id="close-new-comment"><b>x</b></button>
                    </div>

                    <textarea id="new-comment-content" rows="3" placeholder="Write your comment here..."></textarea>

                    <button id="publish-comment">Publish comment</button>
                </div>

                <div id="comments-container" class="comments-container">
                    <?php
                    foreach ($comments as $comment) {
                    ?>
                        <div class="comment">
                            <p><?= $comment['name'] . ' at ' . $comment['created_at'] ?></p>
                            <br>
                            <p><?= $comment['content'] ?></p>
                            <div class="comment-operations">
                                <div class="operation-container">
                                    <span role="button" class="like" id="like-<?= $comment['id'] ?>" onclick="likeComment(this)">👍</span>
                                    <span class="likes-count <?php if ($comment['liked']) echo 'liked' ?>" id="number_likes-<?= $comment['id'] ?>">
                                        <?= $comment['likes'] ?>
                                    </span>
                                </div>
                                <div class="operation-container">
                                    <span role="button" class="dislike" id="dislike-<?= $comment['id'] ?>" onclick="dislikeComment(this)">👎</span>
                                    <span class="dislikes-count <?php if ($comment['liked']) echo 'disliked' ?>" id="number_dislikes-<?= $comment['id'] ?>">
                                        <?= $comment['dislikes'] ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </section>
        </main>

        <?php include "../components/side-bar.php" ?>
    </div>

    <?php include "../components/footer.php" ?>

    <script src="../js/post.js"></script>
</body>

</html>