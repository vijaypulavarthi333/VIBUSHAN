<?php
include 'dbconnection.php'; // Include database connection file

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm-password"];
    $authCode = $_POST["auth-code"];

    // Check if authentication code is correct
    if ($authCode != '464646') {
        // Authentication code is incorrect
        echo "Authentication code is incorrect. Please try again.";
        exit(); // Exit PHP script
    }

    // Check if password and confirm password match
    if ($password != $confirmPassword) {
        // Passwords don't match
        echo "Passwords do not match. Please try again.";
        exit(); // Exit PHP script
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Escape variables to prevent SQL injection
    $email = $conn->real_escape_string($email);

    // Perform database operation to save manager email and hashed password
    // Construct the SQL query with escaped variables
    $sql = "INSERT INTO manager_vibushan (email, password) VALUES ('$email', '$hashedPassword')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        echo "Manager registered successfully!";
        sleep(5);
        header("Location: manager_sigin_reg.html");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    // Close connection
    $conn->close();
} else {
    // If form is not submitted, redirect to registration page
    header("Location: manager_register_page.html");
    exit(); // Exit PHP script
}

?>
