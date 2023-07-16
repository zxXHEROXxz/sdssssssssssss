<?php
// make_reservation.php

// Include the database connection file
include 'connection.php';

// get session variables
session_start();

// Retrieve the form inputs
$date = $_POST['date'];
$studio = $_POST['studio'];
$time_slot = $_POST['time_slot'];
$package = $_POST['package'];
$advancePayment = $_POST['price'];
$user_id = $_SESSION['user_id'];

try {
    // Check if the selected time slot is available for the chosen date and studio
    $checkAvailabilitySql = "SELECT COUNT(*) FROM reservations WHERE date = :date AND studio_id = :studio AND time_slot_id = :time_slot";
    $checkAvailabilityStmt = $conn->prepare($checkAvailabilitySql);
    $checkAvailabilityStmt->bindParam(':date', $date);
    $checkAvailabilityStmt->bindParam(':studio', $studio);
    $checkAvailabilityStmt->bindParam(':time_slot', $time_slot);
    $checkAvailabilityStmt->execute();
    $reservationCount = $checkAvailabilityStmt->fetchColumn();

    if ($reservationCount > 0) {
        // Time slot is already reserved
        echo "Reservation failed: The selected time slot is not available.";
    } else {
        // Retrieve the package price from the packages table
        $getPackagePriceSql = "SELECT price FROM packages WHERE id = :package";
        $getPackagePriceStmt = $conn->prepare($getPackagePriceSql);
        $getPackagePriceStmt->bindParam(':package', $package);
        $getPackagePriceStmt->execute();
        $packagePrice = $getPackagePriceStmt->fetchColumn();

        // Set the reservation status based on the comparison between advance payment and package price
        $status = ($advancePayment != $packagePrice) ? 'Pending' : 'Reserved';

        // Insert the reservation into the database
        $insertReservationSql = "INSERT INTO reservations (user_id, date, studio_id, time_slot_id, package_id, advance_payment, status)
            VALUES (:user_id, :date, :studio, :time_slot, :package, :advancePayment, :status)";
        $insertReservationStmt = $conn->prepare($insertReservationSql);

        // Assuming you have a session variable for the user ID

        // Bind the parameters
        $insertReservationStmt->bindParam(':user_id', $user_id);
        $insertReservationStmt->bindParam(':date', $date);
        $insertReservationStmt->bindParam(':studio', $studio);
        $insertReservationStmt->bindParam(':time_slot', $time_slot);
        $insertReservationStmt->bindParam(':package', $package);
        $insertReservationStmt->bindParam(':advancePayment', $advancePayment);
        $insertReservationStmt->bindParam(':status', $status);

        // Execute the query
        $insertReservationStmt->execute();

        // Confirmation message
        echo "Reservation successful!";


        // Additional code to generate the PDF printable bill
        // ...

        // Redirect the user to a confirmation page or any other appropriate action
        // header("Location: reservation_confirmation.php");
    }
} catch (PDOException $e) {
    echo "Reservation failed: " . $e->getMessage();
}

// Close the database connection (optional since PDO automatically closes the connection when the script ends)
$conn = null;