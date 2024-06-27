<?php

function redirectLoggedUser(int $userId)
{
    header('Location: ../public/pages/posts.php');
}

function verifyItsLogged(): void
{
    if (isset($_SESSION['user_id'])) {
        header('Location: ../pages/posts.php');
    }
}

function verifyItsNotLogged(): void
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../pages/login.php');
    }
}

function verifyUserRole(int $userId)
{
    $userId = $_SESSION['user_id'];

    verifyItsNotLogged();
    // Logic to redirect unauthorized user and authorized users

    $authorized = false; // Query to bd...

    if (!$authorized) {
        header('Location: ../public/pages/');
    }
}