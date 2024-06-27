<?php

include '../../includes/functions/redirect.php';

session_start();

verifyItsNotLogged();

// if (!isset($_SESSION['user_id'])) {
//     header('Location: ./../public/pages/login.php');
//     // return;
// }