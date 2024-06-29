<?php

require __DIR__ . '/cookie.php';

function redirectLoggedUser()
{
    header('Location: ../public/pages/posts.php');
}

function verifyItsLogged(): void
{
    if (isset($_SESSION['user_id'])) {
        header('Location: /basic-blog/public/pages/posts.php');
    }

    if (isset($_COOKIE['KEEPCONNECTED'])) {
        $_SESSION['user_id'] = extractUserIdFromKeepMeLoggedInCookie();
        header('Location: /basic-blog/public/pages/posts.php');
    }
}

function verifyItsNotLogged(): void
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: /basic-blog/public/pages/login.php');
    }
}

function verifyUserRole(int $userId)
{
    $userId = $_SESSION['user_id'];

    // handleSessionState();
    // Logic to redirect unauthorized user and authorized users

    $authorized = false; // Query to bd...

    if (!$authorized) {
        header('Location: ../public/pages/');
    }
}
