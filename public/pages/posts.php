<?php

require '../../config/error.php';
require_once '../../includes/functions/redirect.php';
require_once '../../includes/functions/post.php';
//require_once '../../includes/functions/cookie.php';

session_start();

verifyItsNotLogged();

$posts = listPosts();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts - Basic Blog</title>

    <link rel="stylesheet" href="../css/global.css">
    <link rel="stylesheet" href="../css/posts.css">
</head>

<body>
    <script>
        function getQueryParam(param) {
            let urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        function removeQueryParam(param) {
            let urlParams = new URLSearchParams(window.location.search);
            urlParams.delete(param);
            let newUrl = window.location.pathname + '?  ' + urlParams.toString();
            window.history.replaceState({}, document.title, newUrl);
        }

        let keepLogged = getQueryParam('keep-logged');
        if (keepLogged === 'true') {
            localStorage.setItem('keep-connected', true);
        } else {
            sessionStorage.setItem('keep-connected', true);
        }

        removeQueryParam('keep-logged');
    </script>

    <?php include '../components/message.php' ?>
    <?php include "../components/header.php" ?>

    <div class="page-body">
        <main class="main-content floating-container">
            <h1>Blog posts</h1>

            <section class="manage-post">
                <?php

                foreach ($posts as $index => $post) {
                    echo "
                    <a href='./post.php?uuid={$post['uuid']}'>
                        <div class='post-container'>
                    ";                    
                ?>
                        <header>
                            <div class="post-details">
                                <p>Created by <?= $post['author'] ?> at <b><?= $post['created_at'] ?></b></p>
                                <?php
                                if (!is_null($post['updated_at'])) {
                                    echo "<p>Updated at <b>{$post['updated_at']}</b></p>";
                                }
                                ?>
                            </div>
                            <h3><?= $post['title'] ?></h3>
                        </header>

                        <div>
                            <p class="description"><?= $post['description'] ?></p>
                            <img src="../../uploads/posts/<?= $post['thumbnail_url'] ?>" />
                        </div>
                    </div>
                </a>

            <?php
                }
            ?>
            </section>
        </main>

        <?php include "../components/side-bar.php" ?>
    </div>

    <?php include "../components/footer.php" ?>
</body>

</html>