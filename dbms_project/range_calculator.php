<?php
// Include database connection
include('db_connection.php'); // Replace with your actual DB connection code

// Fetch vehicle details for dropdown
$query = "SELECT vehicle_id, model, vehicle_range FROM vehicle_table";
$result = $conn->query($query);

if (!$result) {
    die("Error fetching vehicle data: " . $conn->error);
}

// Initialize variables for calculation
$selected_vehicle = '';
$vehicle_range = 0;
$charge_percentage = '';
$available_range = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_vehicle = $_POST['vehicle_id'];
    $charge_percentage = $_POST['charge_percentage'];

    // Fetch the selected vehicle range
    $vehicle_query = "SELECT vehicle_range FROM vehicle_table WHERE vehicle_id = ?";
    $stmt = $conn->prepare($vehicle_query);
    $stmt->bind_param("i", $selected_vehicle);

    if ($stmt->execute()) {
        $stmt_result = $stmt->get_result();
        $vehicle = $stmt_result->fetch_assoc();

        if ($vehicle) {
            $vehicle_range = $vehicle['vehicle_range'];
            // Calculate the available range
            $available_range = ($charge_percentage / 100) * $vehicle_range;

            // Insert the result into the range_calculator table
            $insert_query = "INSERT INTO range_calculator (vehicle_id, battery_level, estimated_range) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param("idd", $selected_vehicle, $vehicle_range, $available_range);

            if (!$insert_stmt->execute()) {
                echo "Error inserting range data: " . $insert_stmt->error;
            }
        } else {
            echo "Vehicle not found!";
        }
    } else {
        echo "Error fetching vehicle range: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Range Calculator</title>
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
            width: 400px;
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

        .result {
            margin-top: 20px;
            font-size: 18px;
            color: #333;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Range Calculator</h1>
    <form method="POST">
        <select name="vehicle_id" required>
            <option value="">Select Vehicle</option>
            <?php while ($row = $result->fetch_assoc()): ?>
                <option value="<?php echo $row['vehicle_id']; ?>" <?php echo $selected_vehicle == $row['vehicle_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($row['model']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <input type="number" name="charge_percentage" placeholder="Enter Charge Percentage" value="<?php echo htmlspecialchars($charge_percentage); ?>" min="0" max="100" required>

        <button type="submit">Calculate Range</button>
    </form>

    <?php if ($available_range !== ''): ?>
        <div class="result">
            <strong>Available Range:</strong> <?php echo round($available_range, 2); ?> km
        </div>
    <?php endif; ?>
</div>

</body>
</html>
