<?php
include 'connection.php'; // Include the connection script

// Function to validate email using regex
function validateEmail($email) {
    // Regular expression pattern for email validation
    $pattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    // Check if the email matches the pattern
    return preg_match($pattern, $email);
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['signup'])) {
    // Retrieve form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email
    if (!validateEmail($email)) {
        echo '<div class="error-popup">Invalid email address. Please enter a valid email.</div>';
    } else {
        // Check if email already exists
        $sql_check_email = "SELECT * FROM users WHERE email='$email'";
        $result_check_email = $conn->query($sql_check_email);
        if ($result_check_email->num_rows > 0) {
            echo '<div id="error-popup" class="popup">Email already exists. Please choose a different email.<span class="close" onclick="closePopup(\'error-popup\')">&times;</span></div>';
        } else {
            // Insert user data into the database
            $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
            if ($conn->query($sql) === TRUE) {
                echo '<div class="success-popup">New record created successfully</div>';
            } else {
                echo '<div class="error-popup">Error: ' . $sql . '<br>' . $conn->error . '</div>';
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Signup</title>
</head>

<body>
    <div class="card">
        <h2>Signup</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="input-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" name="signup" class="btn-signup">Signup</button>
        </form>
        <p>Already have an account? <a href="index.php">Login</a></p>
    </div>
    <script>
        // Function to close popup
        function closePopup(id) {
            document.getElementById(id).style.display = "none";
        }
    </script>
</body>

</html>