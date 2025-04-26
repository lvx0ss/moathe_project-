<?php
include_once __DIR__ . '/../config.php';

    session_start();
    // Destroy session
    if(session_destroy()) {
        // Redirecting To Home Page
        header("Location: st_login.php");
    }
?>
