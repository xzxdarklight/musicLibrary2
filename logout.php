<?php

    //access the current session
    session_start();

    //terminate the session
    session_destroy();

    //relocate to the login screen
    header('location:login.php');
?>
