<?php

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $type = $message['type'];
    $header = ucfirst($type);
    $content = $message['content'];

    echo "
        <div class='message-container $type'>
            <p class='message-header'>
                <b>$header</b>
            </p>
            <hr>
            <p class='message-body'>$content</p>
        </div>
    ";
}

unset($_SESSION['message']);
