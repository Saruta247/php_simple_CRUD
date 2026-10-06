<?php
    //16.clear sessions
    // Start the session
    session_start();

    // Check if the user is logged in
    if(isset($_SESSION['session_user_id'])) {
        // Destroy the session and redirect to login page
        session_destroy();
        unset($_SESSION['session_user_id']);
        unset($_SESSION['session_user_name']);
        header("Location: login.php");
        exit();
    }

    // Check if the admin is logged in
    if(isset($_SESSION['session_admin_name'])) {
        // Destroy the session and redirect to admin login page
        session_destroy();
        unset($_SESSION['session_admin_name']);
        header("Location: admin_login.php");
        exit();
    }

    // Default fallback
    session_destroy();
    header("Location: login.php");
    exit();
?>