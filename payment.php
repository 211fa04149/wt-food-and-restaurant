<?php
        if (isset($_POST['submitPayment'])) {
            // Validate and process payment
            // Your payment processing logic here
            //$username=$_SESSION['username'];
            //$qry="INSERT INTO courses (username, course_img, course_name, instructor_name, instructor_qual, course_fee)
            //VALUES ('$username', 'https://example.com/image.jpg', 'Web Development', 'John Instructor', 'M.Sc. in Computer Science', '$299');
            //";
            // Print success message
            echo "<p class='success-message'>Payment Successful</p>";

            // Redirect to home1.php after a brief delay (you can adjust the delay)
            echo "<script>
                    setTimeout(function() {
                        window.location.href = 'home.html';
                    }, 2000); // 2000 milliseconds (2 seconds) delay
                  </script>";
        }
        ?>