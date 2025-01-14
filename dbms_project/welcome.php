<?php
// Start session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: index.php"); // Redirect to the registration/login page if not logged in
    exit();
}

$username = $_SESSION['username']; // Retrieve the username from session
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="styles/welcome.css">
</head>
<body>
    <style>
        /* Global Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: url('https://static.vecteezy.com/system/resources/previews/022/693/300/non_2x/electric-car-charging-at-the-charging-station-electric-vehicle-concept-illustration-vector.jpg');
            background-size: cover;
            background-position: center center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        /* Header Styles */
        h1 {
            color: #fff;
            font-size: 36px;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        /* Welcome Card with Glassmorphism */
        .welcome-container {
            background: rgba(255, 255, 255, 0.1); /* Semi-transparent white */
            backdrop-filter: blur(10px); /* Frosted glass effect */
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2); /* Soft shadow for 3D effect */
            text-align: center;
            width: 350px;
            transition: transform 0.3s ease-in-out; /* Smooth scale transition */
            margin-bottom: 20px;
        }

        .welcome-container:hover {
            transform: scale(1.03); /* Slightly enlarge the card on hover */
        }

        /* Button Styles */
        button {
            display: inline-block;
            padding: 12px 25px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            margin: 10px 0;
            transition: transform 0.3s ease, box-shadow 0.3s ease-in-out;
        }

        /* Button Backgrounds */
        button.add-vehicle-btn {
            background-color: #007bff;
            color: white;
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3); /* Soft shadow */
        }

        button.view-vehicles-btn {
            background-color: #28a745;
            color: white;
            box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3); /* Soft shadow */
        }

        button.find-charging-btn {
            background-color: #ffc107;
            color: white;
            box-shadow: 0 4px 8px rgba(255, 193, 7, 0.3); /* Soft shadow */
        }

        /* Hover Effect for Buttons */
        button:hover {
            transform: translateY(-3px); /* Slightly raise the button on hover */
        }

        /* Logout Button */
        .logout-btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #ff4d4d;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            transition: background-color 0.3s, transform 0.3s;
            margin-top: 20px;
            cursor: pointer;
            text-align: center;
        }

        /* Hover Effects for Logout Button */
        .logout-btn:hover {
            background-color: #e60000;
            transform: translateY(-3px); /* Slightly raise the button when hovered */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .welcome-container {
                width: 90%; /* Reduce width for smaller screens */
                padding: 20px 30px;
            }

            button {
                width: 100%;
            }
        }
    </style>
    
    <h1>Ev Vehicle Management System</h1> <!-- Heading added -->
    <div class="welcome-container">
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <button class="add-vehicle-btn" onclick="window.location.href='add_vehicle.php'">Add Vehicle</button>
        <button class="view-vehicles-btn" onclick="window.location.href='view_vehicles.php'">Vehicle Details</button>
        <button class="find-charging-btn" onclick="window.location.href='charging_stations.php';">Find Nearest Charging Stations</button>
    </div>
    <p>Thank you for registering. We're excited to have you on board!</p>
    <a href="logout.php" class="logout-btn">Logout</a>
</body>
</html>
