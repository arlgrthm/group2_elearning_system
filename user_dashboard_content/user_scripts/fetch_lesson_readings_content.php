<?php
// fetch_lesson_reading_content.php

include 'conn.php';

// Check if the lesson ID is sent via POST request
if (isset($_POST['lesson_id'])) {
    $lessonId = $_POST['lesson_id'];

    // Prepare and execute a query to retrieve lesson reading content based on the lesson ID
    $sql = "SELECT * FROM lesson_reading WHERE lesson_reading_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $lessonId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // You might want to modify this according to your database schema
        $lessonReadingData = array(
            'lesson_reading_id' => $row['lesson_reading_id'],
            'lesson_reading_title' => $row['lesson_reading_title'],
            'lesson_content' => $row['lesson_content'],
        );

        // Return the lesson reading data as JSON
        echo json_encode($lessonReadingData);
    } else {
        // Return an error if the lesson reading is not found
        echo json_encode(['error' => 'Lesson reading not found']);
    }
} else {
    // Return an error if lesson ID is not provided
    echo json_encode(['error' => 'Lesson ID not provided']);
}
