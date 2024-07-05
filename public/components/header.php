<?php

require_once __DIR__ . '/../../includes/functions/user.php';

$userData = getUserData();

?>

<header class="main-header">
    <a href="/basic-blog/public" class="logo">
        <h2>Basic Blog</h2>
    </a>

    <nav class="navigation-menu">
        <ul>
            <li><a href="/basic-blog/public/pages/posts.php">Posts</a></li>
            <li><a href="/basic-blog/public/pages/about.php">About</a></li>
        </ul>
    </nav>

    <div class="user-options">
        <a href="/basic-blog/admin/pages/manage-posts.php" id="admin-button" class="admin-button header-box" role="button">
            <img src="/basic-blog/public/img/admin-icon.png" alt="Profile picture" class="profile-picture">
        </a>

        <div id="user-menu" class="user-menu header-box" role="button">
            <div class="username-container">
                <label>Username</label>
                <span class="username"><?= $userData['username'] ?></span>
            </div>

            <img src="/basic-blog/public/img/user-icon-placeholder.png" alt="Profile picture" class="profile-picture">

            <ul id='user-sub-menu' class="sub-menu">
                <li>
                    <a href="/basic-blog/includes/forms/sign-out.php">Sign out</a>
                </li>
            </ul>
        </div>
    </div>
</header>

<script src="/basic-blog/public/js/header.js"></script>