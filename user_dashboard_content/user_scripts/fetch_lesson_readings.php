<?php
// Include your database connection file (conn.php)
include('conn.php');

// Check if 'course_id' and 'user_id' are provided in the request
if (isset($_POST['course_id']) && isset($_POST['user_id'])) {
    $course_id = $_POST['course_id'];
    $user_id = $_POST['user_id'];

    // Fetch lesson readings for the specified course
    $query_lesson_readings = "SELECT lesson_reading_id, lesson_reading_title, lesson_content, lesson_reading_date_creation FROM lesson_reading WHERE course_id = $course_id";
    $result_lesson_readings = mysqli_query($conn, $query_lesson_readings);

    if ($result_lesson_readings) {
        $lessonReadings = array();

        while ($row_lesson_readings = mysqli_fetch_assoc($result_lesson_readings)) {
            $lessonReadingId = $row_lesson_readings['lesson_reading_id'];

            // Fetch progress status for each lesson reading
            $query_progress = "SELECT progress_status FROM user_lesson_reading_progress WHERE lesson_reading_id = $lessonReadingId AND user_id = $user_id";
            $result_progress = mysqli_query($conn, $query_progress);

            if ($result_progress && mysqli_num_rows($result_progress) > 0) {
                $row_progress = mysqli_fetch_assoc($result_progress);
                $progress_status = $row_progress['progress_status'];
            } else {
                // Set default status if no progress entry is found
                $progress_status = 'Not Yet';
            }

            $row_lesson_readings['progress_status'] = $progress_status;

            $lessonReadings[] = $row_lesson_readings;
        }

        // Return the lesson readings and their progress status as JSON
        echo json_encode($lessonReadings);
    } else {
        // Handle the database query error for fetching lesson readings
        echo json_encode(array('error' => 'Database error while fetching lesson readings'));
    }
} else {
    // Handle missing course_id or user_id parameter
    echo json_encode(array('error' => 'Missing course_id or user_id'));
}
?>
