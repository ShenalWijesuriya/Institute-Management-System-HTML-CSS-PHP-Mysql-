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

// Fetch subject details
$subjectQuery = "SELECT subject_name, grade, teacher_name FROM subject";
$subjectResult = $conn->query($subjectQuery);

// Fetch class fees
$feeQuery = "SELECT subject_name, grade, class_fee FROM class_fees";
$feeResult = $conn->query($feeQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subject Details</title>
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
        background-color: #1f1f1f;
        border-radius: 8px;
    }
    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
    }
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
        text-align: center;
    }
    th {
        background-color: #ffcc00;
        color: #121212;
    }
    tr:nth-child(even) {
        background-color: #1f1f1f;
    }
    .back-btn {
        display: inline-block;
        padding: 0.8rem 1.5rem;
        border: none;
        border-radius: 8px;
        background: #ffcc00;
        color: #121212;
        font-size: 1rem;
        font-weight: bold;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }
    .back-btn:hover {
        background: #e6b800;
        box-shadow: 0px 5px 15px rgba(255, 204, 0, 0.5);
    }
  </style>
</head>
<body>
  <h1>Subject Details</h1>
  <div class="container">
    <table>
      <thead>
        <tr>
          <th>Subject Name</th>
          <th>Grade</th>
          <th>Teacher Name</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $subjectResult->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['subject_name']) ?></td>
          <td><?= htmlspecialchars($row['grade']) ?></td>
          <td><?= htmlspecialchars($row['teacher_name']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <h2>Class Fee</h2>
    <table>
      <thead>
        <tr>
          <th>Subject</th>
          <th>Grade</th>
          <th>Class Fee (RS)</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $feeResult->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['subject_name']) ?></td>
          <td><?= htmlspecialchars($row['grade']) ?></td>
          <td><?= htmlspecialchars($row['class_fee']) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <a href="/Home.html" class="back-btn">Back</a>
  </div>
</body>
</html>

<?php $conn->close(); ?>
