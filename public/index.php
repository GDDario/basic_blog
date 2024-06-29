<?php

session_start();

require '../config/error.php';
include '../includes/functions/redirect.php';

verifyItsLogged();

verifyItsNotLogged();