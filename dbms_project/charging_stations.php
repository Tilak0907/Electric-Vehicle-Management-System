<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nearby EV Charging Stations</title>
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

        h1 {
            font-size: 36px;
            color: #fff;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        }

        button {
            padding: 12px 25px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            transition: transform 0.3s ease, background-color 0.3s ease;
            margin-bottom: 30px;
        }

        button:hover {
            background-color: #0056b3;
            transform: translateY(-3px);
        }

        /* Stations List Container */
        #stations-list {
            width: 80%;
            padding: 20px;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.2); /* Semi-transparent white */
            backdrop-filter: blur(10px); /* Frosted glass effect */
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
            overflow-y: auto;
            max-height: 70vh;
            color: #fff;
        }

        /* Station Card */
        .station {
            padding: 20px;
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.1); /* Slight transparency */
            backdrop-filter: blur(8px); /* Frosted effect */
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: left;
        }

        .station h3 {
            font-size: 22px;
            color: #fff;
            margin-bottom: 10px;
        }

        .station p {
            font-size: 16px;
            color: #ccc;
            margin: 5px 0;
        }

        .station p strong {
            color: #007bff;
        }

        .no-stations {
            font-size: 18px;
            color: #ff6f61;
            margin-top: 20px;
        }

        .loading {
            font-size: 18px;
            color: #007bff;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            #stations-list {
                width: 95%;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <h1>Find Nearby EV Charging Stations</h1>
    <button onclick="getLocation()">Get Nearby Stations</button>

    <div id="stations-list"></div>

    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLon = position.coords.longitude;
                    
                    // Send the latitude and longitude to PHP to fetch the data
                    fetch('get_stations.php?lat=' + userLat + '&lon=' + userLon)
                        .then(response => response.json())
                        .then(data => displayStations(data))
                        .catch(error => console.error('Error:', error));
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function displayStations(stations) {
            const stationsList = document.getElementById('stations-list');
            stationsList.innerHTML = ''; // Clear any existing data

            if (stations.length === 0) {
                stationsList.innerHTML = "<div class='no-stations'>No stations found nearby.</div>";
            } else {
                stations.forEach(station => {
                    const stationDiv = document.createElement('div');
                    stationDiv.classList.add('station');
                    stationDiv.innerHTML = `
                        <h3>${station.name}</h3>
                        <p><strong>Location:</strong> ${station.location}</p>
                        <p><strong>Number of Chargers:</strong> ${station.no_of_chargers}</p>
                        <p><strong>Charging Speed:</strong> ${station.charging_speed}</p>
                        <p><strong>Distance:</strong> ${station.distance.toFixed(2)} km</p>
                    `;
                    stationsList.appendChild(stationDiv);
                });
            }
        }
    </script>

</body>
</html>
