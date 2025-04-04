<?php
// Initialize the student index from the form (if submitted)
$studentIndex = '';
$errorMessage = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentIndex = $_POST['studentIndex'];

    // Database connection
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

    // SQL query to fetch student data based on student index
    $sql = "SELECT * FROM studentsdata WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $studentIndex);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Student found, redirect to StudentTimeTable.php
        header("Location: StudentTimeTable.php?studentIndex=" . urlencode($studentIndex));
        exit();
    } else {
        $errorMessage = "No student found with the index: $studentIndex";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login</title>
    <style>
       /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color:rgb(0, 0, 0);
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
}

/* Full-screen background video */
video.background-video {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -1;
}

/* Container for flex layout */
.container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 90%;
    max-width: 1200px;
    height: 80%;
    transition: all 0.3s ease;
}

/* Login Form Container */
.login-container {
    background: rgba(255, 255, 255, 0);
    border: 4px solid rgba(255, 255, 255, 0.142);
    box-shadow: 0 -2px 4px rgb(255, 255, 255);
    backdrop-filter: blur(15px);
    padding: 40px;
    border-radius: 30px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    width: 100%;
    max-width: 600px;
    position: relative;
    z-index: 1;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.6s ease-out forwards;
    text-align: center;
}

h2 {
    margin-bottom: 25px;
    color: #f9f9f9;
    font-size: 40px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: color 0.3s ease;
}

/* Label Styling */
label {
    font-size: 16px;
    margin-bottom: 12px;
    display: block;
    color: #f9f9f9;
    transition: color 0.3s ease;
}

/* Input Field Styling */
input {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    margin-bottom: 25px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9;
    outline: none;
    box-sizing: border-box;
    transition: all 0.3s ease;
}

input:focus {
    border-color: rgb(172, 175, 76);
    background-color: #fff;
}

/* Button Styling */
button {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    background-color: rgb(232, 200, 37);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

button:hover {
    background-color: rgb(217, 198, 104);
    transform: scale(1.05);
}

/* Error Message Styling */
.error {
    color: red;
    font-size: 14px;
    margin-top: 10px;
    transition: opacity 0.3s ease;
    opacity: 0;
    animation: fadeIn 0.5s forwards;
}

.error.visible {
    opacity: 1;
}

/* Video Section */
.video-container {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: all 0.3s ease;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

    </style>
</head>
<body>
    <video class="background-video" autoplay muted loop>
        <source src="/Videos/Videos/Technology Background Video Loop For Website.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="login-container">
        <h2>Student Login</h2>
        <form method="POST">
            <label for="studentIndex">Enter Student Index:</label>
            <input type="text" id="studentIndex" name="studentIndex" required placeholder="Enter Index" value="<?php echo htmlspecialchars($studentIndex); ?>">
            <button type="submit">Login</button>
        </form>

        <!-- Display error message if student index is invalid -->
        <?php if ($errorMessage): ?>
            <p class="error"><?php echo htmlspecialchars($errorMessage); ?></p>
        <?php endif; ?>
    </div>

    <script>
        
    </script>
</body>
</html>
