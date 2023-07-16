<?php
// session_check.php
// Check if the user is logged in
session_start();
include_once 'connection.php';

// Check if the user clicked the logout link
if (isset($_GET['logout'])) {
    // Destroy the session
    session_destroy();

    // Redirect to the login page
    header('location: login_reg_page.php');
    exit;
}

// Check if the session email is set
if (isset($_SESSION['email'])) {
    // Check if the email is verified
    if (isset($_SESSION['verified']) && $_SESSION['verified'] === true) {
        // Retrieve the user's details from the database
        $sql = "SELECT * FROM `users` WHERE `email` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $_SESSION['email'], PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            $user = $result[0];
            $_SESSION['user_id'] = $user['id'];
        }
    } else {
        // Redirect to the login page if the user is not verified
        header('location: message_box.php?msg=User not verified');
        exit;
    }
} else {
    // Redirect to the login page if the user is not logged in
    header('location: login_reg_page.php');
    exit;
}