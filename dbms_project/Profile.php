<?php
// Include database connection
include('db_connection.php'); // Replace with your actual DB connection code

// Start session to get logged-in user details (or hardcode for testing)
session_start();
// Assuming a session key stores the logged-in user's username
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'test_user'; // Default for testing

// Fetch user details
$query = "SELECT * FROM user_table WHERE username = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param("s", $username);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
    } else {
        die("Query Execution Error: " . $stmt->error);
    }
} else {
    die("Statement Preparation Error: " . $conn->error);
}

// If no user found, display an error
if (!$user) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .profile-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            padding: 20px;
            text-align: center;
        }

        .profile-container h1 {
            color: #333;
            margin-bottom: 10px;
        }

        .profile-container p {
            margin: 10px 0;
            color: #555;
        }

        .profile-container .label {
            font-weight: bold;
        }

        .profile-container a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            text-decoration: none;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .profile-container a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="profile-container">
    <p><span class="label">Username:</span> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><span class="label">Email:</span> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><span class="label">Phone:</span> <?php echo htmlspecialchars($user['phone']); ?></p>
    <p><span class="label">Address:</span> <?php echo htmlspecialchars($user['address']); ?></p>
    <a href="edit_profile.php">Edit Profile</a>
</div>

</body>
</html>
