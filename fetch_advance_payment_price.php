<?php
// fetch_advance_payment_price.php

// Include the database connection file
include 'connection.php';

// Retrieve the selected package from the AJAX request
if (!isset($_POST['package'])) {
    $packageId = 0;
} else {
    $packageId = $_POST['package'];
}

// Perform the necessary database query to fetch the advance payment price based on the selected package
$sql = "SELECT price FROM packages WHERE id = :packageId";

try {
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':packageId', $packageId);
    $stmt->execute();

    // Fetch the advance payment price from the query result
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Assign the advance payment price to a variable, if the query result is empty, assign 500
    $advancePaymentPrice = $row ? $row['price'] : 500;

    // Echo the advance payment price
    echo $advancePaymentPrice;
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
}

// Close the database connection (optional since PDO automatically closes the connection when the script ends)
$conn = null;
