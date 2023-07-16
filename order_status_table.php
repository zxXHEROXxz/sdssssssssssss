<?php
// get connection
include 'connection.php';

$user_id = $_SESSION['user_id'];

// Fetch reservations for the logged-in user from the database
// Assuming you have the user ID stored in a variable $userId

// Assuming you have established a database connection and stored it in the $conn variable

// Retrieve the reservations for the logged-in user
$user_id = $_SESSION['user_id']; // Assuming you have stored the user ID in the session
$sql = "SELECT r.id, r.date, s.name AS studio_name, t.time, p.name AS package_name, r.advance_payment, r.status
        FROM reservations r
        JOIN studios s ON r.studio_id = s.id
        JOIN time_slots t ON r.time_slot_id = t.id
        JOIN packages p ON r.package_id = p.id
        WHERE r.user_id = :user_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>