<?php
require_once 'vendor/dompdf/dompdf/src/Dompdf.php'; // Adjust the path if needed
require_once 'vendor/dompdf/dompdf/src/Options.php'; // Adjust the path if needed
require_once 'connection.php'; // Include your connection file

use Dompdf\Dompdf;
use Dompdf\Options;

// Retrieve the reservation ID from the POST request
$reservationId = $_POST['reservationId'];

// Retrieve the reservation details from the database
try {
    $stmt = $conn->prepare('SELECT reservations.date, studios.name AS studio_name, time_slots.time, packages.name AS package_name, packages.price, reservations.status FROM reservations
                            INNER JOIN studios ON reservations.studio_id = studios.id
                            INNER JOIN time_slots ON reservations.time_slot_id = time_slots.id
                            INNER JOIN packages ON reservations.package_id = packages.id
                            WHERE reservations.id = :reservationId');
    $stmt->bindParam(':reservationId', $reservationId);
    $stmt->execute();
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
    exit();
}

// Create a new Dompdf instance
$dompdf = new Dompdf();

// Generate the PDF content
$html = '<h1>Reservation Bill</h1>';
$html .= '<p>Reservation ID: ' . $reservationId . '</p>';
$html .= '<p>Reservation Date: ' . $reservation['date'] . '</p>';
$html .= '<p>Studio: ' . $reservation['studio_name'] . '</p>';
$html .= '<p>Time Slot: ' . $reservation['time'] . '</p>';
$html .= '<p>Package: ' . $reservation['package_name'] . '</p>';
$html .= '<p>Price: $' . $reservation['price'] . '</p>';
$html .= '<p>Status: ' . $reservation['status'] . '</p>';

$dompdf->loadHtml($html);

// (Optional) Set any configuration options for Dompdf
$options = new Options();
$options->set('defaultFont', 'Helvetica');
$dompdf->setOptions($options);

// Render the PDF
$dompdf->render();

// Output the generated PDF
$dompdf->stream('reservation_bill.pdf', ['Attachment' => false]);