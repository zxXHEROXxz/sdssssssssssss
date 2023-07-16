<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="css/pre_loader.css">
    <title>Photo Studio Loading</title>
    <script>
        // Function to redirect to the landing page
        function redirect() {
            window.location.href = "/PSS/landing_page.php";
        }

        // Wait for the animation to complete
        window.onload = function () {
            var loader = document.querySelector(".loader");
            var loadingText = document.querySelector(".loading-text");

            // Duration of the animation in milliseconds
            var animationDuration = 2000;

            // Set a timeout to redirect after the animation duration
            setTimeout(function () {
                loader.style.display = "none";
                loadingText.innerHTML = "Redirecting...";
                redirect();
            }, animationDuration);
        };
    </script>
</head>

<body>
    <div class="loader"></div>
    <div class="loading-text">Loading...</div>
</body>

</html>