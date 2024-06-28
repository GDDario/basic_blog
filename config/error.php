<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(E_ALL);

function fieldError(string $fieldName) {
    if (isset($_SESSION['field']) && key($_SESSION['field']) === $fieldName) {
        echo "<div class='field-error'>";
        foreach($_SESSION['field'][$fieldName] as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";

        unset($_SESSION['field']);
    }
}