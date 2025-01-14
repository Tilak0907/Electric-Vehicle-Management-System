<?php
// Include database connection
include('db_connection.php');

// Fetch vehicle details
$vehicle_query = "SELECT vehicle_id, model, vehicle_range FROM vehicle_table";
$vehicle_result = $conn->query($vehicle_query);

// Fetch charging station details
$station_query = "SELECT StationId, StationName FROM charging_station";
$station_result = $conn->query($station_query);

// Initialize variables
$selected_vehicle = '';
$selected_station = '';
$required_charge = '';
$user_price_per_unit = '';
$success_message = '';
$total_cost = '';
$total_energy_consumed = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_vehicle = $_POST['vehicle_id'];
    $selected_station = $_POST['station_id'];
    $required_charge = $_POST['required_charge'];
    $user_price_per_unit = $_POST['price_per_unit'];

    // Validate selected station exists
    $station_check_query = "SELECT StationId FROM charging_station WHERE StationId = ?";
    $station_check_stmt = $conn->prepare($station_check_query);
    $station_check_stmt->bind_param("i", $selected_station);
    $station_check_stmt->execute();
    $station_check_result = $station_check_stmt->get_result();

    if ($station_check_result->num_rows > 0) {
        // Fetch vehicle range
        $vehicle_query = "SELECT vehicle_range FROM vehicle_table WHERE vehicle_id = ?";
        $vehicle_stmt = $conn->prepare($vehicle_query);
        $vehicle_stmt->bind_param("i", $selected_vehicle);

        if ($vehicle_stmt->execute()) {
            $vehicle_result = $vehicle_stmt->get_result()->fetch_assoc();

            if ($vehicle_result) {
                $vehicle_range = $vehicle_result['vehicle_range'];

                // Calculate total energy consumption and cost
                $total_energy_consumed = ($required_charge / 100) * $vehicle_range;
                $total_cost = $total_energy_consumed * $user_price_per_unit;

                // Insert the result into the price_calculator table without displaying it
                $insert_query = "INSERT INTO price_calculator (StationId, price_per_unit, total_cost, total_energy_consumed) VALUES (?, ?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_query);
                $insert_stmt->bind_param("iddd", $selected_station, $user_price_per_unit, $total_cost, $total_energy_consumed);

                if ($insert_stmt->execute()) {
                    $success_message = "Price calculation saved successfully!";
                } else {
                    $success_message = "Error inserting price data: " . $insert_stmt->error;
                }

                // Fetch the last inserted price calculation from price_calculator
                $last_inserted_query = "SELECT total_cost, total_energy_consumed FROM price_calculator ORDER BY id DESC LIMIT 1";
                $result = $conn->query($last_inserted_query);

                if ($result && $row = $result->fetch_assoc()) {
                    $total_cost = $row['total_cost'];
                    $total_energy_consumed = $row['total_energy_consumed'];
                }
            } else {
                $success_message = "Vehicle not found!";
            }
        } else {
            $success_message = "Error fetching vehicle data: " . $vehicle_stmt->error;
        }
    } else {
        $success_message = "Error: Selected charging station does not exist.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charging Price Calculator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: url('https://static.vecteezy.com/system/resources/previews/022/693/300/non_2x/electric-car-charging-at-the-charging-station-electric-vehicle-concept-illustration-vector.jpg');
            background-size: cover;
            background-position: center center;
        }

        .container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        select, input {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button {
            width: 90%;
            padding: 10px;
            border: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .message {
            margin-top: 20px;
            font-size: 18px;
            color: green;
        }

        .error-message {
            margin-top: 20px;
            font-size: 16px;
            color: red;
        }

        .result-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Charging Price Calculator</h1>

    <!-- Form container -->
    <form method="POST">
        <select name="vehicle_id" required>
            <option value="">Select Vehicle</option>
            <?php while ($row = $vehicle_result->fetch_assoc()): ?>
                <option value="<?php echo $row['vehicle_id']; ?>" <?php echo $selected_vehicle == $row['vehicle_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($row['model']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <select name="station_id" required>
            <option value="">Select Charging Station</option>
            <?php while ($row = $station_result->fetch_assoc()): ?>
                <option value="<?php echo $row['StationId']; ?>" <?php echo $selected_station == $row['StationId'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($row['StationName']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="number" name="required_charge" placeholder="Enter Required Charge (%)" value="<?php echo htmlspecialchars($required_charge); ?>" min="0" max="100" required>
        <input type="number" step="0.01" name="price_per_unit" placeholder="Enter Price Per Unit (₹)" value="<?php echo htmlspecialchars($user_price_per_unit); ?>" required>

        <button type="submit">Calculate Price</button>
    </form>

    <!-- Success or error message -->
    <?php if ($success_message !== ''): ?>
        <div class="message">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($success_message) && strpos($success_message, 'Error') !== false): ?>
        <div class="error-message">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>

    <!-- Display calculated price if available -->
    <?php if ($total_cost !== '' && $total_energy_consumed !== ''): ?>
        <div class="result-container">
            <p><strong>Total Energy Consumed:</strong> <?php echo round($total_energy_consumed, 2); ?> kWh</p>
            <p><strong>Total Cost:</strong> ₹<?php echo round($total_cost, 2); ?></p>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
