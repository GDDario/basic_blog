<?php

require '../../config/error.php';
require_once '../../includes/functions/redirect.php';
require_once '../../includes/functions/post.php';
//require_once '../../includes/functions/cookie.php';

session_start();

verifyItsNotLogged();

$uuid = $_GET['uuid'];
$post = getPostByUuid($uuid);

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
            <section>
                <h1><?= $post['title'] ?></h1>

                <br>

                <p><?= $post['description'] ?></p>
                <img src="../../uploads/posts/<?= $post['thumbnail_url'] ?>" />

                <?= $post['content'] ?>
            </section>
        </main>

        <?php include "../components/side-bar.php" ?>
    </div>

    <?php include "../components/footer.php" ?>
</body>

</html>