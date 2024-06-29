<?php

require '../../config/error.php';
require_once '../../includes/functions/redirect.php';
require_once '../../includes/functions/cookie.php';

session_start();

verifyItsNotLogged();

// $userId = extractUserIdFromKeepMeLoggedInCookie();
// var_dump($userId);
// exit;
// if (!isset($_SESSION['user_id'])) {
//     header('Location: ./../public/pages/login.php');
//     // return;
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts - Basic Blog</title>
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

    <?php include "../components/header.php" ?>
</body>

</html>