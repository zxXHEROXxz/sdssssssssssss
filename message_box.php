<?php
// Message Box
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    echo "<script>alert('$msg')</script>";

    // Login Password Incorrect
    if ($msg == 'Login Password Incorrect') {
        echo "<p>You will be redirected to the login page... </p>";
        echo "<script>setTimeout(function() { window.location.href = 'login_reg_page.php'; }, 1000);</script>";
    }

    // Login Email Incorrect
    if ($msg == 'Login Email not found') {
        echo "<p>You will be redirected to the login page... </p>";
        echo "<script>setTimeout(function() { window.location.href = 'login_reg_page.php'; }, 1000);</script>";
    }

    // User not verified
    if ($msg == 'User not verified') {
        echo "<p>You will be redirected to the verify page... </p>";
        echo "<script>setTimeout(function() { window.location.href = 'verify_page.php'; }, 1000);</script>";
    }

    // Email exists
    if ($msg == 'Email already exists') {
        echo "<p>You will be redirected to the login page... </p>";
        echo "<script>setTimeout(function() { window.location.href = 'login_reg_page.php'; }, 1000);</script>";
    }

    // wrong OTP
    if ($msg == 'Wrong OTP') {
        echo "<p>You will be redirected to the verify page... </p>";
        echo "<script>setTimeout(function() { window.location.href = 'verify_page.php'; }, 1000);</script>";
    }

    // new otp sent
    if ($msg == 'New OTP sent') {
        echo "<p>You will be redirected to the verify page... </p>";
        echo "<script>setTimeout(function() { window.location.href = 'verify_page.php'; }, 1000);</script>";
    }

    // message could not be sent mailer error
    if ($msg == 'Message could not be sent. Mailer Error...') {
        echo "<p>You will be redirected to the Login page. </p>";
        echo "<script>setTimeout(function() { window.location.href = 'login_reg_page.php'; }, 1000);</script>";
    }

    // user not logged in
    if ($msg == 'User not logged in') {
        echo "<p>You will be redirected to the Login page... </p>";
        echo "<script>setTimeout(function() { window.location.href = 'login_reg_page.php'; }, 1000);</script>";
    }
}