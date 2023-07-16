<?php
include 'session_check.php';
?>

<!DOCTYPE html>
<html>

<head>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <title>Reservation Page</title>
    <link rel="stylesheet" href="assets/css/studio_page.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>

<body>
    <!-- Navbar -->
    <?php include 'navbar.php'; ?>

    <div class="container">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Make a Reservation</h5>
                <form id="reservation-form" action="make_reservation.php" method="POST">
                    <div class="form-group">
                        <label for="reservation-date">Reservation Date:</label>
                        <input type="text" class="form-control datepicker" id="reservation-date" name="reservation-date"
                            placeholder="Select Date" required>
                    </div>
                    <div class="form-group">
                        <label for="studio">Studio:</label>
                        <select class="form-control" id="studio" name="studio" required>
                            <?php echo $studios; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="time_slots">Time Slot:</label>
                        <select class="form-control" id="time_slots" name="time_slots" required>
                            <?php echo $time_slots; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="package">Package:</label>
                        <select class="form-control" id="package" name="package" required>
                            <?php echo $packages; ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Advance Payment Price:</label>
                        <input type="number" class="form-control" id="price" name="price"
                            placeholder="Enter Advance Payment Price" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Make Reservation</button>
                </form>
            </div>
        </div>
    </div>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js">
    </script>
    <script>
    $(document).ready(function() {
        // When reservation date is changed
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
            // default date is today
        }).datepicker("setDate", new Date());

        var selectedStudioId = '';

        function fetchStudios() {
            var selectedDate = $('#reservation-date').val();

            // Send AJAX request to retrieve available studios
            $.ajax({
                url: 'fetch_studios.php',
                method: 'POST',
                data: {
                    date: selectedDate
                },
                success: function(response) {
                    // Update the options in the studio dropdown menu
                    $('#studio').html(response);
                    selectedStudioId = '';

                    // Fetch the time slots for the selected studio
                    fetchTimeSlots();
                }
            });
        }

        function fetchTimeSlots() {
            var selectedDate = $('#reservation-date').val();
            var selectedStudioIdNew = $('#studio').val();

            // Send AJAX request to retrieve available time slots
            if (selectedStudioIdNew !== selectedStudioId) {
                selectedStudioId = selectedStudioIdNew;
                $.ajax({
                    url: 'fetch_time_slots.php',
                    method: 'POST',
                    data: {
                        date: selectedDate,
                        studio: selectedStudioId
                    },
                    success: function(response) {
                        // Update the options in the time slot dropdown menu
                        $('#time_slots').html(response);
                        fetchPackages();
                    }
                });
            }
        }

        function fetchPackages() {
            var selectedDate = $('#reservation-date').val();
            var selectedStudio = $('#studio').val();
            var selectedTimeSlot = $('#time_slots').val();

            // Send AJAX request to retrieve available packages
            $.ajax({
                url: 'fetch_packages.php',
                method: 'POST',
                data: {
                    date: selectedDate,
                    studio: selectedStudio,
                    time_slots: selectedTimeSlot
                },
                success: function(response) {
                    // Update the options in the package dropdown menu
                    $('#package').html(response);
                }
            });
        }

        $('#reservation-date').change(function() {
            fetchStudios();
        });

        $('#studio').change(function() {
            fetchTimeSlots();
        });

        $('#time_slots').change(function() {
            fetchPackages();
        });

        $('#package').change(function() {
            var selectedPackage = $(this).val();

            // Send AJAX request to retrieve advance payment price
            $.ajax({
                url: 'fetch_advance_payment_price.php',
                method: 'POST',
                data: {
                    package: selectedPackage
                },
                success: function(response) {
                    // Update the advance payment price
                    $('#price').val(response);
                }
            });
        });

        $('#reservation-form').submit(function(e) {
            e.preventDefault();

            var selectedDate = $('#reservation-date').val();
            var selectedStudio = $('#studio').val();
            var selectedTimeSlot = $('#time_slots').val();
            var selectedPackage = $('#package').val();
            var advancePaymentPrice = $('#price').val();
            // enum availability to be changed to not available
            var availability = 'not available';
            // id is the user id of the user who is logged in

            // Send AJAX request to make a reservation
            $.ajax({
                url: 'make_reservation.php',
                method: 'POST',
                data: {
                    date: selectedDate,
                    studio: selectedStudio,
                    time_slot: selectedTimeSlot,
                    package: selectedPackage,
                    price: advancePaymentPrice,
                    availability: availability
                },
                success: function(response) {
                    alert(response);
                }
            });
        });

        fetchStudios();
    });
    </script>

</body>

</html>