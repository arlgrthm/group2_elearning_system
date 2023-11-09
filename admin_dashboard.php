<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_id'])) {
    // Redirect to the login page if the user is not logged in
    header("Location: admin_login.php");
    exit();
}

// If the user is logged in, you can access the session variables
$adminId = $_SESSION['admin_id'];
$adminFullName = $_SESSION['admin_full_name'];
$adminUsername = $_SESSION['admin_username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
    <link rel="stylesheet" href="./necessities/main.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg admin-top-nav">
        <div class="container">

            <!--Profile Dropdown-->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item custom-dropdown">
                    <a class="nav-link text-light user-name" href="#">
                        <i class="fa-regular fa-user"></i>
                            Hello, <?php echo $_SESSION['admin_username']; ?>
                    </a> 
                    <div class="dropdown-content">
                        <a href="#">Profile</a>
                        <a href="#">Settings</a>
                    <div class="dropdown-divider"></div>
                        <a class="logout-button" href="./necessities/admin_logout.php">Logout</a>
                    </div>
                </li>

                <!-- Help -->
                <li class="nav-item">
                    <a class="nav-link text-light ml-2" href="#">
                        <i class="fa-solid fa-circle-question"></i>
                    </a>
                </li>

                <!-- Announcements -->
                <li class="nav-item">
                    <a class="nav-link text-light ml-2" href="#">
                        <i class="fa-solid fa-bell"></i>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar admin-sidebar">
        <div class="logo">
            <img src="./Images/a-logo.svg" alt="Sidebar Logo">
        </div>
        <a href="?page=main"><i class="fa-solid fa-house-user"></i>Dashboard</a>
        <hr>
        <a href="?page=learner_accounts_management"><i class="fa-solid fa-user"></i>Learner Accounts Management</a>
        <a href="?page=admin_management"><i class="fa-solid fa-hammer"></i>Admin Management</a>
        <a href="?page=course_content_management"><i class="fa-solid fa-award"></i>Course Content Management</a>
        <a href="?page=course_enrollment_management"><i class="fa-solid fa-book"></i>Course Enrollment Management</a>
        <a href="?page=announcements_management"><i class="fa-solid fa-bullhorn"></i>Announcements Management</a>
        <a href="?page=announcements_management"><i class="fa-solid fa-bullhorn"></i>User Progress Tracking</a>
        <a href="?page=announcements_management"><i class="fa-solid fa-bullhorn"></i>Certificates Management</a>
    </div>

    <div class="content-container admin_dashboard_contents">
    <?php
        if (isset($_GET['page'])) {
            switch ($_GET['page']) {
                case 'main':
                    include('./admin_dashboard_content/main.php');
                    break;
                case 'learner_accounts_management':
                    include('./admin_dashboard_content/learner_accounts_management.php');
                    break;
                case 'admin_management':
                    include('./admin_dashboard_content/admin_management.php');
                    break;
                case 'course_content_management':
                    include('./admin_dashboard_content/course_content_management.php');
                    break;
                case 'course_enrollment_management':
                    include('./admin_dashboard_content/course_enrollment_management.php');
                    break;
                case 'accomplishment_management':
                    include('./admin_dashboard_content/accomplishment_management.php');
                    break;
                default:
                    // Handle cases where $_GET['page'] doesn't match any of the expected values
                    include('./admin_dashboard_content/main.php'); // Default to the main page or handle as needed
            }
        }
    ?>
    </div>

    <!-- Add Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    
</body>
</html>
