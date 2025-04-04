<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields']);
        exit;
    }

    // Check if the user exists
    $stmt = $conn->prepare("SELECT * FROM studentlogin WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            echo json_encode(['status' => 'success', 'message' => 'Login successful']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }

    $stmt->close();
    $conn->close();
}
?>
