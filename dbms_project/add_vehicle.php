<?php
session_start(); // Start session to access session variables
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
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

        /* Heading Styles */
        h1 {
            color: #fff;
            font-size: 36px;
            text-align: center;
            margin-bottom: 30px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        /* Add Vehicle Form Container with Glassmorphism */
        .form-container {
            background: rgba(255, 255, 255, 0.1); /* Semi-transparent white */
            backdrop-filter: blur(10px); /* Frosted glass effect */
            padding: 30px 40px;
            border-radius: 15px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2); /* Soft shadow */
            text-align: center;
            width: 700px;
            transition: transform 0.3s ease-in-out;
        }



        h3 {
            color: #fff;
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* Input and Label Styles */
        input, select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.5); /* Slight white background for inputs */
        }

        label {
            color: #fff;
            font-size: 16px;
            margin-bottom: 8px;
            display: block;
        }

        /* Button Styles */
        button {
            padding: 12px 25px;
            width: 100%;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            transition: transform 0.3s ease, box-shadow 0.3s ease-in-out;
        }



        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                width: 90%; /* Reduce width for smaller screens */
                padding: 20px 30px;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <h1>Ev Vehicle Management System</h1> <!-- Heading added -->

    <div class="form-container">
        <form action="add_vehicle_handler.php" method="POST">
            <h3>Add Vehicle</h3>
            <label for="make">Make</label>
            <input type="text" name="make" id="make" required>

            <label for="model">Model</label>
            <input type="text" name="model" id="model" required>

            <label for="year">Year</label>
            <input type="number" name="year" id="year" required>

            <label for="battery_capacity">Battery Capacity (kWh)</label>
            <input type="number" name="battery_capacity" id="battery_capacity" step="0.01" required>

            <label for="range">Range (km)</label>
            <input type="number" name="range" id="range" required>

            <label for="price">Price (USD)</label>
            <input type="number" name="price" id="price" step="0.01" required>

            <button type="submit">Add Vehicle</button>
        </form>
    </div>
    
</body>
</html>
