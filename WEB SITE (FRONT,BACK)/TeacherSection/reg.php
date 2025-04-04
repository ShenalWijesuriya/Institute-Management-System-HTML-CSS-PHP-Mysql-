<?php
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

// Handle form submission (Add new row)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submitData'])) {
    $subject = $_POST['subject'];
    $grade = $_POST['grade'];
    $teacher = $_POST['teacher'];
    $time = $_POST['time'];
    $fee = $_POST['fee'];

    $stmt = $conn->prepare("INSERT INTO timetable1 (subject, grade, teacher_name, time, class_fee) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sissd", $subject, $grade, $teacher, $time, $fee);
    $stmt->execute();
    $stmt->close();
}

// Handle row deletion
if (isset($_GET['delete_id'])) {
    $deleteId = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM timetable1 WHERE id = ?");
    $stmt->bind_param("i", $deleteId);
    $stmt->execute();
    $stmt->close();
    header("Location: " . $_SERVER['PHP_SELF']); // Refresh page to show updated data
    exit;
}

// Fetch time table data for student and teacher views
$sql = "SELECT * FROM timetable1";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Table</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
        }
        button {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 4px;
            background-color: yellow;
            color: black;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #ffd700;
        }
        input, select {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .hidden {
            display: none;
        }
        .back-btn {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin: 20px;
        }
        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div id="teacher-view" class="hidden">
    <h1>Time Table</h1>
    
    <!-- Back Button -->
    <a href="/TeacherSection/teacher.html"><button class="back-btn">Back</button></a> 

    <form action="" method="POST">
        <table id="timeTable">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Grade</th>
                    <th>Teacher Name</th>
                    <th>Time</th>
                    <th>Class Fee</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><select name="subject">
                        <option value="Sinhala">Sinhala</option>
                        <option value="English">English</option>
                        <option value="History">History</option>
                        <option value="Tamil">Tamil</option>
                        <option value="Maths">Maths</option>
                    </select></td>
                    <td><select name="grade">
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                    </select></td>
                    <td><input type="text" name="teacher" placeholder="Teacher Name"></td>
                    <td><input type="time" name="time"></td>
                    <td><input type="number" name="fee" placeholder="Fee"></td>
                    <td><button type="submit" name="submitData">Submit</button></td>
                </tr>
            </tbody>
        </table>
    </form>

    <h2>Existing Time Table Entries</h2>
    <table id="existingTimeTable">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Grade</th>
                <th>Teacher Name</th>
                <th>Time</th>
                <th>Class Fee</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display the timetable data from the database
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>" . $row['subject'] . "</td>
                        <td>" . $row['grade'] . "</td>
                        <td>" . $row['teacher_name'] . "</td>
                        <td>" . $row['time'] . "</td>
                        <td>" . $row['class_fee'] . "</td>
                        <td><a href='?delete_id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this row?\");'>Delete</a></td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No data available</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    const userRole = "teacher"; // Change to "student" to simulate student login

    document.addEventListener("DOMContentLoaded", () => {
        if (userRole === "teacher") {
            document.getElementById("teacher-view").classList.remove("hidden");
        } else if (userRole === "student") {
            document.getElementById("student-view").classList.remove("hidden");
        }
    });
</script>

</body>
</html>

<?php
$conn->close();
?>
