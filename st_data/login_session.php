<?php
include_once __DIR__ . '/../config.php';

    session_start();
    if(!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }
?>
