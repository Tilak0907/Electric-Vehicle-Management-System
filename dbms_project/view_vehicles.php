<?php
session_start();

include('db_connection.php');

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Please log in first.'); window.location.href='login.php';</script>";
    exit();
}

// Get the logged-in username from the session
$username = $_SESSION['username'];

// Fetch the user_id for the logged-in user from the user_table
$userQuery = "SELECT user_id FROM user_table WHERE username = ?";
if ($stmt = $conn->prepare($userQuery)) {
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();
}

// If no user_id is found, handle the error
if (!isset($user_id)) {
    echo "<script>alert('User not found. Please contact support.'); window.location.href='login.php';</script>";
    exit();
}

// Handle deletion
if (isset($_POST['delete_vehicle'])) {
    $vehicle_id = $_POST['vehicle_id'];
    $deleteQuery = "DELETE FROM vehicle_table WHERE vehicle_id = ? AND Vuser_id = ?";
    if ($stmt = $conn->prepare($deleteQuery)) {
        $stmt->bind_param("ii", $vehicle_id, $user_id);
        if ($stmt->execute()) {
            echo "<script>alert('Vehicle deleted successfully!');window.location.href='welcome.php';</script>";
        } else {
            echo "<script>alert('Failed to delete vehicle.');</script>";
        }
        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch the vehicle details for the logged-in user
$vehicleQuery = "SELECT vehicle_id, make, model, year, battery_capacity, vehicle_range, price FROM vehicle_table WHERE Vuser_id = ?";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
            color: #333;
        }

        .table-container {
            width: 90%;
            margin: 20px auto;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background-color: #0066cc;
            color: #fff;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tbody tr:hover {
            background-color: #f1f1f1;
        }

        td {
            font-size: 14px;
            color: #333;
        }

        form {
            display: inline-block;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        @media screen and (max-width: 768px) {
            table {
                font-size: 12px;
            }

            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <?php
    if ($stmt = $conn->prepare($vehicleQuery)) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h1>Vehicles for User: $username</h1>";
        echo "<div class='table-container'>";
        echo "<table>";
        echo "<thead>";
        echo "<tr><th>Make</th><th>Model</th><th>Year</th><th>Battery Capacity</th><th>Range</th><th>Price</th><th>Action</th></tr>";
        echo "</thead><tbody>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['make']}</td>
                    <td>{$row['model']}</td>
                    <td>{$row['year']}</td>
                    <td>{$row['battery_capacity']}</td>
                    <td>{$row['vehicle_range']}</td>
                    <td>{$row['price']}</td>
                    <td>
                        <form method='POST'>
                            <input type='hidden' name='vehicle_id' value='{$row['vehicle_id']}'>
                            <button type='submit' name='delete_vehicle' class='delete-btn'>Delete</button>
                        </form>
                    </td>
                  </tr>";
        }

        echo "</tbody></table>";
        echo "</div>";

        $stmt->close();
    } else {
        echo "Error: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
