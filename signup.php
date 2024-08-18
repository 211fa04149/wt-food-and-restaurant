<?php
// Database connection settings
$conn = new mysqli('localhost', 'root', 'root', 'food');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the user input
$username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_STRING);
$email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
$password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);

// Check if the email already exists
$sql = "SELECT * FROM signup1 WHERE email = '$email'";
$result = $conn->query($sql);

// If the email already exists, display an alert message and move to the login page
if ($result->num_rows > 0) {
    echo "<script>alert('This email is already signed up. Please log in.'); window.location.href = 'signin.php';</script>";
    exit();
}

// Hash the password
//$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO signup1 (username, email, password) VALUES (?, ?, ?)");

// Check if the prepare() was successful
if ($stmt) {
    // Bind the parameters
    $stmt->bind_param("sss", $username, $email, $password);

    // Execute the SQL statement
    if ($stmt->execute()) {
        // Registration successful, set a session variable
        session_start();
        $_SESSION['username'] = $username;

        // Redirect the user to another page after registration
        header("Location: login1.html");
        exit();
    } else {
        // Registration failed
        echo "Registration failed. Please try again later.";
    }

    // Close the prepared statement
    $stmt->close();
} else {
    // Handle prepare error
    echo "Prepare statement failed. Please try again later.";
}

// Close the database connection
$conn->close();
?>