<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="styles/indx.css">
</head>
<body>
    <style>
    /* Global Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    scale: 0.4em;
}

body {
    font-family: 'Roboto', sans-serif;
    background: url('https://static.vecteezy.com/system/resources/previews/022/693/300/non_2x/electric-car-charging-at-the-charging-station-electric-vehicle-concept-illustration-vector.jpg');
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

/* Container */
.container {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Form Container with Glassmorphism */
.form-container {
    background: rgba(255, 255, 255, 0.1); /* Semi-transparent white */
    backdrop-filter: blur(10px); /* Frosted glass effect */
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.2);
    width: 600px; /* One-third of the screen */
    min-width: 400px;
    max-width: 700px;
    color: #fff;
}

h1 {
    text-align: center;
    font-size: 32px;
    color: #007bff;
    margin-bottom: 30px;
}

/* Form Groups */
.form-group {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    justify-content: space-between;
}

.form-group label {
    font-size: 16px;
    color: #fff;
    width: 30%; /* Label width */
    text-align: right;
    padding-right: 20px;
}

.form-group input,
.form-group textarea {
    width: 65%; /* Adjust the width of the input */
    padding: 12px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f9f9f9;
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

/* Button Styles */
button {
    width: 100%;
    padding: 15px;
    font-size: 18px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #0056b3;
}

/* Login Link */
.login-link {
    text-align: center;
    margin-top: 20px;
    font-size: 14px;
}

.login-link a {
    color: #007bff;
    text-decoration: none;
}

.login-link a:hover {
    text-decoration: underline;
}
label{
    color:white;
}

/* Responsive Styles */
@media (max-width: 768px) {
    .form-container {
        padding: 20px;
        width: 90%;
        min-width: 300px;
    }

    h1 {
        font-size: 28px;
    }

    button {
        padding: 12px;
        font-size: 16px;
    }

    .form-group input,
    .form-group textarea {
        padding: 10px;
        font-size: 14px;
        width: 100%;
    }

    .form-group {
        flex-direction: column;
        align-items: flex-start;
    }

    .form-group label {
        width: 100%;
        text-align: left;
        padding-right: 0;
    }
}

    </style>

    <div class="container">
        <div class="form-container">
            <h1>User Registration</h1>
            <form action="register.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username">User Name:</label>
                    <input type="text" id="username" name="username" required placeholder="Username">
                </div>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" required placeholder="Phone">
                </div>
                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea id="address" name="address" rows="3" required placeholder="Address"></textarea>
                </div>
                <div class="form-group">
                    <label for="profile">Profile Picture:</label>
                    <input type="file" id="profile" name="profile" accept="image/*" required>
                </div>
                <button type="submit">Register</button>
            </form>
            <p class="login-link">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>

</body>
</html>
