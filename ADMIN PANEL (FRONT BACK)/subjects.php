<?php
// Database connection
$host = 'localhost'; 
$db = 'institute'; 
$user = 'root'; 
$pass = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Fetch subjects
$subjectQuery = "SELECT subject_name, grade, teacher_name FROM subject";
$subjectStmt = $pdo->query($subjectQuery);
$subjects = $subjectStmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch fees
$feeQuery = "SELECT subject_name, grade, class_fee FROM class_fees";
$feeStmt = $pdo->query($feeQuery);
$fees = $feeStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institute Admin Panel - Subjects</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
                /* General styles */
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
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: #343a40;
            color: white;
        }

        /* Edit button */
.table button {
    padding: 8px 12px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.table button:hover {
    background-color: #218838;
}

/* Delete button */
.table a {
    padding: 8px 12px;
    background-color: #dc3545;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.table a:hover {
    background-color: #c82333;
}

        .form-container {
            margin-top: 20px;
        }

        .form-container {
    margin-top: 50px;
    background-color: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 700px;
    margin-left: ;
    margin-right: auto;
}

 /* Modal styles */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6); /* Slightly darker background */
    justify-content: center;
    align-items: center;
    z-index: 1000; /* Ensure the modal is on top */
    animation: fadeIn 0.3s ease; /* Added fade-in effect for modal */
}

.modal-content {
    background-color: #fff;
    padding: 30px;
    width: 100%;
    max-width: 500px; /* Responsive max-width */
    border-radius: 12px;
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.2);
    transform: scale(0.9);
    transition: transform 0.3s ease-in-out;
    opacity: 0; /* Start with opacity 0 for fade-in effect */
    animation: scaleUp 0.3s ease-out forwards; /* Animation for modal opening */
}

.modal-content.open {
    transform: scale(1);
    opacity: 1; /* Fade in */
}

.modal-header {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #343a40;
}

/* Input fields */
.modal input {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s ease;
}

.modal input:focus {
    border-color: #007bff;
    box-shadow: 0px 0px 6px rgba(0, 123, 255, 0.3);
}

/* Buttons */
.modal button {
    padding: 12px 18px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
    width: 100%;
    margin-top: 15px;
}

.modal button:hover {
    background-color: #0056b3;
}

.modal button[type="button"] {
    background-color: #f8f9fa;
    color: #343a40;
    border: 1px solid #ddd;
    margin-top: 10px;
}

.modal button[type="button"]:hover {
    background-color: #e2e6ea;
    color: #007bff;
}

/* Close button (X) */
.modal .close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 24px;
    color: #343a40;
    cursor: pointer;
    transition: color 0.3s ease;
}

.modal .close:hover {
    color: #dc3545;
}

/* Close modal animation */
@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

@keyframes scaleUp {
    0% {
        transform: scale(0.9);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@media (max-width: 600px) {
    .modal-content {
        width: 90%;
        padding: 20px;
    }
}



                    

            .form-container h3 {
                font-size: 24px;
                font-weight: 600;
                color: #343a40;
                text-align: center;
                margin-bottom: 20px;
            }

            .form-container form {
                display: flex;
                flex-direction: column;
                gap: 15px;
            }

            .form-container input[type="text"],
            .form-container input[type="email"],
            .form-container input[type="password"] {
                padding: 15px;
                font-size: 16px;
                border: 2px solid #ddd;
                border-radius: 8px;
                outline: none;
                transition: border-color 0.3s ease;
                width: 100%; 
                box-sizing: border-box;  
                height: 50px;  
                align-items: center;
            }

            .form-container input[type="text"]:focus,
            .form-container input[type="email"]:focus,
            .form-container input[type="password"]:focus {
                border-color: #007bff;
                box-shadow: 0px 0px 4px rgba(0, 123, 255, 0.3);
            }

            .form-container button[type="submit"] {
                padding: 14px 20px;
                background-color: #007bff;
                color: #ffffff;
                font-size: 16px;
                font-weight: 600;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .form-container button[type="submit"]:hover {
                background-color: #0056b3;
            }

            /* Add this to your existing styles */
        .add-teacher-btn {
            background-color: #28a745;
            color: white;
            padding: 30px 50px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 30px;
            transition: background-color 0.3s ease;
            font-size: 20px;
        }

        .add-teacher-btn:hover {
            background-color: #218838;
        }

        #editImagePreview {
    max-width: 100%; /* Ensure image is responsive */
    max-height: 300px; /* Limit the height to 300px */
    object-fit: contain; /* Ensures the image is contained without distorting its aspect ratio */
    margin-top: 10px;
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
</head>
<body>
    <div class="sidebar">
        <!-- Copy the sidebar content from online.php -->
        <h1>Institute Admin Panel</h1>
        <button onclick="window.location.href='dashboard.php'">Dashboard</button>
        <button onclick="window.location.href='teacher.php'">Teachers</button>
        <button onclick="window.location.href='student.php'">Student</button>
        <button onclick="window.location.href='student-login.php'">Student Web Login</button>
        <button onclick="window.location.href='online_class.php'">Online Class</button> 
        <button onclick="window.location.href='timetable.php'">Timetable</button>
        <br>
        <div class="dropdown">
            <button class="dropbtn">Subjects</button>
            <div class="dropdown-content">
                <a href="courses.php">WEB Cards Edit</a>
                <a href="subjects.php">View Subjects</a>
            </div>
        </div>
    </div>

    <div class="content">
        <h2>Subject Details</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Subject Name</th>
                    <th>Grade</th>
                    <th>Teacher Name</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subjects as $subject): ?>
                <tr>
                    <td><?= htmlspecialchars($subject['subject_name']) ?></td>
                    <td><?= htmlspecialchars($subject['grade']) ?></td>
                    <td><?= htmlspecialchars($subject['teacher_name']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Class Fees</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Grade</th>
                    <th>Class Fee (RS)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($fees as $fee): ?>
                <tr>
                    <td><?= htmlspecialchars($fee['subject_name']) ?></td>
                    <td><?= htmlspecialchars($fee['grade']) ?></td>
                    <td><?= htmlspecialchars($fee['class_fee']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>