<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driving Modes for EV Vehicles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }

        .container {
            margin-top: 30px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #007BFF;
        }

        .mode {
            margin-bottom: 20px;
        }

        .mode-title {
            font-weight: bold;
            font-size: 1.5rem;
            color: #333;
        }

        .mode-description {
            margin-top: 10px;
            color: #555;
        }

        .icon {
            font-size: 2rem;
            color: #007BFF;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Driving Modes for EV Vehicles</h1>

        <div class="mode">
            <div class="d-flex align-items-center">
                <span class="icon">&#128663;</span>
                <span class="mode-title">Eco Mode</span>
            </div>
            <p class="mode-description">
                Designed to maximize energy efficiency, Eco Mode reduces power output and limits acceleration, making it ideal for city driving and extending the range of the vehicle.
            </p>
        </div>

        <div class="mode">
            <div class="d-flex align-items-center">
                <span class="icon">&#128640;</span>
                <span class="mode-title">Sport Mode</span>
            </div>
            <p class="mode-description">
                Optimized for performance, Sport Mode provides faster acceleration and enhanced responsiveness, perfect for highway driving and thrilling experiences.
            </p>
        </div>

        <div class="mode">
            <div class="d-flex align-items-center">
                <span class="icon">&#127809;</span>
                <span class="mode-title">Comfort Mode</span>
            </div>
            <p class="mode-description">
                Ensures a smooth and relaxed driving experience by balancing performance and efficiency, suitable for daily commutes and long journeys.
            </p>
        </div>

        <div class="mode">
            <div class="d-flex align-items-center">
                <span class="icon">&#9889;</span>
                <span class="mode-title">Performance Mode</span>
            </div>
            <p class="mode-description">
                Delivers maximum power and torque for high-speed driving and challenging road conditions, making it the best choice for enthusiasts.
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
