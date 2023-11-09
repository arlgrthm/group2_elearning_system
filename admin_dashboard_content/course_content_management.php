<div class="container">
    <h1 class="title">Course Content Management</h1>

    <div class="course-management-button-container">
        <button class="course-add-button" data-toggle="modal" data-target="#addCourseModal">Add a Course</button>
        <button class="course-add-button" data-toggle="modal" data-target="#addLessonReadingModal">Add a Lesson - Reading Content</button>
        <button class="course-add-button" data-toggle="modal" data-target="#addLessonVideoModal">Add a Lesson - Video Content</button>
        <button class="course-add-button" data-toggle="modal" data-target="#addQuizDetailsModal">Add a Quiz to a Lesson - Quiz Details</button>
        <button class="course-add-button" data-toggle="modal" data-target="#addQuizQuestionModal">Add a Quiz Questions to a Quiz</button>
    </div>

    <div class="table-selection">
    <label for="table-selector">Select a table:</label>
    <select id="table-selector">
        <option value="courses">List of Courses</option>
        <option value="lesson_videos">List of Lesson Videos</option>
        <option value="lesson_readings">List of Lesson Readings</option>
    </select>
    </div>

    <div class="table-management main-content courses">
        <div class="table-header-row user-management">
            <h5>List of Courses (<span class="user-count">100</span>)</h5>
            <div class="table-header-search">
                <input type="text" class="search-input" placeholder="Search a Course...">
                <button class="search-button"><i class="fas fa-search"></i></button>
            </div>
            <div class="table-header-buttons">
                <button class="filter-button"><i class="fas fa-arrow-up"></i> Filter</button>
            </div>
        </div>
        

        <div class="table-container courses-table">
            <table class="admin-data-table">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Thumbnail Image</th>
                        <th>Course Name</th>
                        <th>Instructor</th>
                        <th>Course Difficulty</th>
                        <th>Course Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include your database connection file (conn.php)
                    include('./necessities/conn.php');

                    // Query to fetch data from the 'courses' table
                    $query = "SELECT course_id, course_thumbnail_image, course_name, course_instructor, course_difficulty, course_date_creation FROM courses";
                    $result = mysqli_query($conn, $query);

                    // Check if there are any results
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['course_id'] . '</td>';
                            echo '<td><img src="admin_dashboard_content/admin_scripts/' . $row['course_thumbnail_image'] . '" alt="Course Thumbnail Image"></td>';
                            echo '<td>' . $row['course_name'] . '</td>';
                            echo '<td>' . $row['course_instructor'] . '</td>';
                            echo '<td>' . $row['course_difficulty'] . '</td>';
                            echo '<td>' . $row['course_date_creation'] . '</td>';
                            echo '<td>';
                            echo '<button class="action-button view-button view-course-button" data-toggle="modal" data-target="#viewCourseModal" data-course-id="' . $row['course_id'] . '"><i class="fas fa-eye"></i></button>';
                            echo '<button class="action-button edit-course-button" data-toggle="modal" data-target="#editCourseModal" data-course-id="' . $row['course_id'] . '"><i class="fas fa-edit"></i></button>';
                            echo '<button class="action-button delete-button"><i class="fas fa-trash"></i></button>';

                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        // Handle the case where there are no records in the database
                        echo '<tr><td colspan="7">No records found.</td></tr>';
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Lesson Videos Table -->
    <div class="table-management main-content lesson_videos">
        <div class="table-header-row user-management">
            <h5>List of Lesson Videos (<span class="user-count">20</span>)</h5>
            <div class="table-header-search">
                <input type="text" class="search-input" placeholder="Search a Lesson...">
                <button class="search-button"><i class="fas fa-search"></i></button>
            </div>
            <div class="table-header-buttons">
                <button class="filter-button"><i class="fas fa-arrow-up"></i> Filter</button>
            </div>
        </div>

        <div class="table-container lesson-videos-table">
            <table class="admin-data-table">
                <thead>
                    <tr>
                        <th>Lesson Video ID</th>
                        <th>Lesson Video Title</th>
                        <th>Course Name</th>
                        <th>Lesson Video Number</th>
                        <th>Lesson Date Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include your database connection file (conn.php)
                    include('./necessities/conn.php');

                    // Query to fetch data from the 'lesson_video' table with a JOIN to get course names
                    $query = "SELECT lv.lesson_video_id, lv.course_id, lv.lesson_video_title, lv.lesson_video_number, lv.lesson_video_date_creation, c.course_name
                        FROM lesson_video lv
                        JOIN courses c ON lv.course_id = c.course_id";
                        $result = mysqli_query($conn, $query);;

                    // Check if there are any results
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['lesson_video_id'] . '</td>';
                            echo '<td>' . $row['lesson_video_title'] . '</td>';
                            echo '<td>' . $row['course_name'] . '</td>';
                            echo '<td>' . $row['lesson_video_number'] . '</td>';
                            echo '<td>' . $row['lesson_video_date_creation'] . '</td>';
                            echo '<td>';
                            echo '<button class="action-button view-lesson-button" data-toggle="modal" data-target="#viewLessonModal" data-lesson-id="' . $row['lesson_video_id'] . '"><i class="fas fa-eye"></i></button>';
                            echo '<button class="action-button edit-lesson-button" data-toggle="modal" data-target="#editLessonModal" data-lesson-id="' . $row['lesson_video_id'] . '"><i class="fas fa-edit"></i></button>';
                            echo '<button class="action-button delete-button" data-lesson-id="' . $row['lesson_video_id'] . '"><i class="fas fa-trash"></i></button>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        // Handle the case where there are no records in the database
                        echo '<tr><td colspan="7">No records found.</td></tr>';
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Lessons Reading Table -->
    <div class="table-management main-content lesson_readings">
        <div class="table-header-row user-management">
            <h5>List of Lesson Reading (<span class="user-count">20</span>)</h5>
            <div class="table-header-search">
                <input type="text" class="search-input" placeholder="Search a Lesson Reading...">
                <button class="search-button"><i class="fas fa-search"></i></button>
            </div>
            <div class="table-header-buttons">
                <button class="filter-button"><i class="fas fa-arrow-up"></i> Filter</button>
            </div>
        </div>

        <div class="table-container mt-2 lesson-readings-table">
            <table class="admin-data-table">
                <thead>
                    <tr>
                        <th>Lesson Reading ID</th>
                        <th>Lesson Reading Title</th>
                        <th>Course Name</th>
                        <th>Lesson Reading Number</th>
                        <th>Lesson Date Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include your database connection file (conn.php)
                    include('./necessities/conn.php');

                    // Query to fetch data from the 'lesson_reading' table with a JOIN to get course names
                    $query = "SELECT lr.lesson_reading_id, lr.course_id, lr.lesson_reading_title, lr.lesson_reading_number, lr.lesson_reading_date_creation, c.course_name
                        FROM lesson_reading lr
                        JOIN courses c ON lr.course_id = c.course_id";
                        $result = mysqli_query($conn, $query);


                    // Check if there are any results
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>' . $row['lesson_reading_id'] . '</td>';
                            echo '<td>' . $row['lesson_reading_title'] . '</td>';
                            echo '<td>' . $row['course_name'] . '</td>';
                            echo '<td>' . $row['lesson_reading_number'] . '</td>';
                            echo '<td>' . $row['lesson_reading_date_creation'] . '</td>';
                            echo '<td>';
                            echo '<button class="action-button view-lesson-button" data-toggle="modal" data-target="#viewLessonModal" data-lesson-id="' . $row['lesson_reading_id'] . '"><i class="fas fa-eye"></i></button>';
                            echo '<button class="action-button edit-lesson-button" data-toggle="modal" data-target="#editLessonModal" data-lesson-id="' . $row['lesson_reading_id'] . '"><i class="fas fa-edit"></i></button>';
                            echo '<button class="action-button delete-button" data-lesson-id="' . $row['lesson_reading_id'] . '"><i class="fas fa-trash"></i></button>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    } else {
                        // Handle the case where there are no records in the database
                        echo '<tr><td colspan="7">No records found.</td></tr>';
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <!-- Lessons Table
    <div class="table-management main-content mt-5">
        <div class="table-header-row user-management">
            <h5>List of Lesson Reading (<span class="user-count">20</span>)</h5>
            <div class="table-header-search">
                <input type="text" class="search-input" placeholder="Search a Lesson Reading...">
                <button class="search-button"><i class="fas fa-search"></i></button>
            </div>
            <div class="table-header-buttons">
                <button class="filter-button"><i class="fas fa-arrow-up"></i> Filter</button>
            </div>
        </div> -->

        <!-- <div class="table-container mt-2">
            <table class="admin-data-table">
                <thead>
                    <tr>
                        <th>Quiz ID</th>
                        <th>Lesson Video Title</th>
                        <th>Lesson Video Number</th>
                        <th>Lesson Date Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // // Include your database connection file (conn.php)
                    // include('./necessities/conn.php');

                    // // Query to fetch data from the 'lessons' table
                    // $query = "SELECT lesson_reading_id, lesson_reading_title, lesson_reading_number, lesson_reading_date_creation FROM lesson_reading";
                    // $result = mysqli_query($conn, $query);

                    // // Check if there are any results
                    // if (mysqli_num_rows($result) > 0) {
                    //     while ($row = mysqli_fetch_assoc($result)) {
                    //         echo '<tr>';
                    //         echo '<td>' . $row['lesson_reading_id'] . '</td>';
                    //         echo '<td>' . $row['lesson_reading_title'] . '</td>';
                    //         echo '<td>' . $row['lesson_reading_number'] . '</td>';
                    //         echo '<td>' . $row['lesson_reading_date_creation'] . '</td>';
                    //         echo '<td>';
                    //         echo '<button class="action-button view-lesson-button" data-toggle="modal" data-target="#viewLessonModal" data-lesson-id="' . $row['lesson_reading_id'] . '">View Full Lesson Content</button>';
                    //         echo '<button class="action-button edit-lesson-button" data-toggle="modal" data-target="#editLessonModal" data-lesson-id="' . $row['lesson_reading_id'] . '">Edit Lesson</button>';
                    //         echo '<button class="action-button delete-button">Delete Lesson</button>';
                    //         echo '</td>';
                    //         echo '</tr>';
                    //     }
                    // } else {
                    //     // Handle the case where there are no records in the database
                    //     echo '<tr><td colspan="7">No records found.</td></tr>';
                    // }

                    // // Close the database connection
                    // mysqli_close($conn);
                    ?>
                </tbody>
            </table>
        </div>
    </div> -->
    </div>


    

    <!--Modals-->
    <!-- View Course Modal -->
    <div class="modal fade" id="viewCourseModal" tabindex="-1" role="dialog" aria-labelledby="viewCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewCourseModalLabel">Course Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6">
                            <img id="courseThumbnail" src="" alt="Course Thumbnail" class="img-fluid">
                        </div>
                        <div class="col-lg-6">
                            <h2 id="courseName"></h2>
                            <p><strong>Instructor:</strong> <span id="courseInstructor"></span></p>
                            <p><strong>Difficulty:</strong> <span id="courseDifficulty"></span></p>
                            <p><strong>Course Created:</strong> <span id="courseDateCreation"></span></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h4>Course Description</h4>
                            <p id="courseDescription"></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h4>Objectives</h4>
                            <p id="objectives"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Edit Course Modal -->
    <div class="modal fade" id="editCourseModal" tabindex="-1" role="dialog" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" id="editCourseSuccessMessage" style="display: none;"></div>
                <div class="alert alert-danger" id="editCourseErrorMessage" style="display: none;"></div>
                <form id="editCourseForm" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="editCourseName">Course Name</label>
                        <input type="text" class="form-control" id="editCourseName" name="editCourseName">
                    </div>
                    <div class="form-group">
                        <label for="editCourseInstructor">Instructor</label>
                        <input type="text" class="form-control" id="editCourseInstructor" name="editCourseInstructor">
                    </div>
                    <div class="form-group">
                        <label for="editCourseDifficulty">Difficulty</label>
                        <select class="form-control" id="editCourseDifficulty" name="editCourseDifficulty">
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="editCourseDescription">Course Description</label>
                        <textarea class="form-control" id="editCourseDescription" name="editCourseDescription" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editObjectives">Objectives</label>
                        <textarea class="form-control" id="editObjectives" name="editObjectives" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="editCourseThumbnail">Course Thumbnail</label>
                        <input type="file" class="form-control-file" id="editCourseThumbnail" name="editCourseThumbnail">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveEditCourse">Save Changes</button>
            </div>
        </div>
    </div>
    </div>



    <!-- Modal for Add a Course -->
    <div class="modal fade" id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCourseModalLabel">Add a Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" id="courseSuccessMessage" style="display: none;"></div>
                <div class="alert alert-danger" id="courseErrorMessage" style="display: none;"></div>
                <form id="courseForm">
                    <div class="form-group">
                        <label for="course_name">Course Name</label>
                        <input type="text" class="form-control" id="course_name" name="course_name" placeholder="Enter the Course Name">
                    </div>
                    <div class="form-group">
                        <label for="course_instructor">Course Instructor</label>
                        <input type="text" class="form-control" id="course_instructor" name="course_instructor" placeholder="Enter the Course Instructor" required>
                    </div>
                    <div class="form-group">
                        <label for="course_difficulty">Course Difficulty</label>
                        <select class="form-control" id="course_difficulty" name="course_difficulty">
                            <option value="">Select One</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="course_description">Course Description</label>
                        <textarea class="form-control" id="course_description" name="course_description" placeholder="Enter the Brief Overview/Description of the Course" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="objectives">Objectives</label>
                        <textarea class="form-control" id="objectives" name="objectives" placeholder="Enter the Objectives of the Course" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="course_thumbnail">Course Thumbnail Image</label>
                        <input type="file" class="form-control-file" id="course_thumbnail" name="course_thumbnail">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addNewCourse">Add Course</button>
            </div>
        </div>
    </div>
    </div>

    

    <!-- Modal for Add a Lesson - Reading (with Rich Text Editor) -->
    <div class="modal fade" id="addLessonReadingModal" tabindex="-1" role="dialog" aria-labelledby="addLessonReadingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLessonReadingModalLabel">Add a Lesson - Reading</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" id="lessonSuccessMessage" style="display: none;"></div>
                <div class="alert alert-danger" id="lessonErrorMessage" style="display: none;"></div>
                <form id="lessonReadingForm">
                    <div class="form-group">
                        <label for="course_selector_for_lesson">Select a Course</label>
                            <select class="form-control" id="course_selector_for_lesson" name="course_selector_for_lesson">
                                <option value="">Select One</option>
                                <?php
                                    // Include your database connection file (conn.php)
                                        include('admin_dashboard_content/admin_scripts/conn.php');

                                    // Query to fetch course data (including course ID)
                                        $courseQuery = "SELECT course_id, course_name FROM courses";
                                        $courseResult = mysqli_query($conn, $courseQuery);

                                    // Check if there are any results
                                        if (mysqli_num_rows($courseResult) > 0) {
                                            while ($courseRow = mysqli_fetch_assoc($courseResult)) {
                                            echo '<option value="' . $courseRow['course_id'] . '">' . $courseRow['course_name'] . '</option>';
                                        }
                                    }

                                    // Close the database connection
                                    mysqli_close($conn);
                                ?>
                            </select>
                        </div>
                    <div class="form-group">
                        <label for="lesson_reading_title">Lesson Reading Title</label>
                        <input type="text" class="form-control" id="lesson_reading_title" name="lesson_reading_title" placeholder="Enter the Lesson Title" required>
                    </div>
                    <div class="form-group">
                        <label for="lesson_reading_number">Lesson Reading Number</label>
                        <input type="number" class="form-control" id="lesson_reading_number" name="lesson_reading_number" placeholder="Enter the Lesson Number" required>
                    </div>
                    <div class="form-group">
                        <label for="lesson_content">Lesson Content</label>
                            <div id="lesson-content-editor"></div>
                            <input type="hidden" id="lesson_content" name="lesson_content">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addNewReadingLesson">Add Lesson</button>
            </div>
        </div>
    </div>
    </div>


    <!-- Modal for Add a Lesson - Video Content -->
    <div class="modal fade" id="addLessonVideoModal" tabindex="-1" role="dialog" aria-labelledby="addLessonVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLessonVideoModalLabel">Add a Lesson - Video Content</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" id="lessonVideoSuccessMessage" style="display: none;"></div>
                <div class="alert alert-danger" id="lessonVideoErrorMessage" style="display: none;"></div>
                <form id="lessonVideoForm">
                    <div class="form-group">
                        <label for="course_selector_for_video">Select a Course</label>
                            <select class="form-control" id="course_selector_for_video" name="course_selector_for_video">
                                <option value="">Select One</option>
                                <?php
                                    // Include your database connection file (conn.php)
                                        include('admin_dashboard_content/admin_scripts/conn.php');

                                    // Query to fetch course data (including course ID)
                                        $courseQuery = "SELECT course_id, course_name FROM courses";
                                        $courseResult = mysqli_query($conn, $courseQuery);

                                    // Check if there are any results
                                        if (mysqli_num_rows($courseResult) > 0) {
                                            while ($courseRow = mysqli_fetch_assoc($courseResult)) {
                                            echo '<option value="' . $courseRow['course_id'] . '">' . $courseRow['course_name'] . '</option>';
                                        }
                                    }

                                    // Close the database connection
                                    mysqli_close($conn);
                                ?>
                            </select>
                        </div>

                    <!--Display all the Lesson - Video Content Available-->
                        <div id="lessonVideoList"></div>

                    <div class="form-group">
                        <label for="lesson_video_title">Lesson Video Title</label>
                        <input type="text" class="form-control" id="lesson_video_title" name="lesson_video_title" placeholder="Enter the Lesson Title" required>
                    </div>

                    <div class="form-group">
                        <label for="lesson_video_number">Lesson Video Number</label>
                        <input type="text" class="form-control" id="lesson_video_number" name="lesson_video_number" placeholder="Enter the Lesson Video Number" required>
                    </div>

                    <div class="form-group">
                        <label for="content_source">Select Video Content Source:</label>
                            <select class="form-control" id="content_source" name="content_source">
                                <option value="video_url">Video URL</option>
                                <option value="video_file">Video File (Local)</option>
                            </select>
                    </div>

                    <div class="form-group" id="video_url_input">
                        <label for="lesson_video_link">Lesson Video URL</label>
                            <input type="text" class="form-control" id="lesson_video_link" name="lesson_video_link" placeholder="Enter the Lesson Video URL">
                    </div>

                    <div class="form-group" id="video_file_input" style="display: none;">
                        <label for="lesson_video_link">Lesson Video File (Local)</label>
                            <input type="file" class="form-control" id="lesson_video_link" name="lesson_video_link">
                    </div>

                    <div class="form-group">
                        <label for="lesson_video_transcription">Lesson Video Transcription</label>
                        <div id="lesson-video-transcription-editor"></div>
                        <input type="hidden" id="lesson_video_transcription" name="lesson_video_transcription">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addNewVideoLesson">Add Video Lesson</button>
            </div>
        </div>
    </div>
    </div>

    <div class="modal fade" id="addQuizDetailsModal" tabindex="-1" role="dialog" aria-labelledby="addQuizDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuizDetailsModalLabel">Add a Quiz - Quiz Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="quizDetailsForm">
                    <div class="alert alert-success" id="addQuizDetailsSuccessMessage" style="display: none;"></div>
                    <div class="alert alert-danger" id="addQuizDetailsErrorMessage" style="display: none;">
                    </div>
                    <div class="form-group">
                        <label for="course_selection_for_quiz">Select a Course to Add a Quiz</label>
                        <select class="form-control" id="course_selection_for_quiz" name="course_selection_for_quiz">
                            <option value="">Select One</option>
                            <?php
                            // Include your database connection file (conn.php)
                            include('admin_dashboard_content/admin_scripts/conn.php');

                            // Query to fetch course data (including course ID)
                            $courseQuery = "SELECT course_id, course_name FROM courses";
                            $courseResult = mysqli_query($conn, $courseQuery);

                            // Check if there are any results
                            if (mysqli_num_rows($courseResult) > 0) {
                                while ($courseRow = mysqli_fetch_assoc($courseResult)) {
                                    echo '<option value="' . $courseRow['course_id'] . '">' . $courseRow['course_name'] . '</option>';
                                }
                            }

                            // Close the database connection
                            mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quizName">Quiz Name</label>
                        <input type="text" class="form-control" id="quizName" name="quizName" placeholder="Enter Quiz Name">
                    </div>
                    <div class="form-group">
                        <label for="quizInstructions">Instructions</label>
                        <textarea class="form-control" id="quizInstructions" name="quizInstructions" placeholder="Enter Quiz Instructions"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="passingScore">Passing Score</label>
                        <input type="number" class="form-control" id="passingScore" name="passingScore" placeholder="Enter Passing Score">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="addQuizDetails">Add Quiz Details</button>
                    </div>
                </form> <!-- Quiz Details (moved inside the form) -->
            </div>
        </div>
    </div>
