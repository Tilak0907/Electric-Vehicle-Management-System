<?php
// Start session
session_start();

// Include database connection

include('db_connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $username = $_POST['username'];
    $name = $_POST['name'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    // Handle profile picture upload
    $profile = $_FILES['profile']['name'];
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($profile);

    // Check if the email already exists
    $checkEmailQuery = "SELECT * FROM user_table WHERE email = '$email'";
    $result = $conn->query($checkEmailQuery);

    if ($result->num_rows > 0) {
        // Email already exists
        echo "<script>alert('Email already registered! Please use a different email.'); window.location.href='index.php';</script>";
    } else {
        // Email does not exist, proceed with registration
        if (move_uploaded_file($_FILES['profile']['tmp_name'], $targetFile)) {
            // Insert data into the database
            $sql = "INSERT INTO user_table (username, name, password, email, phone_number, address, profile_picture)
                    VALUES ('$username', '$name', '$password', '$email', '$phone_number', '$address', '$targetFile')";

            if ($conn->query($sql) === TRUE) {
                // Set session variable and redirect
                $_SESSION['username'] = $username;
                header("Location: welcome.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Failed to upload profile picture.";
        }
    }
}

$conn->close();
?>
