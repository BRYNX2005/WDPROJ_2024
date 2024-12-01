<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: ../account/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        <?php require_once '../css/dashboard.css'?>
    </style>
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="logo">
                <div class="logo">
                    <img src="../landingpage/Group 16.png" alt="Logo">
                </div>
                <h2>Student Appraisal</h2>
            </div>
            <nav>
                <ul>
                    <li><a href="../admin/dashboard.php" class="active"><i class="fas fa-home"></i> Home</a></li>
                    <li><a href="../admin/enrollmentstatus.php"><i class="fas fa-user-check"></i> Enrollment Status</a></li>
                    <li><a href="../admin/curriculum.php"><i class="fas fa-book"></i> Curriculum</a></li>
                    <li><a href="../admin/announcements.php"><i class="fas fa-bullhorn"></i> Announcements</a></li>
                    <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
            </nav>
            <a href="../account/logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </aside>

        <main>
            <div class="profile">
                <div class="profile-card">
                    <div class="profile-icon">
                        <img src="../img/iconamoon_profile-circle-fill.png" alt="Profile">
                    </div>
                    <div class="profile-details">
                        <h2><?= htmlspecialchars(strtoupper($_SESSION['fullname'])) ?> (<?= htmlspecialchars($_SESSION['username'])?>)</h2>
                        <p>Program: BS Computer Science</p>
                        <p>Student ID: <?= htmlspecialchars($_SESSION['student_id'])?></p>
                        <button>Full Profile</button>
                    </div>
                </div>
                <div class="forms-container">
                    <div class="forms">
                        <button>Payments</button>
                        <button>View Grades</button>
                        <button>Attendance</button>
                        <button>View COR</button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
