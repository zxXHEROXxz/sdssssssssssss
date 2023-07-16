<?php
include 'connection.php';
include 'session_check.php';
include 'order_status_table.php';
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <title>Order Status</title>
    <link rel="stylesheet" href="assets/css/order_status_page.css">
    <link rel="stylesheet" href="print_preview.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="tcpdf/tcpdf.js"></script>
</head>

<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>
    <!-- Order Status Page Content -->
    <!-- HTML code to display the reservation rows -->
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Order Status</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-center">Reservation Date</th>
                            <th class="text-center">Studio</th>
                            <th class="text-center">Time Slot</th>
                            <th class="text-center">Package</th>
                            <th class="text-center">Advance Payment</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservations as $reservation): ?>
                            <tr>
                                <td class="text-center">
                                    <?php echo $reservation['date']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $reservation['studio_name']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $reservation['time']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $reservation['package_name']; ?>
                                </td>
                                <td class="text-center">LKR
                                    <?php echo $reservation['advance_payment']; ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $reservation['status']; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($reservation['status'] === 'Pending'): ?>
                                        <div class="d-flex justify-content-center">
                                            <div class="col-6 pr-1">
                                                <button class="btn btn-danger btn-cancel btn-block"
                                                    data-reservation-id="<?php echo $reservation['id']; ?>">Cancel</button>
                                            </div>
                                            <div class="col-6 pl-1">
                                                <button class="btn btn-success btn-print btn-block"
                                                    data-reservation-id="<?php echo $reservation['id']; ?>">Print Bill</button>
                                            </div>
                                        </div>
                                    <?php elseif ($reservation['status'] === 'Reserved'): ?>
                                        <div class="d-flex justify-content-center">
                                            <div class="col-12">
                                                <button class="btn btn-success btn-print btn-block"
                                                    data-reservation-id="<?php echo $reservation['id']; ?>">Print Bill</button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- JavaScript code to handle reservation cancellation -->
    <script>
        $(document).ready(function () {
            // Handle cancel button click
            $('.btn-cancel').click(function () {
                var reservationId = $(this).data('reservation-id');

                // Show a confirmation prompt
                var confirmCancel = confirm("Are you sure you want to cancel this reservation?");

                if (confirmCancel) {

                    // Send AJAX request to cancel the reservation
                    $.ajax({
                        url: 'cancel_reservation.php',

                        method: 'POST',
                        data: {
                            reservationId: reservationId
                        },
                        success: function (response) {
                            // Update the UI or display a success message
                            alert(response);
                            // refresh the page
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Handle print button click
            $('.btn-print').click(function () {
                var reservationId = $(this).data('reservation-id');

                // Open a new window with the print preview page
                var printWindow = window.open('print_preview.php?reservationId=' + reservationId, '_blank');
                // close window after print
                // print the page
                printWindow.print();
                printWindow.onafterprint = function () {
                    printWindow.close();
                };
            });
        });
    </script>



</body>

</html>