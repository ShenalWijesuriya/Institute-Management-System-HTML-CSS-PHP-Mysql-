<?php
// Database connection parameters
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "institute"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Validate input data
    if (empty($user) || empty($pass)) {
        $error_message = "Both fields are required.";
    } else {
        // Prevent SQL injection by using prepared statements
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
        if ($stmt === false) {
            $error_message = "Error in prepared statement: " . $conn->error;
        } else {
            // Bind parameters and execute query
            $stmt->bind_param("ss", $user, $pass);

            // Execute the query
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if user exists
            if ($result->num_rows > 0) {
                // User is valid, redirect to dashboard or home page
                echo "<script>alert('Login successful!'); window.location.href = 'dashboard.php';</script>";
                exit();
            } else {
                // User not found
                $error_message = "Invalid username or password.";
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
    <style>
        /* General reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Full-page background video */
        body {
            font-family: 'Roboto', sans-serif;
            overflow: hidden;
        }

        /* Video background styling */
        .video-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        /* Full page container for the form */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5); /* Overlay to darken background */
        }

        /* Modern login form styling */
        .login-form {
            background: rgba(0, 0, 0, 0.7);
            padding: 50px;
            border-radius: 15px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
            width: 400px;
            animation: fadeIn 1s ease-in-out;
        }

        /* Logo styling */
        .logo {
            width: 90px;
            margin-bottom: 30px;
        }

        /* Form header */
        h2 {
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: 400;
            letter-spacing: 1px;
        }

        /* Input fields styling */
        input {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid #3498db;
            border-radius: 5px;
            font-size: 16px;
            outline: none;
            background-color: #222;
            color: white;
            transition: all 0.3s ease;
        }

        /* Input focus effect */
        input:focus {
            border-color: #2980b9;
            background-color: #333;
        }

        /* Button styling */
        button {
            width: 100%;
            padding: 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        /* Button hover effect */
        button:hover {
            background-color: #2980b9;
        }

        /* Link styling */
        a {
            color: #3498db;
            text-decoration: none;
        }

        /* Error message styling */
        .error-message {
            color: red;
            margin-top: 15px;
        }

        /* Animation for fading in the login form */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        /* Responsive styling for smaller devices */
        @media (max-width: 480px) {
            .login-form {
                width: 85%;
                padding: 30px;
            }
        }
    </style>
</head>
<body>
    <!-- Background Video -->
    <video class="video-background" autoplay muted loop>
        <source src="/video/video1.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="container">
        <div class="login-form">
            <h2>Admin Login</h2>
            <form action="" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <?php
            if (isset($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>
