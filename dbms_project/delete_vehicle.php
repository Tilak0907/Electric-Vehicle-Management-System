<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vehicle_id = $_POST['vehicle_id'];

    $sql = "DELETE FROM vehicle_table WHERE vehicle_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $vehicle_id);

    try {
        $stmt->execute();
        echo "<script>alert('Vehicle deleted successfully!'); window.location.href='view_vehicles.php';</script>";
    } catch (mysqli_sql_exception $e) {
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='view_vehicles.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
