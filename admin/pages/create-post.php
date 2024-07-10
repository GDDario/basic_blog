<?php

require '../../config/config.php';
require_once '../../includes/functions/redirect.php';
require_once '../../includes/functions/user.php';

session_start();

verifyIfUserIsNotAdmin();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create post - Basic Blog</title>

    <link rel="stylesheet" href="../../public/css/global.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/post-operation.css">

    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
</head>

<body>

    <?php include '../../public/components/message.php' ?>
    <?php include "../../public/components/header.php" ?>

    <div class="admin page-body">
        <?php include '../components/side-bar.php' ?>

        <main class="main-content floating-container">
            <h1>Create a post</h1>

            <form class="post-operation" method="post" action="../../includes/forms/create-post.php" enctype="multipart/form-data">
                <div class="input-block">
                    <label>Title</label>
                    <input type="text" name="title" required />
                    <?php fieldError('title') ?>
                </div>

                <div class="input-block">
                    <label>Description</label>
                    <input type="text" name="description" required />
                    <?php fieldError('description') ?>
                </div>

                <div class="input-block">
                    <label>Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*" required />
                    <?php fieldError('thumbnail') ?>
                </div>

                <div class="input-block">
                    <label>Content</label>
                    <input id="content" type="hidden" name="content" />
                    <div id="editor"></div>
                    <?php fieldError('content') ?>
                </div>

                <div class="form-footer" aria-label="Form footer">
                    <button>Publish</button>
                </div>
            </form>
        </main>
    </div>

    <script src="../js/create-post.js"></script>
</body>

</html>