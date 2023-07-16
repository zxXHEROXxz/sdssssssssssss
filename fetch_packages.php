<?php
// fetch_packages.php

// Include the database connection file
include 'connection.php';

// Perform the necessary database query to fetch the packages
$sql = "SELECT id, name, price FROM packages";

try {
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Generate HTML options for packages
    $packages = '<option value="">Select Package</option>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $packages .= '<option value="' . $row['id'] . '">' . $row['name'] . ' - LKR.' . $row['price'] . '</option>';
    }

    // Echo the generated HTML options
    echo $packages;
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}

// Close the database connection (optional since PDO automatically closes the connection when the script ends)
$conn = null;
