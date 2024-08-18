<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "food";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form
    $email = $_POST['Email'];
    $password = $_POST['password'];

    // Sanitize user input (prevent SQL injection)
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);

    // Query to check if the user exists in the database
    $sql = "SELECT * FROM signup1 WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $stored_password = $row['password'];
            
            // Verify the password
            if (($password == $stored_password)) {
                // Authentication successful
                //echo "Authentication verified";
                $_SESSION['userName'] = $row['name'];
                $_SESSION['userPassword'] = $row['password'];
                echo '<script type="text/javascript">';
                echo 'alert("Succesfully logged in!");';
                echo 'window.location.href = "home.html";'; 
                echo '</script>';
                exit();
            } else {
                echo '<script type="text/javascript">';
                echo 'alert("Invalid Password!");';
                echo 'window.history.back();'; // Redirect to another_page
                echo '</script>';
               exit;
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'alert("User Not Found!");';
            echo 'window.history.back();'; // Redirect to another_page
            echo '</script>';
           exit;
        }
    } else {
        echo "Database error: " . mysqli_error($conn);
    }
}
$conn->close();
?>