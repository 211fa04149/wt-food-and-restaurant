<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "root";
    $dbName = "reg";

    // Create a database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the username (registration number) from the form
    $username = $_POST["username"];

    // Check if the username exists in your database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, you can implement your password reset logic here
        // Generate a new password and update it in the database
        $newPassword = generateRandomPassword(); // Implement this function
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update the user's password
        $updateSql = "UPDATE users SET password = '$hashedPassword' WHERE username = '$username'";
        if ($conn->query($updateSql) === TRUE) {
            // Password reset successful, you can send the new password to the user's email
            $successMessage = "Password reset successful. New password:    " . $newPassword;
            $successMessage1 ="You will be redirected to Login page Shortly!! ";
            echo '<script type="text/javascript">
           setTimeout(function () {
               window.location.href = "login.html";
           }, 3000); // Redirect after 3 seconds
          </script>';
        } else {
            $errorMessage = "Error updating password: " . $conn->error;
        }
    } else {
        $errorMessage = "User not found. Please check your username.";
    }

    // Close the database connection
    $conn->close();
}

function generateRandomPassword() {
    // Implement your password generation logic here
    // For simplicity, you can use a random string or any other method
    return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 8);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        /* Add your CSS styles here */
        .success-message {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
            
        }
        .success-message1 {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
        .error-message {
            background-color: #F44336;
            color: white;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($successMessage)) {
            // Display the success message with CSS styles
            echo '<div class="success-message">' . $successMessage . '</div>';
            echo'You will be redirected to Login page Shortly!!';
        } 
        elseif (isset($errorMessage)) {
            // Display the error message with CSS styles
            echo '<div class="error-message">' . $errorMessage . '</div>';
        }
        ?>
    </div>
</body>
</html>