<?php

session_start();

//require '../config/config.php';
require '../includes/functions/redirect.php';

// $_SESSION['user_id'] = 2;
// unset($_SESSION['user_id']);

$hasSession = isset($_SESSION['user_id']);

if ($hasSession) {
    redirectLoggedUser($_SESSION['user_id']);
} else {
    header('Location: pages/login.php');
}