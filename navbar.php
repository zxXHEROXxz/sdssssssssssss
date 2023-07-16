<!DOCTYPE html>
<html>

<head>
    <title>Navbar</title>
    <!-- Add necessary CSS files for Bootstrap -->
    <link rel="stylesheet" href="assets/css/navbar.css">
</head>

<body>
    <!-- navbar.php code goes here -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <?php
            $activePage = basename($_SERVER['PHP_SELF']);
            switch ($activePage) {
                case 'packages_page.php':
                    echo 'Packages';
                    break;
                case 'reservation_page.php':
                    echo 'Reservation';
                    break;
                case 'photo.php':
                    echo 'Photo';
                    break;
                case 'payment.php':
                    echo 'Payment';
                    break;
                case 'order_status_page.php':
                    echo 'Order Status';
                    break;
                default:
                    echo 'Studio Page';
                    break;
            }
            ?>
        </a>
        <!-- show user name here -->
        <span class="navbar-text">Welcome,
            <?php echo $_SESSION['username']; ?>
        </span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li
                    class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'packages_page.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="packages_page.php">Packages</a>
                </li>
                <li
                    class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'reservation_page.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="reservation_page.php">Reservation</a>
                </li>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'photo.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="photo.php">Photo</a>
                </li>
                <li class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'payment.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="payment.php">Payment</a>
                </li>
                <li
                    class="nav-item <?php echo (basename($_SERVER['PHP_SELF']) == 'order_status_page.php') ? 'active' : ''; ?>">
                    <a class="nav-link" href="order_status_page.php">Order Status</a>
                </li>
                <form action="navbar.php" method="POST">
                    <li class="nav-item">
                        <input type="submit" class="logout" name="logout" value="Log Out">
                    </li>
                </form>
            </ul>
        </div>
    </nav>

    <?php
    // Logout if the user clicks the logout button
    if (isset($_POST['logout'])) {
        session_start();
        session_destroy();
        header('location: login_reg_page.php');
        exit;
    }
    ?>

    <!-- Add necessary JavaScript files for Bootstrap -->
    <script src="path/to/bootstrap.js"></script>
</body>

</html>