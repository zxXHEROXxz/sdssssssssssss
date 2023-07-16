<?php
// fetch_studio.php

// Include the database connection file
include 'connection.php';

// Retrieve the selected date from the AJAX request
$date = $_POST['date'];

// Fetch the studios and their availability based on the reservation status of time slots
$sql = "SELECT s.id, s.name,
        CASE WHEN COUNT(r.id) = 4 THEN 'Unavailable' ELSE 'Available' END AS availability
        FROM studios s
        LEFT JOIN time_slots ts ON s.id = ts.studio_id
        LEFT JOIN reservations r ON ts.id = r.time_slot_id AND r.date = :date
        GROUP BY s.id, s.name";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':date', $date);
    $stmt->execute();

    $studios = '';
    $availableStudios = false;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $studios .= '<option value="' . $row['id'] . '" ';
        if ($row['availability'] === 'Unavailable') {
            $studios .= 'disabled';
        } else {
            $availableStudios = true;
        }
        $studios .= '>' . $row['name'] . ' (' . $row['availability'] . ')</option>'; 
    }

    if (!$availableStudios) {
        $studios = '<option disabled>No Studios Available for this day</option>';
    }

    // Echo the generated HTML options
    echo $studios;
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}

// Close the database connection (optional since PDO automatically closes the connection when the script ends)
$conn = null;