</div>


    <div class="modal fade" id="addQuizQuestionModal" tabindex="-1" role="dialog" aria-labelledby="addQuizQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addQuizQuestionModalLabel">Add Multiple Choice Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="questionForm">
                <div class="alert alert-success" id="addQuizQuestionSuccessMessage" style="display: none;"></div>
                <div class="alert alert-danger" id="addQuizQuestionErrorMessage" style="display: none;"></div>
                <div class="form-group">
                        <label for="quiz_selector">Select a Quiz to add Question/s</label>
                        <select class="form-control" id="quiz_selector" name="quiz_selector">
                            <option value="">Select One</option>
                            <?php
                            // Include your database connection file (conn.php)
                            include('admin_dashboard_content/admin_scripts/conn.php');

                            // Query to fetch course data (including course ID)
                            $quizQuery = "SELECT quiz_id, quiz_name FROM quiz_details";
                            $quizResult = mysqli_query($conn, $quizQuery);

                            // Check if there are any results
                            if (mysqli_num_rows($quizResult) > 0) {
                                while ($quizRow = mysqli_fetch_assoc($quizResult)) {
                                    echo '<option value="' . $quizRow['quiz_id'] . '">' . $quizRow['quiz_name'] . '</option>';
                                }
                            }

                            // Close the database connection
                            mysqli_close($conn);
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="questionNumber">Question Number</label>
                        <input type="number" class="form-control" id="questionNumber" name="questionNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="questionText">Question Text</label>
                        <input type="text" class="form-control" id="questionText" name="questionText" required>
                    </div>
                    <div class="form-group">
                        <label for="optionA">Option A</label>
                        <input type="text" class="form-control" id="optionA" name="optionA" required>
                    </div>
                    <div class="form-group">
                        <label for="optionB">Option B</label>
                        <input type="text" class="form-control" id="optionB" name="optionB" required>
                    </div>
                    <div class="form-group">
                        <label for="optionC">Option C</label>
                        <input type="text" class="form-control" id="optionC" name="optionC" required>
                    </div>
                    <div class="form-group">
                        <label for="optionD">Option D</label>
                        <input type="text" class="form-control" id="optionD" name="optionD" required>
                    </div>
                    <div class="form-group">
                        <label for="correctAnswer">Correct Answer</label>
                        <select class="form-control" id="correctAnswer" name="correctAnswer" required>
                            <option value="A">Option A</option>
                            <option value="B">Option B</option>
                            <option value="C">Option C</option>
                            <option value="D">Option D</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addQuizQuestion">Add Question</button>
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

                    <!-- Lessons Reading Tab -->
                    <div class="tab-pane fade" id="lessons" role="tabpanel" aria-labelledby="modules-tab" class="scrollable-tab-content">
                        <div id="view_module_panel" class="view-module-panel-scroll"></div>
                    </div>

                    <!-- Lessons Reading Tab -->
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


    <div class="modal fade" id="editCourseModal" tabindex="-1" role="dialog" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Course Details Section -->
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">Edit Course Details</h5>
                <!-- ... Course details input fields ... -->
            </div>

            <!-- Modules Section -->
            <div class="modal-body">
                <h5>Edit Modules</h5>
                <button id="addModuleButton">Add Module</button>
                <!-- List of modules with edit and delete buttons -->
            </div>

            <!-- Lessons Section -->
            <div class="modal-body">
                <h5>Edit Lessons</h5>
                <!-- Separate sections for reading and video lessons -->
                <button id="addReadingLessonButton">Add Reading Lesson</button>
                <button id="addVideoLessonButton">Add Video Lesson</button>
                <!-- List of lessons with edit and delete buttons -->
            </div>

            <!-- Quizzes Section -->
            <div class="modal-body">
                <h5>Edit Quizzes</h5>
                <button id="addQuizButton">Add Quiz</button>
                <!-- List of quizzes with edit and delete buttons -->
            </div>
            
            <!-- Save and Close Buttons -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveChangesButton">Save Changes</button>
            </div>
        </div>
    </div>
    </div>






  

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
    var $j = jQuery.noConflict();

    $j(document).ready(function () {

    const tableSelector = document.getElementById('table-selector');

    // Function to hide all table sections
    function hideAllTables() {
        const tableSections = document.querySelectorAll('.table-management.main-content');
        tableSections.forEach((section) => {
            section.style.display = 'none';
        });
    }

        // Initial setup: hide all tables except the selected one (Courses)
        hideAllTables();
            const selectedTable = tableSelector.value; // Courses
            const selectedTableSection = document.querySelector(`.${selectedTable}`);
            selectedTableSection.style.display = 'block';

        // Show the selected table when the user changes the selection
        tableSelector.addEventListener('change', function () {
            hideAllTables(); // Hide all tables
            const selectedTable = tableSelector.value;
            const selectedTableSection = document.querySelector(`.${selectedTable}`);
            selectedTableSection.style.display = 'block';
        });

    // Function to set up search functionality for a table
    function setupTableSearch(tableClass) {
        const searchInput = document.querySelector(`.table-management.main-content.${tableClass} .search-input`);
        const tableRows = document.querySelectorAll(`.table-management.main-content.${tableClass} table.admin-data-table tbody tr`);

        searchInput.addEventListener('input', function () {
            const searchTerm = searchInput.value.toLowerCase();
            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? 'table-row' : 'none';
            });
        });
    }

    // Set up search functionality for each table
    setupTableSearch('courses');
    setupTableSearch('lesson_videos');
    setupTableSearch('lesson_readings');


    // Get the elements with the class "user-count"
    const userCountElements = document.querySelectorAll(".user-count");

    // Loop through each user count element and update its content
    userCountElements.forEach(function(element) {
      const table = element.closest(".main-content");
      const courseCount = table.querySelectorAll("tbody tr").length;
      element.textContent = courseCount;
    });

        // Function to handle success and error responses
        function handleResponse(response, successElement, errorElement) {
            response = JSON.parse(response);

            if (response.status === "success") {
                //Success messages
                successElement.text(response.message);
                successElement.show();
                errorElement.hide(); 
            } else {
                //Error messages
                errorElement.text(response.message);
                errorElement.show();
                successElement.hide()
            }
        }

       /* Handles form validation and AJAX submission for adding new courses. */
        $j('#addNewCourse').click(function (e) {
            e.preventDefault();

                // Clear error messages
                $j('#courseErrorMessage').empty();

                var formData = new FormData($('#courseForm')[0]);
                // Validate and show specific errors
                var isValid = true;


                // FORM VALIDATIONS
                // Course Name
                var courseName = $j.trim($j('#course_name').val());
                if (courseName === '') {
                    $j('#courseErrorMessage').append('<p><span style="font-weight: bold;">Course name</span> is required.</p>');
                    isValid = false;
                } else if (!/^[A-Za-z]/.test(courseName)) {
                    $j('#courseErrorMessage').append('<p><span style="font-weight: bold;">Course name</span> is invalid. It must not start with a number or symbol.</p>');
                    isValid = false;
                }

                // Course Instructor
                var courseInstructor = $j.trim($j('#course_instructor').val());
                if (courseInstructor === '') {
                    $j('#courseErrorMessage').append('<p><span style="font-weight: bold;">Course instructor</span> is required.</p>');
                    isValid = false;
                } else if (!/^[A-Za-z]/.test(courseInstructor)) {
                    $j('#courseErrorMessage').append('<p><span style="font-weight: bold;">Course instructor</span> is invalid. It must not start with a number or symbol.</p>');
                    isValid = false;
                }

                // Course Difficulty
                var courseDifficulty = $j.trim($j('#course_difficulty').val());
                if (courseDifficulty === '') {
                    $j('#courseErrorMessage').append('<p><span style="font-weight: bold;">Course difficulty</span> is required.</p>');
                    isValid = false;
                }

                // Course Description
                var courseDescription = $j.trim($j('#course_description').val());
                if (courseDescription === '') {
                    $j('#courseErrorMessage').append('<p><span style="font-weight: bold;">Course description</span> is required.</p>');
                    isValid = false;
                }

                // Course Description
                var objectives= $j.trim($j('#objectives').val());
                if (objectives === '') {
                    $j('#courseErrorMessage').append('<p><span style="font-weight: bold;">Objectives</span> is required.</p>');
                    isValid = false;
                }

                // Course Thumbnail
                var courseThumbnail = $j('#course_thumbnail')[0].files;

                if (courseThumbnail.length === 0) {
                    $j('#courseErrorMessage').append('<p><span style="font-weight: bold;">Course thumbnail</span> is required.</p>');
                    isValid = false;
                } else if (courseThumbnail.length > 1) {
                    $j('#courseErrorMessage').append('<p>Only one course thumbnail is allowed.</p>');
                    isValid = false;
                } else {
                    var allowedExtensions = ["jpg", "jpeg", "png", "svg"]; // Add allowed file extensions
                    var fileExtension = courseThumbnail[0].name.split('.').pop().toLowerCase();

                    if (allowedExtensions.indexOf(fileExtension) === -1) {
                        $j('#courseErrorMessage').append('<p><span style="font-weight: bold;">Course Thumbnail</span> > Invalid file format. Allowed formats: ' + allowedExtensions.join(', ') + '.</p>');
                        isValid = false;
                    }
                }

                if (!isValid) {
                    $j('#courseErrorMessage').show();
                    return;
                }

            $j.ajax({
                type: 'POST',
                url: 'admin_dashboard_content/admin_scripts/add_course.php',
                data: formData,
                processData: false,
                contentType: false,

                success: function (response) {
                    handleResponse(response, $j('#courseSuccessMessage'), $j('#courseErrorMessage'));
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        });


        $j(".view-course-button").click(function () {
            var course_id = $j(this).data("course-id");

        $j.ajax({
            url: 'admin_dashboard_content/admin_scripts/get_course_details.php', // Replace with the actual URL to fetch course details
            type: 'POST',
            data: { course_id: course_id },
            success: function (response) {
                // Parse the response and update the modal content
                var courseDetails = JSON.parse(response);

                $j("#courseThumbnail").attr("src", courseDetails.course_thumbnail_image);
                $j("#courseName").text(courseDetails.course_name);
                $j("#courseInstructor").text(courseDetails.course_instructor);
                $j("#courseDifficulty").text(courseDetails.course_difficulty);
                $j("#courseDateCreation").text(courseDetails.course_date_creation);
                $j("#courseDescription").text(courseDetails.course_description);
                $j("#objectives").text(courseDetails.objectives);

                // Show the modal
                $j("#viewCourseModal").modal("show");
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + error);
            }
        });
        });

        $j(".edit-course-button").click(function () {
        var course_id = $j(this).data("course-id");

        $j("#course-id").val(course_id);

        $j.ajax({
        url: 'admin_dashboard_content/admin_scripts/edit_course.php',
        type: 'POST',
        data: { course_id: course_id },
        success: function (data) {
            var course = JSON.parse(data);

            // Populate the edit course modal fields
            $j("#editCourseName").val(course.course_name);
            $j("#editCourseInstructor").val(course.course_instructor);
            $j("#editCourseDifficulty").val(course.course_difficulty);
            $j("#editCourseDescription").val(course.course_description);
            $j("#editObjectives").val(course.objectives);

            // Display the course thumbnail if available
            if (course.course_thumbnail_image) {
                $j("#current-course-thumbnail").attr("src", course.course_thumbnail_image);
            } else {
                $j("#current-course-thumbnail").attr("src", ""); // Clear the image
            }

            // Show the modal
            $j("#editCourseModal").modal("show");
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + error);
        }
        });
        });

     // Save Changes button click handler
$j("#saveEditCourse").click(function () {
    var course_id = $j("#course-id").val();
    var editedCourseName = $j("#editCourseName").val();
    var editedCourseInstructor = $j("#editCourseInstructor").val();
    var editedCourseDifficulty = $j("#editCourseDifficulty").val();
    var editedCourseDescription = $j("#editCourseDescription").val();
    var editedObjectives = $j("#editObjectives").val();
    var editedCourseThumbnail = $j("#editCourseThumbnail")[0].files[0];

    console.log("course_id: " + course_id);
    console.log("editedCourseName: " + editedCourseName);
    console.log("editedCourseInstructor: " + editedCourseInstructor);
    console.log("editedCourseDifficulty: " + editedCourseDifficulty);
    console.log("editedCourseDescription: " + editedCourseDescription);
    console.log("editedObjectives: " + editedObjectives);

    var formData = new FormData();

    // Append course data to the FormData object
    formData.append('course_id', course_id);
    formData.append('editedCourseName', editedCourseName);
    formData.append('editedCourseInstructor', editedCourseInstructor);
    formData.append('editedCourseDifficulty', editedCourseDifficulty);
    formData.append('editedCourseDescription', editedCourseDescription);
    formData.append('editedObjectives', editedObjectives);

    // Append the course thumbnail only if a file is selected
    if (editedCourseThumbnail) {
        formData.append('editedCourseThumbnail', editedCourseThumbnail);
    }

    console.log("formData: ", formData);

    // Send the data to the PHP script for saving changes
    $j.ajax({
        url: 'admin_dashboard_content/admin_scripts/save-course-details.php', // Replace this with your actual PHP script
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            if (response === "success") {
                $j("#editCourseSuccessMessage").show();
                // Additional success actions like closing modal or refreshing course list
            } else {
                console.error("Update failed: " + response);
                $j("#editCourseErrorMessage").show();
            }
        },
        error: function (xhr, status, error) {
            console.error("AJAX Error: " + error);
            $j("#editCourseErrorMessage").show();
        }
    });
});



        /* Handles form validation and AJAX submission for adding new lessons for readings. */
        $j('#addNewReadingLesson').click(function (e) {
            e.preventDefault();

            // Clear previous error messages
            $j('#lessonErrorMessage').empty();

            // Perform form validation
            var isValid = true;
            var courseSelector = $j('#course_selector_for_lesson').val();
            var lessonTitle = $j.trim($j('#lesson_reading_title').val());
            var lessonNumber = $j('#lesson_reading_number').val();
            var lessonContent = quill.root.innerHTML; // Get Quill editor content

            // Course Selector validation
            if (courseSelector === '') {
                $j('#lessonErrorMessage').append('<p><span style="font-weight: bold;">Select a course</span> is required.</p>');
                isValid = false;
            }

            // Lesson Selector validation
            if (lessonNumber === '') {
                $j('#lessonErrorMessage').append('<p><span style="font-weight: bold;">Lesson Number</span> is required.</p>');
                isValid = false;
            }

            // Lesson Title validation
            if (lessonTitle === '') {
                $j('#lessonErrorMessage').append('<p><span style="font-weight: bold;">Lesson title</span> is required.</p>');
                isValid = false;
            } else if (/^[0-9!@#$%^&*]/.test(lessonTitle)) {
                $j('#lessonErrorMessage').append('<p><span style="font-weight: bold;">Lesson title</span> cannot start with numbers or special characters.</p>');
                isValid = false;
            }

            // Lesson Content Validations
            if (lessonContent.length > 20000) {
                $j('#lessonErrorMessage').append('<p><span style="font-weight: bold;">Lesson content</span> must not exceed 20000 characters.</p>');
                isValid = false;
            }

            // Character Encoding Validation
            if (!/^[\x00-\x7F]*$/.test(lessonContent)) {
                $j('#lessonErrorMessage').append('<p><span style="font-weight: bold;">Lesson content</span> must be in UTF-8 character encoding.</p>');
                isValid = false;
            }

             // Size Limitations (Images) Validation
            var formData = new FormData($('#lessonReadingForm')[0]);
            var imageSize = 0;

            if (formData.has('lesson_content')) {
                imageSize = formData.get('lesson_content').size;
            }

            if (imageSize > 5000000) {
                $j('#lessonErrorMessage').append('<p><span style="font-weight: bold;">Lesson content (images)</span> must be no larger than 5MB.</p>');
                isValid = false;
            }

            if (!isValid) {
                $j('#lessonErrorMessage').show();
                return;
            }

            // If all validations pass, proceed with AJAX submission
            formData.append('lesson_content', lessonContent);

            $j.ajax({
                type: 'POST',
                url: 'admin_dashboard_content/admin_scripts/add_lesson_reading.php',
                data: formData,
                processData: false,
                contentType: false,
                    success: function (response) {
                        handleResponse(response, $j('#lessonSuccessMessage'), $j('#lessonErrorMessage'));
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
            });
        });



        $('#content_source').change(function () {
            var selectedOption = $(this).val();
            if (selectedOption === "video_url") {
                $('#video_url_input').show();
                $('#video_file_input').hide();
            } else {
                $('#video_url_input').hide();
                $('#video_file_input').show();
            }
        });

        /* Handles form validation and AJAX submission for adding new lessons for videos. */
        $j('#addNewVideoLesson').click(function (e) {
            e.preventDefault();

            // Clear previous error messages
            $j('#lessonVideoErrorMessage').empty();

            // Perform form validation
            var isValid = true;
            var courseSelector = $j('#course_selector_for_video').val();
            var lessonTitle = $j.trim($j('#lesson_video_title').val());
            var lessonVideoNumber = $j('#lesson_video_number').val();
            var lessonContent = transcriptionQuill.root.innerHTML;

            // Additional validations for video-specific fields
            if ($j('#content_source').val() === 'video_url') {
                var lessonVideoLink = $j.trim($j('#lesson_video_link').val());
                if (lessonVideoLink === '') {
                    $j('#lessonVideoErrorMessage').append('<p><span style="font-weight: bold;">Video URL</span> is required.</p>');
                    isValid = false;
                }
                } else {
                    // File input validation for local video file
                    var lessonVideoFile = $j('#lesson_video_link')[0].files;
                    if (lessonVideoFile.length === 0) {
                        $j('#lessonVideoErrorMessage').append('<p><span style="font-weight: bold;">Video File (Local)</span> is required.</p>');
                        isValid = false;
                    }
                }

                // Common validations for all lesson videos
                if (courseSelector === '') {
                    $j('#lessonVideoErrorMessage').append('<p><span style="font-weight: bold;">Select a course</span> is required.</p>');
                    isValid = false;
                }
                if (lessonTitle === '') {
                    $j('#lessonVideoErrorMessage').append('<p><span style="font-weight: bold;">Lesson video title</span> is required.</p>');
                    isValid = false;
                } else if (/^[0-9!@#$%^&*]/.test(lessonTitle)) {
                    $j('#lessonVideoErrorMessage').append('<p><span style="font-weight: bold;">Lesson video title</span> cannot start with numbers or special characters.</p>');
                    isValid = false;
                }

                if (!isValid) {
                    $j('#lessonVideoErrorMessage').show();
                    return;
                }

                // If all validations pass, proceed with AJAX submission
                var formData = new FormData($('#lessonVideoForm')[0]);
                
                formData.append('lesson_video_transcription', lessonContent);

                $j.ajax({
                    type: 'POST',
                    url: 'admin_dashboard_content/admin_scripts/add_lesson_video.php',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        handleResponse(response, $j('#lessonVideoSuccessMessage'), $j('#lessonVideoErrorMessage'));
                    },
                    error: function (error) {
                        console.error('Error:', error);
                    }
                });
        });

    $j('#addQuizDetails').click(function (e) {
    e.preventDefault();

    // Clear any previous error messages
    $j('#addQuizDetailsErrorMessage').empty();
    var formData = new FormData($('#quizDetailsForm')[0]);

    // Get the selected course
    var courseSelector = $j('#course_selection_for_quiz').val();

    // Validate and show specific errors
    var isValid = true;

    // Course Selector validation
    if (courseSelector === '') {
        $j('#addQuizDetailsErrorMessage').append('<p><span style="font-weight: bold;">Select a course</span> is required.</p>');
        isValid = false;
    }

    // Quiz Name
    var quizName = $j.trim($j('#quizName').val());
    if (quizName === '') {
        $j('#addQuizDetailsErrorMessage').append('<p><span style="font-weight: bold;">Quiz name</span> is required.</p>');
        isValid = false;
    }

    // Quiz Instructions
    var quizInstructions = $j.trim($j('#quizInstructions').val());
    if (quizInstructions === '') {
        $j('#addQuizDetailsErrorMessage').append('<p><span style="font-weight: bold;">Quiz instructions</span> are required.</p>');
        isValid = false;
    }

    // Passing Score
    var passingScore = $j.trim($j('#passingScore').val());
    if (passingScore === '' || isNaN(passingScore)) {
        $j('#addQuizDetailsErrorMessage').append('<p><span style="font-weight: bold;">Passing score</span> is required and must be a number.</p>');
        isValid = false;
    }

    if (!isValid) {
        $j('#addQuizDetailsErrorMessage').show();
        return;
    }

    $j.ajax({
        type: 'POST',
        url: 'admin_dashboard_content/admin_scripts/add_quiz_details.php', // Adjust the URL to your PHP script for adding quizzes
        data: formData,
        processData: false,
        contentType: false,

        success: function (response) {
            handleResponse(response, $j('#addQuizDetailsSuccessMessage'), $j('#addQuizDetailsErrorMessage'));
        },
        error: function (error) {
            console.error('Error:', error);
        }
    });
});

        // Handles form validation and AJAX submission for adding quiz questions
        $j('#addQuizQuestion').click(function (e) {
        e.preventDefault();

        // Clear any previous error messages
        $j('#addQuizQuestionErrorMessage').empty();
        var formData = new FormData($('#questionForm')[0]);

        // Validate and show specific errors
        var isValid = true;

        // Quiz Selector
        var quizSelector = $j('#quiz_selector').val();
        if (quizSelector === '') {
            $j('#addQuizQuestionErrorMessage').append('<p>Select a <span style="font-weight: bold;">Quiz</span> to add the question to.</p>');
            isValid = false;
        }

        // Question Text
        var questionNumber = $j.trim($j('#questionNumber').val());
        if (questionNumber === '') {
            $j('#addQuizQuestionErrorMessage').append('<p><span style="font-weight: bold;">Question number</span> is required.</p>');
            isValid = false;
        }

        // Question Text
        var questionText = $j.trim($j('#questionText').val());
        if (questionText === '') {
            $j('#addQuizQuestionErrorMessage').append('<p><span style="font-weight: bold;">Question text</span> is required.</p>');
            isValid = false;
        }


        // Question Text
        var questionText = $j.trim($j('#questionText').val());
        if (questionText === '') {
            $j('#addQuizQuestionErrorMessage').append('<p><span style="font-weight: bold;">Question text</span> is required.</p>');
            isValid = false;
        }

        // Option A
        var optionA = $j.trim($j('#optionA').val());
        if (optionA === '') {
            $j('#addQuizQuestionErrorMessage').append('<p><span style="font-weight: bold;">Option A</span> is required.</p>');
            isValid = false;
        }

        // Option B
        var optionB = $j.trim($j('#optionB').val());
        if (optionB === '') {
            $j('#addQuizQuestionErrorMessage').append('<p><span style="font-weight: bold;">Option B</span> is required.</p>');
            isValid = false;
        }

        // Option C
        var optionC = $j.trim($j('#optionC').val());
        if (optionC === '') {
            $j('#addQuizQuestionErrorMessage').append('<p><span style="font-weight: bold;">Option C</span> is required.</p>');
            isValid = false;
        }

        // Option D
        var optionD = $j.trim($j('#optionD').val());
        if (optionD === '') {
            $j('#addQuizQuestionErrorMessage').append('<p><span style="font-weight: bold;">Option D</span> is required.</p>');
            isValid = false;
        }

        if (!isValid) {
            $j('#addQuizQuestionErrorMessage').show();
            return;
        }

        $j.ajax({
            type: 'POST',
            url: 'admin_dashboard_content/admin_scripts/add_quiz_questions.php', // Adjust the URL to your PHP script for adding questions
            data: formData,
            processData: false,
            contentType: false,

            success: function (response) {
                handleResponse(response, $j('#addQuizQuestionSuccessMessage'), $j('#addQuizQuestionErrorMessage'));
            },
            error: function (error) {
                console.error('Error:', error);
            }
        });
    });

    // Handle the "View Course" button click
    $j('.view-course-button').click(function () {
        var courseId = $j(this).data('course-id');
        // Make an AJAX request to fetch course data
        $j.ajax({
            type: 'POST',
            url: 'admin_dashboard_content/admin_scripts/get_course_details.php', // Create this PHP file to fetch course data by ID
            data: { course_id: courseId },
            success: function (response) {
                // Parse the response and populate the modal
                var courseData = JSON.parse(response);
                if (courseData.status === 'success') {
                    // Populate the modal with course data
                    $j('#view_course_panel').html(courseData.course_content);
                    $j('#view_module_panel').html(courseData.module_content);
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


        //Quill Rich Text Editor
        var quill = new Quill('#lesson-content-editor', {
            theme: 'snow',
            modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'color': [] }],
                ['link', 'image'],
                [{ 'list': 'bullet' }, { 'list': 'ordered' }],
                [{ 'header': [1, 2, 3, 4, false] }],
                ['clean'],
            ],
            keyboard: {
                bindings: {
                    'list bullet': {
                        key: 'B',
                        format: { list: 'bullet' },
                    },
                    'list ordered': {
                        key: 'N',
                        format: { list: 'ordered' },
                    },
                    'paragraph': {
                        key: 'P',
                        format: { block: 'paragraph' },
                    },
                },
            },
        },
    });



    // Quill Custom Color Picker
    var ColorPicker = Quill.import('formats/color');
        quill.getModule('toolbar').addHandler('color', function (value) {
            if (value === 'reset') {
                quill.format('color', false);
            } else {
            quill.format('color', value);
        }
    });

    var transcriptionQuill = new Quill('#lesson-video-transcription-editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ 'color': [] }],
                ['link', 'image'],
                [{ 'list': 'bullet' }, { 'list': 'ordered' }],
                [{ 'header': [1, 2, 3, 4, false] }],
                ['clean'],
            ],
            keyboard: {
                bindings: {
                    'list bullet': {
                        key: 'B',
                        format: { list: 'bullet' },
                    },
                    'list ordered': {
                        key: 'N',
                        format: { list: 'ordered' },
                    },
                    'paragraph': {
                        key: 'P',
                        format: { block: 'paragraph' },
                    },
                },
            },
        },
    });

    // Quill Custom Color Picker for the transcription editor
    var ColorPicker = Quill.import('formats/color');
    transcriptionQuill.getModule('toolbar').addHandler('color', function (value) {
        if (value === 'reset') {
            transcriptionQuill.format('color', false);
        } else {
            transcriptionQuill.format('color', value);
        }
    });

        

    });

    </script>
