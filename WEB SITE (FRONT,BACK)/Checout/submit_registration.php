<?php
// submit_registration.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $studentName = $_POST['studentName'];
    $studentAge = $_POST['studentAge'];
    $studentGrade = $_POST['studentGrade'];
    $studentSubjects = $_POST['studentSubjects'];
    $parentName = $_POST['parentName'];
    $parentPhone = $_POST['parentPhone'];
    $cardName = $_POST['cardName'];
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvc = $_POST['cvc'];

    // database connection
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

    // Step 1: Get the last inserted student ID to generate a new one
    $result = $conn->query("SELECT student_id FROM studentsdata ORDER BY id DESC LIMIT 1");

    if ($result->num_rows > 0) {
        // Fetch the last student ID
        $row = $result->fetch_assoc();
        $lastStudentId = $row['student_id'];

        // Extract the numeric part and increment it
        preg_match('/(\d+)/', $lastStudentId, $matches);
        $newStudentId = "JM" . str_pad($matches[0] + 1, 3, '0', STR_PAD_LEFT);
    } else {
        // If no students exist yet, start with JM001
        $newStudentId = "JM001";
    }

    // Step 2: Prepare the SQL query to insert data (for security, use prepared statements)
    $sql = $conn->prepare("INSERT INTO studentsdata (student_id, student_name, student_age, student_grade, student_subjects, parent_name, parent_phone, card_name, card_number, expiry_date, cvc)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters to the query
    $sql->bind_param("sssssssssss", $newStudentId, $studentName, $studentAge, $studentGrade, $studentSubjects, $parentName, $parentPhone, $cardName, $cardNumber, $expiryDate, $cvc);

    // Execute the query
    if ($sql->execute()) {
        // Return success message with the new student ID
        echo json_encode(["success" => true, "studentId" => $newStudentId]);
    } else {
        // Return error message
        echo json_encode(["success" => false, "error" => "Error: " . $sql->error]);
    }

    // Close the connection
    $conn->close();
}
?>
