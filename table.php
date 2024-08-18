<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "food6";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['book'])) {
        $name = $_POST['fname'];
        $phone = $_POST['pnum'];
        $date = $_POST['date'];
        $email = $_POST['mail'];
        $time = $_POST['time'];
        $period = $_POST['period'];
        $people = $_POST['people'];
        $reservationId = uniqid('id');
        $indianTime = date("h:i A", strtotime($time));

        if (!empty($name) && !empty($people) && !empty($email) && !is_numeric($email)) {
            $query = "INSERT INTO book (fname, pnum, date, mail, time, period, people) 
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssssi", $fname, $pphone, $date, $email, $time, $period, $people);
            $stmt->execute();
            $stmt->close();
             echo '<script type="text/javascript">';
                echo 'alert("Booking successfull!");';
                echo 'window.location.href = "order.html";'; 
                echo '</script>';
                exit();
          
        } else {
            echo "<script type='text/javascript'> alert('Please Enter Valid Information')</script>";
        }
    }

    if (isset($_POST['cancel'])) {
        $reservationId = $_POST['fname'];
        $query = "DELETE FROM book WHERE fname = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $reservationId);
        $stmt->execute();
        $stmt->close();
       
        echo "<script type='text/javascript'> alert('Reservation cancelled')</script>";
    }
}

// Close the connection
$conn->close();
?>