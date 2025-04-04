<?php
// Database connection
$host = 'localhost'; 
$db = 'institute'; 
$user = 'root'; 
$pass = ''; 

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Add new student
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addStudent'])) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $student_age = $_POST['student_age'];
    $student_grade = $_POST['student_grade'];
    $student_subjects = $_POST['student_subjects'];
    $parent_name = $_POST['parent_name'];
    $parent_phone = $_POST['parent_phone'];
    $card_name = $_POST['card_name'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvc = $_POST['cvc'];

    try {
        $stmt = $pdo->prepare("INSERT INTO studentsdata (`student_id`, `student_name`, `student_age`, `student_grade`, `student_subjects`, `parent_name`, `parent_phone`, `card_name`, `card_number`, `expiry_date`, `cvc`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if ($stmt->execute([$student_id, $student_name, $student_age, $student_grade, $student_subjects, $parent_name, $parent_phone, $card_name, $card_number, $expiry_date, $cvc])) {
            echo "Student added successfully!";
            header("Location: student.php"); 
            exit();
        } else {
            print_r($stmt->errorInfo()); // Display SQL errors
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}


// Update student
if (isset($_POST['updateStudent'])) {
    $id = $_POST['id'];
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $student_age = $_POST['student_age'];
    $student_grade = $_POST['student_grade'];
    $student_subjects = $_POST['student_subjects'];
    $parent_name = $_POST['parent_name'];
    $parent_phone = $_POST['parent_phone'];
    $card_name = $_POST['card_name'];
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvc = $_POST['cvc'];

    $stmt = $pdo->prepare("UPDATE studentsdata SET `student_id` = ?, `student_name` = ?, `student_age` = ?, `student_grade` = ?, `student_subjects` = ?, `parent_name` = ?, `parent_phone` = ?, `card_name` = ?, `card_number` = ?, `expiry_date` = ?, `cvc` = ? WHERE id = ?");
    $stmt->execute([$student_id, $student_name, $student_age, $student_grade, $student_subjects, $parent_name, $parent_phone, $card_name, $card_number, $expiry_date, $cvc, $id]);
    header("Location: student.php");
}

// Delete student
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM studentsdata WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: student.php");
}

// Fetch all students
$stmt = $pdo->query("SELECT * FROM studentsdata");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Institute Admin Panel - Students</title>
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
        <h1>Institute Admin Panel</h1>
        <button onclick="window.location.href='dashboard.php'">Dashboard</button>
        <button onclick="window.location.href='teacher.php'">Teachers</button>
        <button onclick="window.location.href='student.php'">Student</button>
        <button onclick="window.location.href='student-login.php'">Student Web Login</button>
        <button onclick="window.location.href='online_class.php'">Online Class</button> 
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
    <div class="content">
        <h2>Students List</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Grade</th>
                    <th>Subjects</th>
                    <th>Parent Name</th>
                    <th>Parent Phone</th>
                    <th>Card Name</th>
                    <th>Card Number</th>
                    <th>Expiry Date</th>
                    <th>CVC</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= $student['id'] ?></td>
                        <td><?= $student['student_id'] ?></td>
                        <td><?= $student['student_name'] ?></td>
                        <td><?= $student['student_age'] ?></td>
                        <td><?= $student['student_grade'] ?></td>
                        <td><?= $student['student_subjects'] ?></td>
                        <td><?= $student['parent_name'] ?></td>
                        <td><?= $student['parent_phone'] ?></td>
                        <td><?= $student['card_name'] ?></td>
                        <td><?= $student['card_number'] ?></td>
                        <td><?= $student['expiry_date'] ?></td>
                        <td><?= $student['cvc'] ?></td>
                        <td>
                        <button onclick="openEditModal('<?= $student['id'] ?>', '<?= $student['student_id'] ?>', '<?= $student['student_name'] ?>', '<?= $student['student_age'] ?>', '<?= $student['student_grade'] ?>', '<?= $student['student_subjects'] ?>', '<?= $student['parent_name'] ?>', '<?= $student['parent_phone'] ?>', '<?= $student['card_name'] ?>', '<?= $student['card_number'] ?>', '<?= $student['expiry_date'] ?>', '<?= $student['cvc'] ?>')">Edit</button>
                            <a href="student.php?delete_id=<?= $student['id'] ?>" onclick="return confirm('Are you sure you want to delete this student?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="add-teacher-btn" onclick="openAddModal()">Add Studet</button>

        <!-- Add student Modal -->
       <div id="addModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeAddModal()">&times;</span>
                <div class="modal-header">Add New Student</div>
                <form action="student.php" method="POST">
                <input type="text" name="student_id" placeholder="Student ID" required>
                <input type="text" name="student_name" placeholder="Name" required>
                <input type="number" name="student_age" placeholder="Age" required>
                <input type="text" name="student_grade" placeholder="Grade" required>
                <input type="text" name="student_subjects" placeholder="Subjects" required>
                <input type="text" name="parent_name" placeholder="Parent Name" required>
                <input type="text" name="parent_phone" placeholder="Parent Phone" required>
                <input type="text" name="card_name" placeholder="Card Name" required>
                <input type="text" name="card_number" placeholder="Card Number" required>
                <input type="text" name="expiry_date" placeholder="Expiry Date" required>
                <input type="text" name="cvc" placeholder="CVC" required>
                    <button type="submit" name="addStudent">Add Student</button>
                    <button type="button" onclick="closeAddModal()">Cancel</button>
                </form>
            </div>
        </div>

        

        <!-- Modal for editing student -->
        <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditForm()">&times;</span>
            <div class="modal-header">Edit Student</div>
            <form action="student.php" method="POST">
                <input type="hidden" name="id" id="editId">
                <input type="text" name="student_id" id="editStudentId" required>
                <input type="text" name="student_name" id="editStudentName" required>
                <input type="number" name="student_age" id="editStudentAge" required>
                <input type="text" name="student_grade" id="editStudentGrade" required>
                <input type="text" name="student_subjects" id="editStudentSubject" required>
                <input type="text" name="parent_name" id="editParentName" required>
                <input type="text" name="parent_phone" id="editPhoneNo" required>
                <input type="text" name="card_name" id="editCardName" required>
                <input type="text" name="card_number" id="editCardNumber" required>
                <input type="text" name="expiry_date" id="editExpiryDate" required>
                <input type="text" name="cvc" id="editCvc" required>
                <button type="submit" name="updateStudent">Update Student</button>
                <button type="button" onclick="closeEditForm()">Cancel</button>
            </form>
        </div>
</div>

    </div>
    
    <script>
        const editModal = document.getElementById('editModal');

        function openEditModal(id, student_id, student_name, student_age, student_grade, student_subjects, parent_name, parent_phone, card_name, card_number, expiry_date, cvc) {
    document.getElementById('editId').value = id;
    document.getElementById('editStudentId').value = student_id;
    document.getElementById('editStudentName').value = student_name;
    document.getElementById('editStudentAge').value = student_age;
    document.getElementById('editStudentGrade').value = student_grade;
    document.getElementById('editStudentSubject').value = student_subjects;
    document.getElementById('editParentName').value = parent_name;
    document.getElementById('editPhoneNo').value = parent_phone;
    document.getElementById('editCardName').value = card_name;
    document.getElementById('editCardNumber').value = card_number;
    document.getElementById('editExpiryDate').value = expiry_date;
    document.getElementById('editCvc').value = cvc;

    document.getElementById('editModal').style.display = 'flex';
}

function closeEditForm() {
    document.getElementById('editModal').style.display = 'none';
}


function closeEditModal() {
    editModal.style.display = 'none';
}

function openAddModal() {
    document.getElementById('addModal').style.display = 'flex';
}

function closeAddModal() {
    document.getElementById('addModal').style.display = 'none';
}

// Close modals when clicking outside
window.onclick = function(event) {
    if (event.target.className === 'modal') {
        event.target.style.display = 'none';
    }
}
    </script>
</body>
</html>
