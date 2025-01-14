<?php
// Start the session to access session variables
session_start();

// Include database connection
include('db_connection.php'); // Replace with your actual DB connection code

// Check if the username exists in the session
if (!isset($_SESSION['username'])) {
    die("User not logged in. Please log in first."); // Handle case if user is not logged in
}

// Fetch the username from the session
$username = $_SESSION['username'];

// Debugging line to check session username
echo "Username from session: " . $username;

// Fetch charging history for the specified user
$query = "
    SELECT ch.*, u.username
    FROM charging_history2 ch
    JOIN user_table u ON ch.username = u.username
    WHERE u.username = ? 
    ORDER BY ch.date_time DESC
";

// Prepare the statement to prevent SQL injection
$stmt = $conn->prepare($query);

if ($stmt) {
    // Bind the username parameter to the query
    $stmt->bind_param("s", $username);
    
    // Execute the query
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        echo "Number of rows returned: " . $result->num_rows; // Debugging line to check row count
    } else {
        die("Query Execution Error: " . $stmt->error); // Debugging line to print error
    }
} else {
    die("Statement Preparation Error: " . $conn->error); // Stop script if statement fails
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Charging History</title>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 60px;
            background: url('https://static.vecteezy.com/system/resources/previews/022/693/300/non_2x/electric-car-charging-at-the-charging-station-electric-vehicle-concept-illustration-vector.jpg');
            background-size: cover;
            background-position: center center;
        

            
        }

        /* Header */
        h1 {
            color: white;
            margin-bottom: 20px;
        }

        /* Table Styles */
        table {
            width: 80%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f1f1f1;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* No History Message */
        .no-history {
            color: white;
            font-size: 18px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h1>Charging History</h1>

    <?php if (isset($result) && $result->num_rows > 0): ?>
        <!-- Table for displaying history -->
        <table>
            <thead>
                <tr>
                    <th>Date & Time</th>
                    <th>Station Name</th>
                    <th>Total Cost (₹)</th>
                    <th>Electricity Consumed (kWh)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo date('d M Y, H:i', strtotime($row['date_time'])); ?></td>
                        <td><?php echo htmlspecialchars($row['station_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_cost']); ?></td>
                        <td><?php echo htmlspecialchars($row['energy_consumed']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-history">No charging history available for this user.</div>
    <?php endif; ?>

</body>
</html>
