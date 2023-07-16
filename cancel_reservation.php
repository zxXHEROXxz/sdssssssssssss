<?php
// cancel_reservation.php

if (isset($_POST['reservationId'])) {
    $reservationId = $_POST['reservationId'];
    // Include the database connection file
    include 'connection.php';

    // Delete the reservation from the database
    $sql = "DELETE FROM reservations WHERE id = :reservationId";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':reservationId', $reservationId);
        $stmt->execute();

        // Check if the deletion was successful
        if ($stmt->rowCount() > 0) {
            echo "Reservation canceled successfully.";
        } else {
            echo "Failed to cancel the reservation.";
        }
    } catch (PDOException $e) {
        echo "Query failed: " . $e->getMessage();
    }

    // Close the database connection
    $conn = null;
} else {
    echo "Invalid request.";
}