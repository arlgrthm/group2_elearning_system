<?php 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection configuration
    include("conn.php");

    // Retrieve form data
    $course_id = $_POST["course_selector_for_video"];
    $lessonTitle = $_POST["lesson_video_title"];
    $lessonVideoNumber = $_POST["lesson_video_number"];
    $contentSource = $_POST["content_source"];
    $lessonVideoLink = isset($_POST["lesson_video_link"]) ? $_POST["lesson_video_link"] : "";
    $lessonVideoTranscription = $_POST["lesson_video_transcription"];

    // Initialize an array to store error messages
    $validationErrors = array();

    // Module Selector validation
    if (empty($course_id)) {
        $validationErrors[] = "Select a course is required.";
    }

    // Lesson Title validation
    if (empty($lessonTitle) || preg_match('/^[0-9!@#$%^&*]/', $lessonTitle)) {
        $validationErrors[] = "Lesson video title is required and cannot start with numbers or special characters.";
    }

    // Additional validations for video-specific fields
    if ($contentSource === 'video_url') {
        if (empty($lessonVideoLink)) {
            $validationErrors[] = "Video URL is required.";
        }
    }

    // Check if there are any error messages
    if (!empty($validationErrors)) {
        $response = [
            'status' => 'error',
            'messages' => $validationErrors
        ];
    } else {
        // All validations passed, proceed with database insertion
        $lessonVideoLink = mysqli_real_escape_string($conn, $lessonVideoLink);

        // Insert the lesson video into the database with transcription
        $sql = "INSERT INTO lesson_video (course_id, lesson_video_title, lesson_video_number, content_source, lesson_video_link, lesson_video_transcription, lesson_video_date_creation) VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssss", $course_id, $lessonTitle, $lessonVideoNumber, $contentSource, $lessonVideoLink, $lessonVideoTranscription); // Bind the transcription

        if ($stmt->execute()) {
            $response = [
                'status' => 'success',
                'message' => 'Lesson video added successfully!'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Error: ' . $stmt->error
            ];
        }

        $stmt->close();
    }

    echo json_encode($response);
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request'
    ];
    echo json_encode($response);
}
?>
