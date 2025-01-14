<?php
// Include database connection
include('db_connection.php');

// Initialize variables
$error_message = "";
$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $review_text = $_POST['review_text'];
    $rating = $_POST['rating'];

    // Validate inputs
    if (!empty($user_id) && !empty($vehicle_id) && !empty($review_text) && !empty($rating)) {
        // Insert the review into the database
        $query = "INSERT INTO review_table (user_id, vehicle_id, review_text, rating) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iisi", $user_id, $vehicle_id, $review_text, $rating);

        if ($stmt->execute()) {
            $success_message = "Review added successfully!";
        } else {
            $error_message = "Error adding review: " . $stmt->error;
        }
    } else {
        $error_message = "All fields are required.";
    }
}

// Fetch existing reviews
$review_query = "
    SELECT r.review_text, r.rating, r.review_date, u.username, v.model 
    FROM review_table r
    JOIN user_table u ON r.user_id = u.id
    JOIN vehicle_table v ON r.vehicle_id = v.vehicle_id
    ORDER BY r.review_date DESC
";
$review_result = $conn->query($review_query);

if (!$review_result) {
    die("Error in review query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reviews</title>
    <style>
        /* Add your styles here */
        /* Reset some basic styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Body and container styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f7fa;
    color: #333;
    padding: 20px;
    background: url('https://static.vecteezy.com/system/resources/previews/022/693/300/non_2x/electric-car-charging-at-the-charging-station-electric-vehicle-concept-illustration-vector.jpg');
            background-size: cover;
            background-position: center center;
}

.container {
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

/* Heading Styles */
h1, h2 {
    color: #2c3e50;
    font-size: 2rem;
    margin-bottom: 20px;
}

/* Message styling */
.message {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 5px;
    font-weight: bold;
}

.message.error {
    background-color: #e74c3c;
    color: #fff;
}

.message.success {
    background-color: #2ecc71;
    color: #fff;
}

/* Form styling */
form {
    margin-bottom: 30px;
}

.form-group {
    margin-bottom: 15px;
}

label {
    display: block;
    font-size: 1.1rem;
    margin-bottom: 8px;
    color: #34495e;
}

select, textarea, input[type="number"] {
    width: 100%;
    padding: 10px;
    font-size: 1rem;
    border: 1px solid #ccc;
    border-radius: 5px;
    outline: none;
    margin-bottom: 10px;
}

select:focus, textarea:focus, input[type="number"]:focus {
    border-color: #3498db;
}

textarea {
    resize: vertical;
    min-height: 100px;
}

/* Submit button styling */
button[type="submit"] {
    background-color: #3498db;
    color: #fff;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    font-size: 1.1rem;
    cursor: pointer;
    width: 100%;
    transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
    background-color: #2980b9;
}

/* Review section styles */
.review {
    background-color: #ecf0f1;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.review h3 {
    font-size: 1.4rem;
    color: #2c3e50;
    margin-bottom: 10px;
}

.review p {
    font-size: 1rem;
    color: #7f8c8d;
    line-height: 1.6;
    margin-bottom: 10px;
}

.review small {
    font-size: 0.9rem;
    color: #95a5a6;
}

/* Responsive styling */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    h1, h2 {
        font-size: 1.5rem;
    }

    button[type="submit"] {
        font-size: 1rem;
    }
}

    </style>
</head>
<body>
<div class="container">
    <h1>Reviews</h1>

    <?php if ($error_message): ?>
        <div class="message error"> <?php echo $error_message; ?> </div>
    <?php endif; ?>

    <?php if ($success_message): ?>
        <div class="message success"> <?php echo $success_message; ?> </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label for="user_id">User</label>
            <select name="user_id" id="user_id" required>
                <option value="">Select User</option>
                <?php
                $user_query = "SELECT id, username FROM user_table";
                $user_result = $conn->query($user_query);

                if (!$user_result) {
                    die("Error in user query: " . $conn->error);
                }

                while ($user = $user_result->fetch_assoc()): ?>
                    <option value="<?php echo $user['id']; ?>"> <?php echo htmlspecialchars($user['username']); ?> </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="vehicle_id">Vehicle</label>
            <select name="vehicle_id" id="vehicle_id" required>
                <option value="">Select Vehicle</option>
                <?php
                $vehicle_query = "SELECT vehicle_id, model FROM vehicle_table";
                $vehicle_result = $conn->query($vehicle_query);

                if (!$vehicle_result) {
                    die("Error in vehicle query: " . $conn->error);
                }

                while ($vehicle = $vehicle_result->fetch_assoc()): ?>
                    <option value="<?php echo $vehicle['vehicle_id']; ?>"> <?php echo htmlspecialchars($vehicle['model']); ?> </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="review_text">Review</label>
            <textarea name="review_text" id="review_text" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="rating">Rating</label>
            <input type="number" name="rating" id="rating" min="1" max="5" required>
        </div>

        <button type="submit">Submit Review</button>
    </form>

    <h2>All Reviews</h2>
    <?php if ($review_result && $review_result->num_rows > 0): ?>
        <?php while ($review = $review_result->fetch_assoc()): ?>
            <div class="review">
                <h3><?php echo htmlspecialchars($review['username']); ?> - <?php echo htmlspecialchars($review['model']); ?></h3>
                <p><?php echo htmlspecialchars($review['review_text']); ?></p>
                <small>Rating: <?php echo $review['rating']; ?> | Date: <?php echo $review['review_date']; ?></small>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No reviews yet.</p>
    <?php endif; ?>
</div>
</body>
</html>
