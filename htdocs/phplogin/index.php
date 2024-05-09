<?php
session_start();

// Check if session exists
if(isset($_SESSION['email']) && isset($_SESSION['login_time'])) {
    // Redirect to welcome.php
    header("Location: welcome.php");
    exit();
}

include 'connection.php'; // Include the connection script

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the user credentials
    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        // Start the session
        session_start();
        // Store user data and login time in session variables
        $_SESSION['email'] = $email;
        $_SESSION['login_time'] = time();
        // Redirect to welcome.php
        header("Location: welcome.php");
        exit();
    } else {
        // Login failed
        // Display error message
        echo '<div id="error-popup" class="popup">Invalid email or password. Please try again.<span class="close" onclick="closePopup(\'error-popup\')">&times;</span></div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Login</title>
</head>
<body>
    <div class="card">
        <h2>Login</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" name="login" class="btn-login">Login</button>
        </form>
        <p>Don't have an account? <a href="signup.php">Signup</a></p>
    </div>

    <script>
        // Function to close popup
        function closePopup(id) {
            document.getElementById(id).style.display = "none";
        }
    </script>
</body>
</html>
