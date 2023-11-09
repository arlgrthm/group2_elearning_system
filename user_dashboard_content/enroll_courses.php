    <title>My Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="necessities/main.css">

<div class="container enroll-container">
        <div class="mycourses-header">
            <div class="mycourses-contents">
                <h1>Enroll to Our Courses!</h1>
                <p>Explore and enroll in your favorite courses</p>
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
                    include('user_scripts/conn.php'); // Include your database connection file

                    if (isset($_POST['searchButton'])) {
                        $searchInput = $_POST['searchInput'];
                        $query = "SELECT * FROM courses WHERE course_name LIKE '%$searchInput%'";
                    } else {
                        $query = "SELECT * FROM courses";
                    }

                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<div class="col-md-4 mb-4">';
                            echo '<div class="card mb-4">';
                            echo '<img src="./admin_dashboard_content/admin_scripts/' . $row['course_thumbnail_image'] . '" class="card-img-top" alt="' . $row['course_name'] . '">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . $row['course_name'] . '</h5>';
                            echo '<p class="card-text">Difficulty: ' . $row['course_difficulty'] . '</p>';
                            echo '<a href="#" class="btn btn-primary enroll-button" data-course-id="' . $row['course_id'] . '">Enroll Now</a>';
                            echo '<a href="#" class="btn btn-success btn-view-course" data-course-id="' . $row['course_id'] . '" data-toggle="modal" data-target="#viewCourseModal">View Course</a>
                            ';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        // Use Bootstrap alert for no courses found and center it
                        echo '<div class="centered-alert alert alert-warning">No courses found.</div>';
                    }

                    mysqli_close($conn);
                    ?>
                </div>
            </div>
        </div>
    </div>


        <!-- Modal for View Course Content -->
        <div class="modal fade" id="viewCourseModal" tabindex="-1" role="dialog" aria-labelledby="viewCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCourseModalLabel">View Course Overview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Tabs for Course and Modules -->
                <ul class="nav nav-tabs" id="courseTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="course-tab" data-toggle="tab" href="#course" role="tab" aria-controls="course" aria-selected="true">Course</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="modules-tab" data-toggle="tab" href="#modules" role="tab" aria-controls="modules" aria-selected="false">Modules</a>
                    </li>
                </ul>
                <div class="tab-content" id="courseTabsContent">
                    <!-- Course Tab -->
                    <div class="tab-pane fade show active" id="course" role="tabpanel" aria-labelledby="course-tab">
                        <div id="view_course_panel"></div>
                    </div>

                    <!-- Module Tab -->
                    <div class="tab-pane fade" id="modules" role="tabpanel" aria-labelledby="modules-tab" class="scrollable-tab-content">
                        <div id="view_module_panel" class="view-module-panel-scroll"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    $(document).ready(function() {
        $(".enroll-button").click(function() {
            var courseID = $(this).data('course-id');

            // Create an AJAX request
            $.ajax({
                type: "POST",
                url: "user_dashboard_content/user_scripts/enroll.php", // Replace with the path to your server-side PHP file
                data: { course_id: courseID },
                success: function(response) {
                    response = JSON.parse(response);
                    if (response.success) {
                        $("#enrollmentSuccessMessage").html(response.message);
                        $("#enrollmentSuccessMessage").show();
                        $("#enrollmentErrorMessage").hide();
                    } else {
                        $("#enrollmentErrorMessage").html(response.message);
                        $("#enrollmentErrorMessage").show();
                        $("#enrollmentSuccessMessage").hide();
                    }
                },
                error: function(xhr, status, error) {
                    var errorMessage = "An error occurred while enrolling in the course. " + error;
                    $("#enrollmentErrorMessage").html(errorMessage);
                    $("#enrollmentErrorMessage").show();
                    $("#enrollmentSuccessMessage").hide();
                }
            });
        });
    });

     // Handle the "View Course" button click
     $('.btn-view-course').click(function () {
        var courseId = $(this).data('course-id');
        // Make an AJAX request to fetch course data
        $.ajax({
            type: 'POST',
            url: 'user_dashboard_content/user_scripts/get_course_details.php', // Create this PHP file to fetch course data by ID
            data: { course_id: courseId },
            success: function (response) {
                // Parse the response and populate the modal
                var courseData = JSON.parse(response);
                if (courseData.status === 'success') {
                    // Populate the modal with course data
                    $('#view_course_panel').html(courseData.course_content);
                    $('#view_module_panel').html(courseData.module_content);
                } else {
                    // Handle any error
                    // You can show an error message or do something else here
                }
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
        });
    </script>