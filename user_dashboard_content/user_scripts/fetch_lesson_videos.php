<?php
// Include your database connection file (conn.php)
include('conn.php');

// Check if a course_id is provided in the request
if (isset($_POST['course_id']) && isset($_POST['user_id'])) {
    $course_id = $_POST['course_id'];
    $user_id = $_POST['user_id'];

    // Fetch lesson videos for the specified course
    $query_lesson_videos = "SELECT lesson_video_id, lesson_video_title, lesson_video_link FROM lesson_video WHERE course_id = $course_id";
    $result_lesson_videos = mysqli_query($conn, $query_lesson_videos);

    if ($result_lesson_videos) {
        $lessonVideos = array();

        while ($row_lesson_videos = mysqli_fetch_assoc($result_lesson_videos)) {
            $lessonVideoId = $row_lesson_videos['lesson_video_id'];

            // Fetch progress status for each lesson video
            $query_progress = "SELECT progress_status FROM user_lesson_video_progress WHERE lesson_video_id = $lessonVideoId AND user_id = $user_id";
            $result_progress = mysqli_query($conn, $query_progress);

            if ($result_progress && mysqli_num_rows($result_progress) > 0) {
                $row_progress = mysqli_fetch_assoc($result_progress);
                $progress_status = $row_progress['progress_status'];
            } else {
                // Set default status if no progress entry is found
                $progress_status = 'Not Yet';
            }

            $row_lesson_videos['progress_status'] = $progress_status;

            $lessonVideos[] = $row_lesson_videos;
        }

        // Return the lesson videos and their progress status as JSON
        echo json_encode($lessonVideos);
    } else {
        // Handle the database query error for fetching lesson videos
        echo json_encode(array('error' => 'Database error while fetching lesson videos'));
    }
} else {
    // Handle missing course_id or user_id parameter
    echo json_encode(array('error' => 'Missing course_id or user_id'));
}
?>
