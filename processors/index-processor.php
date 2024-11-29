<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$statusMessage = isset($_SESSION['status_message']) ? $_SESSION['status_message'] : null;

unset($_SESSION['status_message']);
?>