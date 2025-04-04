<?php
// Database connection
$servername = "localhost";  // Change to your database server
$username = "root";         // Change to your database username
$password = "";             // Change to your database password
$dbname = "institute";      // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch all classes
$sql = "SELECT subject, grade, teacher_name, time, class_fee FROM timetable1";
$result = $conn->query($sql);

// Prepare an array to hold the data
$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    $data = [];  // Empty array if no data is found
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Search</title>
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    line-height: 1.6;
    color: #ccc;
    background-color: #121212;
}

h1 {
    text-align: center;
    color: #ffcc00;
    font-size: 2.5em;
    font-weight: bold;
    padding: 20px 0;
    margin-top: 0;
    background-color: #1f1f1f;
    border-radius: 8px;
}

.container {
    width: 80%;
    margin: 0 auto;
    padding: 20px;
}

/* Search Container */
.search-container {
    background-color: #1a1a1a;
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    margin-bottom: 30px;
    border: 2px solid #ffcc00;
}

.search-container label {
    display: block;
    margin-bottom: 8px;
    font-size: 1rem;
    color: #bbb;
}

.search-container select, .search-container button {
    width: 100%;
    padding: 12px;
    margin-bottom: 20px;
    border: 1px solid #555;
    border-radius: 8px;
    font-size: 1rem;
    background-color: #2a2a2a;
    color: #ddd;
}

.search-container button {
    background-color: #ffcc00;
    color: #121212;
    border: none;
    cursor: pointer;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.search-container button:hover {
    background-color: #e6b800;
}

/* Results Table */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    background-color: #2a2a2a;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
}

table, th, td {
    border: 1px solid #555;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #ffcc00;
    color: #121212;
}

tr:nth-child(even) {
    background-color: #1f1f1f;
}

/* View Button */
.view-button {
    background-color: #ffcc00;
    color: #121212;
    padding: 8px 12px;
    border: none;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.view-button:hover {
    background-color: #e6b800;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 100%;
        padding: 10px;
    }

    .search-container {
        padding: 15px;
    }

    table {
        font-size: 0.9rem;
    }

    .view-button {
        padding: 6px 10px;
    }
}

    </style>
</head>
<body>

<div class="container">
    <h1>Class Search</h1>

    <div class="search-container">
        <label for="subject">Select Subject:</label>
        <select id="subject">
            <option value="">Select Subject</option>
            <option value="Sinhala">Sinhala</option>
            <option value="English">English</option>
            <option value="History">History</option>
            <option value="Tamil">Tamil</option>
            <option value="Maths">Maths</option>
        </select>

        <label for="grade">Select Grade:</label>
        <select id="grade">
            <option value="">Select Grade</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
        </select>

        <button onclick="searchData()">Search</button>
    </div>

    <!-- Results Table -->
    <table id="resultsTable">
        <thead>
            <tr>
                <th>Subject</th>
                <th>Grade</th>
                <th>Teacher Name</th>
                <th>Time</th>
                <th>Class Fee</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display all data from the query in the table by default
            foreach ($data as $item) {
                echo "<tr>";
                echo "<td>" . $item['subject'] . "</td>";
                echo "<td>" . $item['grade'] . "</td>";
                echo "<td>" . $item['teacher_name'] . "</td>";
                echo "<td>" . $item['time'] . "</td>";
                echo "<td>" . $item['class_fee'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    function searchData() {
        const subject = document.getElementById("subject").value;
        const grade = document.getElementById("grade").value;
        const table = document.getElementById("resultsTable");
        const rows = table.getElementsByTagName("tr");

        // Loop through all rows and show or hide based on the search criteria
        for (let i = 1; i < rows.length; i++) { // Start from 1 to skip the header row
            const row = rows[i];
            const rowSubject = row.cells[0].textContent.trim();
            const rowGrade = row.cells[1].textContent.trim();

            if ((subject === "" || rowSubject === subject) && (grade === "" || rowGrade === grade)) {
                row.style.display = "";  // Show row
            } else {
                row.style.display = "none";  // Hide row
            }
        }
    }
</script>

</body>
</html>
