<?php
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

// Query for teacher count
$teacherCountQuery = "SELECT COUNT(*) AS teacherCount FROM teacherlogin1"; 
$result = $conn->query($teacherCountQuery);
$teacherCount = $result->fetch_assoc()['teacherCount'];

// Query for student count
$studentCountQuery = "SELECT COUNT(*) AS studentCount FROM studentsdata"; 
$result = $conn->query($studentCountQuery);
$studentCount = $result->fetch_assoc()['studentCount'];

// Query to fetch the admin name from the database
$adminQuery = "SELECT username FROM admin WHERE id = 1"; 
$adminResult = $conn->query($adminQuery);

// Check if the query returned a result
if ($adminResult->num_rows > 0) {
    // Fetch the admin name
    $adminName = $adminResult->fetch_assoc()['username'];
} else {
    // Fallback if no admin name is found
    $adminName = "Admin Name";
}

// Close the connection
$conn->close();

// Get current date and time
$currentDate = date('Y-m-d');
$currentTime = date('H:i:s');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Welcome</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('/images/img2.jpg') no-repeat center center fixed; 
            background-size: cover;
            color: white; /* Ensures text is readable */
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            background-color: #343a40;
            color: #ffffff;
            width: 250px;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .sidebar h1 {
            font-size: 22px;
            margin-bottom: 30px;
        }
        .sidebar button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 15px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: left;
            width: 100%;
        }
        .sidebar button:hover {
            background-color: #0056b3;
        }
        .content {
            flex: 1;
            padding: 40px;
        }
        .welcome-dashboard {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .welcome-dashboard h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
        }
        .welcome-dashboard .date-time {
            font-size: 18px;
            color: #666;
            margin-bottom: 40px;
        }
        .welcome-dashboard .admin-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .admin-info img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        .admin-info div {
            color: #333;
        }
        .admin-info .admin-name {
            font-size: 22px;
            font-weight: 600;
        }
        .admin-info .admin-role {
            font-size: 16px;
            color: #007bff;
        }
        .count-cards {
            display: flex;
            gap: 30px;
            margin-top: 40px;
        }
        .count-card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            flex: 1;
        }
        .count-card h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .count-card p {
            font-size: 18px;
            color: #007bff;
        }

        /* Logout Button Style */
        .logout-button {
            background-color: #dc3545;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            text-align: center;
        }

        .logout-button:hover {
            background-color: #c82333;
        }

        
        

  /* Dropdown Container */
.dropdown {
    position: relative;
    width: 100%;
    display: flex;
    justify-content: flex-end; /* Align button to the right */
}

/* Arrow Icon */
.dropbtn::after {
    content: '▼';
    font-size: 12px;
    transition: transform 0.2s ease;
}

/* Dropdown Content (Hidden by Default) */
.dropdown-content {
    display: none;
    position: absolute;
    right: 0; /* Align content to the right */
    top: 44px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    min-width: 180px;
    z-index: 10;
    border-radius: 6px;
    overflow: hidden;
    animation: fadeIn 0.3s ease-in-out;
}

/* Dropdown Content Links */
.dropdown-content a {
    color: white;
    padding: 12px;
    display: block;
    text-decoration: none;
    font-size: 15px;
    transition: background 0.3s ease-in-out, padding-left 0.2s ease;
}

/* Hover Effect for Links */
.dropdown-content a:hover {
    background: rgba(255, 255, 255, 0.2);
    padding-left: 16px;
}

/* Show Dropdown on Hover */
.dropdown:hover .dropdown-content {
    display: block;
}

/* Smooth Fade In Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


    </style>
    <script>
        function confirmLogout(event) {
            event.preventDefault();
            
            // Show confirmation message
            const isConfirmed = confirm("Are you sure you want to log out?");
            if (isConfirmed) {
                // If confirmed, submit the form and redirect to index.html
                window.location.href = 'index.html'; // Redirect after logout
                document.getElementById('logoutForm').submit(); // Submit the form to log out
            }
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <h1>Institute Admin Panel</h1>
        <button onclick="window.location.href='dashboard.php'">Dashboard</button>
        <button onclick="window.location.href='teacher.php'">Teachers</button>
        <button onclick="window.location.href='student.php'">Student</button>
        <button onclick="window.location.href='student-login.php'">Student Web Login</button>
        <button onclick="window.location.href='online_class.php'">Online Class Student</button>
        <button onclick="window.location.href='timetable.php'">Timetable</button>
        <br>
        <!-- Subjects Button with Popup -->
    <div class="dropdown">
        <button class="dropbtn">Subjects</button>
        <div class="dropdown-content">
            <a href="courses.php">WEB Cards Edit</a>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn">Online</button>
        <div class="dropdown-content">
            <a href="online.php">WEB Cards Edit</a>
        </div>
    </div>
</div>
    </div>
    <div class="content">
        <div class="welcome-dashboard">
            <h2>Dashboard</h2>
            <div class="date-time">
                <p><?= $currentDate ?> | <?= $currentTime ?></p>
            </div>
            <div class="admin-info">
                <div>
                    <p class="admin-name">Hello, <?= $adminName ?>!</p>
                    <p class="admin-role">Admin Panel</p>
                </div>
                <!-- Logout Button Form -->
                <div>
                    <form id="logoutForm" action="login.php" method="POST">
                        <button type="button" class="logout-button" onclick="confirmLogout(event)">Logout</button>
                    </form>
                </div>
            </div>

            <div class="count-cards">
                <div class="count-card">
                    <h3>Teachers</h3>
                    <p><?= $teacherCount ?> Teachers</p>
                </div>
                <div class="count-card">
                    <h3>Students</h3>
                    <p><?= $studentCount ?> Students</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
