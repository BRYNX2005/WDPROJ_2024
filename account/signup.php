<?php
session_start();
require_once '../classes/database.class.php';

$signupError = '';
$signupSuccess = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $birthdate = trim($_POST['birthdate']);
    $gender = trim($_POST['gender']);
    $student_id = trim($_POST['student_id']);
    $gmail = trim($_POST['gmail']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Basic validation
    if (
        empty($fullname) || empty($birthdate) || empty($gender) || empty($student_id) ||
        empty($gmail) || empty($username) || empty($password) || empty($confirmPassword)
    ) {
        $signupError = "Please fill all fields.";
    } elseif ($password !== $confirmPassword) {
        $signupError = "Passwords do not match.";
    } else {
        // Check if username or student_id already exists
        $db = new Database();
        $conn = $db->connect();
        $sql = "SELECT COUNT(*) FROM users WHERE username = :username OR student_id = :student_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->execute();
        if ($stmt->fetchColumn() > 0) {
            $signupError = "Username or Student ID already exists.";
        } else {
            // Insert new user into the database
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (fullname, birthdate, gender, student_id, gmail, username, password) 
                    VALUES (:fullname, :birthdate, :gender, :student_id, :gmail, :username, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':fullname', $fullname);
            $stmt->bindParam(':birthdate', $birthdate);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':student_id', $student_id);
            $stmt->bindParam(':gmail', $gmail);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashPassword);
            if ($stmt->execute()) {
                $signupSuccess = "Registration successful! You can now log in.";
            } else {
                $signupError = "Error during registration. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        <?php require_once '../vendor/bootstrap-5.3.3/css/bootstrap.min.css'?>
        <?php require_once '../css/login.css'?>
    </style>
</head>
<body>
    <section id="logBg" class="bg-image">
        <div class="container d-flex justify-content-center align-items-center vh-100">
            <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%;">
                <div class="text-center">
                    <h2 class="mb-4">Create an Account</h2>
                </div>
                <?php if ($signupError): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($signupError) ?>
                    </div>
                <?php endif; ?>
                <?php if ($signupSuccess): ?>
                    <div class="alert alert-success" role="alert">
                        <?= htmlspecialchars($signupSuccess) ?>
                    </div>
                <?php endif; ?>
                <form action="../account/signup.php" method="POST">
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Full Name</label>
                                <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Enter your full name" required>
                            </div>
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Birthdate</label>
                                <input type="date" name="birthdate" id="birthdate" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select name="gender" id="gender" class="form-select" required>
                                    <option value="" disabled selected>Select your gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="student_id" class="form-label">Student ID</label>
                                <input type="text" name="student_id" id="student_id" class="form-control" placeholder="Enter your Student ID" required>
                            </div>
                        </div>
                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="gmail" class="form-label">Gmail</label>
                                <input type="email" name="gmail" id="gmail" class="form-control" placeholder="Enter your Gmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm your password" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                </form>

                <div class="text-center mt-3">
                    <p>Already have an account? <a href="../account/login.php" class="text-decoration-none">Login</a></p>
                </div>
            </div>
        </div>
    </section>

    <script src="../vendor/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
