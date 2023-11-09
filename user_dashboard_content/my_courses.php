    <title>My Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="necessities/main.css">
    
    <div class="container enroll-container">
        <div class="mycourses-header">
            <div class="mycourses-contents">
                <h1>Welcome to My Courses</h1>
                <p> we extend our warmest welcome to you, inviting you to embark on a lifelong journey of learning, where every course you undertake brings you one step closer to realizing your full potential.</p>
            </div>
            <img src="https://www.pngkit.com/png/full/9-90193_student-studying-png-jpg-black-and-white-library.png" alt="">
        </div>

        <!-- Search Bar -->
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="">
                    <div class="input-group mt-3">
                        <input type="text" name="searchInput" class="form-control" placeholder="Search for courses...">
                        <div class="input-group-append">
                            <button type="submit" name="searchButton" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Display the success/error message here -->
        <div class="alert alert-success mt-2" id="enrollmentSuccessMessage" style="display: none;"></div>
        <div class="alert alert-danger mt-2" id="enrollmentErrorMessage" style="display: none;"></div>

        <!-- Display All courses -->
        <div class="row">
            <div class="col-md-12 mt-3">
                <div id="course-container" class="row">
                <?php
                    // Include your database connection
                    require 'user_scripts/conn.php';

                    // Check if the user is logged in
                    if (isset($_SESSION['user_id'])) {
                    $userId = $_SESSION['user_id'];

                    // Query to get the enrolled courses for the current user
                    $query = "SELECT courses.course_id, course_thumbnail_image, course_name, course_instructor, course_difficulty, course_description FROM enrollments INNER JOIN courses ON enrollments.course_id = courses.course_id WHERE enrollments.user_id = $userId";

                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Generate a Bootstrap card for each enrolled course
                            echo '<div class="col-md-4 mb-3">';
                            echo '<div class="card">';
                            echo '<img src="./admin_dashboard_content/admin_scripts/' . $row['course_thumbnail_image'] . '" class="card-img-top" alt="' . $row['course_name'] . '">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $row['course_name'] . '</h5>';
                            echo '<p class="card-text">Difficulty: ' . $row['course_difficulty'] . '</p>';
                            echo '<a href="user_dashboard.php?page=course&course_id=' . $row['course_id'] . '" class="btn btn-primary start-learning-button">Start Learning</a>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        // Display an alert if the user is not enrolled in any course
                        echo '<div class="alert alert-info">You have not enrolled in any course yet.</div>';
                    }
                    } else {
                        echo '<div class="alert alert-warning">Please log in to view your enrolled courses.</div>';
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>

                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>