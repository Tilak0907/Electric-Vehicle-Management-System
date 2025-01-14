<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "user_registration"; // Use your actual database name here

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user's latitude and longitude from the frontend
$user_lat = $_GET['lat'];
$user_lon = $_GET['lon'];

// Haversine formula to calculate distance between two points
function haversine($lat1, $lon1, $lat2, $lon2) {
    $R = 6371; // Earth radius in kilometers
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) +
         cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
         sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    return $R * $c; // Distance in kilometers
}

// Fetch all charging stations from the database
$sql = "SELECT * FROM ChargingStations";
$result = $conn->query($sql);

$stations = [];

if ($result->num_rows > 0) {
    // Fetch each station and calculate the distance
    while ($row = $result->fetch_assoc()) {
        $distance = haversine($user_lat, $user_lon, $row['lat'], $row['lon']);
        $stations[] = [
            'name' => $row['StationName'],
            'location' => $row['Location'],
            'no_of_chargers' => $row['NoOfChargers'],
            'charging_speed' => $row['ChargingSpeed'],
            'lat' => $row['lat'],
            'lon' => $row['lon'],
            'distance' => $distance
        ];
    }

    // Sort stations by distance
    usort($stations, function($a, $b) {
        return $a['distance'] <=> $b['distance'];
    });

    // Return data as JSON
    echo json_encode($stations);
} else {
    echo json_encode([]);
}

$conn->close();
?>
