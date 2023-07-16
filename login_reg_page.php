<!DOCTYPE html>
<html>

<head>
    <title>Login and Register</title>
    <link rel="stylesheet" href="assets/css/login_register.css">
    <link rel="stylesheet" href="assets/css/image_loader.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var loader = document.querySelector(".loader");
            var content = document.querySelector(".content");

            // Show the loader on page refresh
            if (performance.navigation.type === 1) {
                loader.style.display = "flex";
                content.style.display = "none";
            } else {
                loader.style.display = "none";
                content.style.display = "block";
            }

            // Hide the loader and show the content after a delay
            setTimeout(function () {
                loader.style.display = "none";
                content.style.display = "block";
            }, 2000); // Adjusted delay time to 2000 milliseconds (2 seconds)
        });
    </script>

</head>

<body>

    <!-- Loader HTML -->
    <div class="loader">
        <img src="assets\images\loader.gif" alt="Loading...">
    </div>

    <div class="container content">
        <h2 class="card-title">Login to make a reservation</h2>
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade <?php echo $_SESSION['active_tab'] === 'login-form' ? 'show active' : ''; ?>"
                        id="login-form">
                        <h5 class="card-title">Login</h5>

                        <form action="user_login_controller.php" method="post">
                            <div class="form-group">
                                <label for="email-login">Email</label>
                                <input type="email" class="form-control" name="email-login" required>
                            </div>
                            <div class="form-group">
                                <label for="password-login">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password-login"
                                        name="password-login" required>
                                    <div class="input-group-append">
                                        <span class="password-icon" onclick="togglePassword('password-login')">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>

                    </div>
                    <div class="tab-pane fade <?php echo $_SESSION['active_tab'] === 'register-form' ? 'show active' : ''; ?>"
                        id="register-form">
                        <h5 class="card-title">Register</h5>


                        <form action="user_login_controller.php" method="post">

                            <div class="form-group">
                                <label for="name-register">Name</label>
                                <input type="text" class="form-control" name="name-register" required>
                            </div>
                            <div class="form-group">
                                <label for="email-register">Email</label>
                                <input type="email" class="form-control" name="email-register" required>
                            </div>
                            <div class="form-group">
                                <label for="password-register">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password-register"
                                        name="password-register" required>
                                    <div class="input-group-append">
                                        <span class="password-icon" onclick="togglePassword('password-register')">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password-register">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirm-password-register"
                                        name="confirm-password-register" required oninput="checkPasswordMatch()">
                                    <div class="input-group-append">
                                        <span class="password-icon"
                                            onclick="togglePassword('confirm-password-register')">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>
                                <span id="password-match-message" style="color: red;"></span>
                            </div>
                            <div class="form-group">
                                <label for="address-register">Address</label>
                                <input type="text" class="form-control" name="address-register" required>
                            </div>
                            <div class="form-group">
                                <label for="phone-register">Phone</label>
                                <input type="text" class="form-control" name="phone-register" required>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary" id="register-button"
                                disabled>Register</button>


                        </form>

                    </div>
                </div>
            </div>
            <div class="card-footer">
                <ul class="nav nav-tabs card-footer-tabs justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $_SESSION['active_tab'] === 'login-form' ? 'active' : ''; ?>"
                            id="login-tab" data-toggle="tab" href="#login-form">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $_SESSION['active_tab'] === 'register-form' ? 'active' : ''; ?>"
                            id="register-tab" data-toggle="tab" href="#register-form">Register</a>
                    </li>
                </ul>
            </div>
            <div class="text-center">
                <h5 class="small-text">Don't have an account yet? Register here</h5>
            </div>

        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const passwordIcon = passwordInput.nextElementSibling.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
        function checkPasswordMatch() {
            var passwordInput = document.getElementById('password-register');
            var confirmPasswordInput = document.getElementById('confirm-password-register');
            var passwordMatchMessage = document.getElementById('password-match-message');
            var registerButton = document.getElementById('register-button');

            if (passwordInput.value !== confirmPasswordInput.value) {
                passwordMatchMessage.textContent = "Passwords do not match";
                registerButton.disabled = true;
            } else {
                passwordMatchMessage.textContent = "";
                registerButton.disabled = false;
            }
        }
    </script>

</body>

</html>