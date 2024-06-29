<?php

require '../../config/config.php';

session_start();
session_unset();
session_destroy();
setcookie("KEEPCONNECTED", "", time() - 3600, "/");

header("Location: /basic-blog/public/index.php");

exit;
