<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Server-side validations
    if (empty($username) || empty($password)) {
        echo "Please enter both username and password.";
    } elseif (!preg_match('/^[0-9]/', $username)) {
        echo "Username must start with a digit.";
    } elseif (strlen($username) < 10) {
        echo "Username must contain at least 10 digits.";
    } elseif (empty($password)) {
        echo "Please enter your password.";
    } elseif ((strlen($password) < 5) || (strlen($password) > 15)) {
        echo "Password must be 5 to 15 characters only.";
    } elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password)) {
        echo "Password must contain at least one uppercase letter, one lowercase letter, and one digit.";
    } elseif (preg_match('/[;.:]/', $password)) {
        echo "Password cannot contain the symbols ; . :";
    } else {
        // Database connection details
        $db_host = "localhost"; // Replace with your database host
        $db_username = "root"; // Replace with your database username
        $db_password = "root"; // Replace with your database password
        $db_name = "reg"; // Replace with your database name

        // Create a database connection
        $conn = new mysqli($db_host, $db_username, $db_password, $db_name);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL statement to check the credentials
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "Login successful!";
             header("Location: home.html");
        } else {
            echo "Invalid username or password. You need to Register First!!";
        }

        $stmt->close();
        $conn->close();
    }
}
?>