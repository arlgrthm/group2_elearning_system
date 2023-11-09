<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection configuration
    include("conn.php");

    // Initialize an array to store error messages
    $validationErrors = array();

    // Retrieve form data, including the Quill content
    $course_id = $_POST["course_selector_for_lesson"];
    $lessonReadingNumber = $_POST["lesson_reading_number"];
    $lessonReadingTitle = $_POST["lesson_reading_title"];
    $lessonContent = $_POST["lesson_content"];

    // Module Selector validation
    if (empty($course_id)) {
        $validationErrors[] = "Select a module is required.";
    }

    // Lesson Title validation
    if (empty($lessonReadingTitle) || preg_match('/^[0-9!@#$%^&*]/', $lessonReadingTitle)) {
        $validationErrors[] = "Lesson title is required and cannot start with numbers or special characters.";
    }

    // Lesson Content Validations
    if (strlen($lessonContent) > 20000) {
        $validationErrors[] = "Lesson content must not exceed to 20000 characters.";
    }

    // Character Encoding Validation
    if (!mb_check_encoding($lessonContent, 'UTF-8')) {
        $validationErrors[] = "Lesson content must be in UTF-8 character encoding.";
    }

    // Size Limitations (Images) Validation
    if (isset($_FILES['lesson_content']) && $_FILES['lesson_content']['size'] > 5000000) {
        $validationErrors[] = "Lesson content (images) must be no larger than 5MB.";
    }

    // Check if there are any error messages
    if (!empty($validationErrors)) {
        $response = [
            'status' => 'error',
            'messages' => $validationErrors
        ];
    } else {
        // All validations passed, proceed with database insertion
        $sql = "INSERT INTO lesson_reading (course_id, lesson_reading_title, lesson_reading_number, lesson_content, lesson_reading_date_creation) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isss", $course_id, $lessonReadingTitle, $lessonReadingNumber, $lessonContent);


        if ($stmt->execute()) {
            $response = [
                'status' => 'success',
                'message' => 'Lesson added successfully!'
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
    $conn->close();
} else {
    $response = [
        'status' => 'error',
        'message' => 'Invalid request'
    ];
    echo json_encode($response);
}
?>
