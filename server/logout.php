<?php
    session_start();
    session_destroy();
    header("Location: ../pages/signup.html");
    die();
?>