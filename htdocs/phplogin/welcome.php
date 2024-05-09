<?php
session_start();

// Check if session exists
if(!isset($_SESSION['email']) || !isset($_SESSION['login_time'])) {
    // Redirect to login page if session does not exist
    header("Location: index.php");
    exit();
}

// Check if session has expired (1 minute)
$timeout =360; // 1 minute in seconds
$current_time = time();
$login_time = $_SESSION['login_time'];
$elapsed_time = $current_time - $login_time;

if($elapsed_time >= $timeout) {
    // Session has expired, destroy session and redirect to login page
    session_unset();
    session_destroy();
    header("Location: index.php?timeout=1");
    exit();
}

// Calculate remaining session time
$remaining_time = $timeout - $elapsed_time;

// Display login successful message
$welcome_message = "Welcome, ".$_SESSION['email']."!";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #333;
        }

        .success-message {
            color: #008000;
            font-weight: bold;
            margin-bottom: 20px;
        }

        #timer {
            color: #ff0000;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><?php echo $welcome_message; ?></h2>
        <p class="success-message">Login successful!</p>
        <p id="timer">Session will expire in <?php echo $remaining_time; ?> seconds.</p>
    </div>

    <script>
        // Function to update timer every second
        function updateTimer() {
            var timerElement = document.getElementById('timer');
            var remainingTime = <?php echo $remaining_time; ?>;
            
            var timerInterval = setInterval(function() {
                if (remainingTime > 0) {
                    timerElement.textContent = 'Session will expire in ' + remainingTime + ' seconds.';
                    remainingTime--;
                } else {
                    clearInterval(timerInterval);
                    // Redirect to logout page or perform logout action
                    window.location.href = 'index.php';
                }
            }, 1000);
        }

        // Call updateTimer function when page loads
        window.onload = function() {
            updateTimer();
        };
    </script>
</body>
</html>