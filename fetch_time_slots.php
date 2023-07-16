<?php
// fetch_time_slots.php

// Include the database connection file
include 'connection.php';

// Retrieve the selected date and studio from the AJAX request
$date = $_POST['date'];
$studio = $_POST['studio'];

// Fetch the time slots and their availability based on the reservation status
$sql = "SELECT ts.id, ts.time,
        CASE WHEN r.id IS NOT NULL THEN 'Unavailable' ELSE 'Available' END AS availability
        FROM time_slots ts
        LEFT JOIN reservations r ON ts.id = r.time_slot_id AND r.date = :date AND r.studio_id = :studio
        WHERE ts.studio_id = :studio";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':studio', $studio);
    $stmt->execute();

    // Generate HTML options for time slots
    $time_slots = '';
    $availableTimeSlots = false;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $time_slots .= '<option value="' . $row['id'] . '"' . ($row['availability'] === 'Unavailable' ? ' disabled' : '') . '>' . $row['time'] . ' (' . $row['availability'] . ')</option>';
        if ($row['availability'] === 'Available') {
            $availableTimeSlots = true;
        }
    }

    if (!$availableTimeSlots) {
        $time_slots = '<option disabled>No Time Slots Available for this Studio</option>';
    }

    // Echo the generated HTML options
    echo $time_slots;
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}

// Close the database connection (optional since PDO automatically closes the connection when the script ends)
$conn = null;