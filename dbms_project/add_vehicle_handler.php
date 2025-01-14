<?php
session_start();

include('db_connection.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input data
    $make = filter_var($_POST['make'], FILTER_SANITIZE_STRING);
    $model = filter_var($_POST['model'], FILTER_SANITIZE_STRING);
    $year = filter_var($_POST['year'], FILTER_VALIDATE_INT);
    $battery_capacity = filter_var($_POST['battery_capacity'], FILTER_VALIDATE_FLOAT);
    $range = filter_var($_POST['range'], FILTER_VALIDATE_FLOAT);
    $price = filter_var($_POST['price'], FILTER_VALIDATE_FLOAT);

    if (empty($make) || empty($model) || empty($year) || empty($battery_capacity) || empty($range) || empty($price)) {
        echo "<script>alert('Please fill in all required fields.'); window.location.href='add_vehicle.php';</script>";
        exit();
    }

    // Fetch user_id using parameterized query
    $sql = "SELECT user_id FROM user_table WHERE username = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        if (empty($user_id)) {
            echo "<script>alert('User not found. Please provide a valid username.'); window.location.href='add_vehicle.php';</script>";
            exit();
        }

        // Insert vehicle details using parameterized query
        $sql1 = "INSERT INTO vehicle_table (Vuser_id, make, model, year, battery_capacity, vehicle_range, price) VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql1)) {
            $stmt->bind_param("issiidd", $user_id, $make, $model, $year, $battery_capacity, $range, $price);

            try {
                $stmt->execute();
                echo "<script>alert('Vehicle added successfully!'); window.location.href='welcome.php';</script>";
            } catch (Exception $e) {
                // Log the error and display a user-friendly message
                error_log("Error adding vehicle: " . $e->getMessage());
                echo "<script>alert('An error occurred while adding the vehicle. Please try again later.'); window.location.href='add_vehicle.php';</script>";
            }

            $stmt->close();
        } else {
            echo "Error preparing query: " . $conn->error;
        }
    } else {
        echo "Error preparing query: " . $conn->error;
    }
}

$conn->close();
?>