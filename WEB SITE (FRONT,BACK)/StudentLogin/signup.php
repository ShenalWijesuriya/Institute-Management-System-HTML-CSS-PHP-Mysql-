<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Validate input fields
    if (empty($username) || empty($email) || empty($password) || $password !== $confirmPassword) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields correctly']);
        exit;
    }

    // Check if the user already exists
    $stmt = $conn->prepare("SELECT * FROM studentlogin WHERE username = ? OR email = ?");
    $stmt->bind_param('ss', $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username or Email already exists']);
        exit;
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user into the database
    $stmt = $conn->prepare("INSERT INTO studentlogin (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $username, $email, $hashedPassword);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Signup successful']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to signup, please try again']);
    }

    $stmt->close();
    $conn->close();
}
?>
