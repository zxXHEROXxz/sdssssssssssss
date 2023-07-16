<?php
include 'connection.php'; // Include your connection file

// Retrieve the reservation ID from the query string
$reservationId = $_GET['reservationId'];

// Retrieve the reservation details from the database
try {
    $stmt = $conn->prepare('SELECT reservations.date, studios.name AS studio_name, time_slots.time, packages.name AS package_name, packages.price, reservations.advance_payment, reservations.status FROM reservations
                            INNER JOIN studios ON reservations.studio_id = studios.id
                            INNER JOIN time_slots ON reservations.time_slot_id = time_slots.id
                            INNER JOIN packages ON reservations.package_id = packages.id
                            WHERE reservations.id = :reservationId');
    $stmt->bindParam(':reservationId', $reservationId);
    $stmt->execute();
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    // Calculate the total by subtracting the advance payment from the package price
    $total = $reservation['price'] - $reservation['advance_payment'];
} catch (PDOException $e) {
    echo "Query failed: " . $e->getMessage();
    exit();
}

// Generate the printable version of the bill
$html = '
<style>
.bill-container {
    width: 500px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
}

.bill-title {
    font-size: 24px;
    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

.bill-category {
    margin-top: 20px;
    margin-bottom: 10px;
    color: #555;
    font-weight: bold;
}

.bill-info {
    margin-bottom: 10px;
    color: #555;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    border-bottom: 1px solid #ccc;
    padding-bottom: 5px;
}

.bill-info label {
    font-weight: bold;
    flex-basis: 40%;
}

.bill-info p {
    margin: 0;
    flex-basis: 60%;
    text-align: right;
}

.bill-total {
    margin-top: 40px;
    text-align: right;
    font-weight: bold;
    color: #333;
}

.bill-studio-logo {
    width: 120px;
    height: auto;
    margin-left: auto;
    margin-right: auto;
    display: block;
}

.bill-studio-info {
    text-align: center;
    color: #777;
    font-size: 12px;
}

.bill-divider {
    border-top: 1px solid #ccc;
    margin-top: 10px;
    margin-bottom: 10px;
}

</style>
<div class="bill-container">
    <img class="bill-studio-logo" src="assets/images/photo_studio_logo.png" alt="Studio Logo">
    <h1 class="bill-title">Invoice</h1>
    <div class="bill-category">Reservation</div>
    <div class="bill-info">
        <label>ID:</label>
        <p>' . $reservationId . '</p>
    </div>
    <div class="bill-info">
        <label>Reservation Date:</label>
        <p>' . $reservation['date'] . '</p>
    </div>
    <div class="bill-info">
        <label>Time Slot:</label>
        <p>' . $reservation['time'] . '</p>
    </div>
    <div class="bill-category">Studio</div>
    <div class="bill-info">
        <label>Studio:</label>
        <p>' . $reservation['studio_name'] . '</p>
    </div>
    <div class="bill-category">Price</div>
    <div class="bill-info">
        <label>Package:</label>
        <p>' . $reservation['package_name'] . '</p>
    </div>
    <div class="bill-info">
        <label>Package Price:</label>
        <p>LKR ' . $reservation['price'] . '</p>
    </div>
    <div class="bill-info">
        <label>Advance Payment:</label>
        <p>LKR ' . $reservation['advance_payment'] . '</p>
    </div>
    <div class="bill-divider"></div>
    <div class="bill-category">Status</div>
    <div class="bill-info">
        <label>Status:</label>
        <p>' . $reservation['status'] . '</p>
    </div>
    <div class="bill-total">
        <label>Total Payable:</label>
        <p>LKR ' . $total . '</p>
    </div>
    <div class="bill-studio-info">
        <p>Photo Studio</p>
        <p>18 Galle Rd</p>
        <p>Kalutara</p>
        <p>Phone: (94)71-444-7777</p>
        <p>Email: info@photography.com</p>
        <div class="bill-print-date">
            <p>Printed on: ' . gmdate('Y-m-d h:i:s A', time() + 19800) . '</p>
        </div>
    </div>
</div>
';

// Output the printable bill
echo $html;