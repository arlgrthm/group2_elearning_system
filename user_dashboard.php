<?php
// Start the session 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$userID = $_SESSION['user_id'];
$userFirstName = $_SESSION['first_name'];
$userLastName = $_SESSION['last_name'];
$userUserName = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./necessities/main.css">
</head>
<body>

    <nav class="navbar navbar-expand-lg user-dashboard-top-nav">
        <div class="container">
            <!--Profile Dropdown-->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item custom-dropdown">
                    <a class="nav-link text-light user-name" href="#">
                        <i class="fa-regular fa-user"></i> Hello, <?php echo $userUserName; ?>
                    </a>
                    <div class="dropdown-content">
                        <a href="#">Profile</a>
                    <div class="dropdown-divider"></div>
                        <a class="logout-button" href="./necessities/user_logout.php">Logout</a>
                    </div>
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
    <div class="sidebar user-sidebar">
        <div class="logo">
            <img src="./Images/e-logo.svg" alt="Sidebar Logo">
        </div>
        <a href="?page=main"><i class="fa-solid fa-house-user"></i>Dashboard</a>
        <hr>
        <a href="?page=enroll_courses"><i class="fas fa-pencil"></i>Enroll Courses</a>
        <a href="?page=my_courses"><i class="fas fa-graduation-cap"></i>My Courses</a>
        <a href="?page=accomplishments"><i class="fa-solid fa-award"></i>Accomplishments</a>
    </div>

    <div class="content-container user_dashboard_contents">
    <?php
        if (isset($_GET['page'])) {
            switch ($_GET['page']) {
                case 'main':
                    include('./user_dashboard_content/main.php');
                    break;
                case 'enroll_courses':
                    include('./user_dashboard_content/enroll_courses.php');
                    break;
                case 'my_courses':
                    include('./user_dashboard_content/my_courses.php');
                    break;
                case 'course':
                    if (isset($_GET['course_id'])) {
                        $courseId = $_GET['course_id'];
                        include('./user_dashboard_content/start_course.php');
                    } else {
                        include('./user_dashboard_content/main.php'); 
                    }
                    break;
                default:
                    // Handle cases where $_GET['page'] doesn't match any of the expected values
                    include('./user_dashboard_content/main.php'); 
            }
        }
    ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
