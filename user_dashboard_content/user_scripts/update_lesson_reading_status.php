<?php
require_once 'conn.php';

$user_id = $_POST['user_id'];
$course_id = $_POST['course_id'];
$lesson_reading_id = $_POST['lesson_reading_id'];
$progress_status = $_POST['progress_status'];

// Check if a record already exists
$query = "SELECT user_reading_progress_id FROM user_lesson_reading_progress
          WHERE user_id = $user_id
          AND course_id = $course_id
          AND lesson_reading_id = $lesson_reading_id";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) == 0) {
    // If no record exists, perform an INSERT
    $insertQuery = "INSERT INTO user_lesson_reading_progress (user_id, course_id, lesson_reading_id, progress_status)
                    VALUES ($user_id, $course_id, $lesson_reading_id, $progress_status)";

    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Insert failed']);
    }
} else {
    // If a record already exists, perform an UPDATE
    $updateQuery = "UPDATE user_lesson_reading_progress
                    SET progress_status = $progress_status
                    WHERE user_id = $user_id
                    AND course_id = $course_id
                    AND lesson_reading_id = $lesson_reading_id";

    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Update failed']);
    }
}
?>
