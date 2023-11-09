<?php
// Include your database connection file (conn.php)
include('conn.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the course details from the POST data
    $courseId = $_POST['course_id'];
    $courseName = $_POST['course_name'];
    $courseInstructor = $_POST['course_instructor'];
    $courseDifficulty = $_POST['course_difficulty'];
    $courseDescription = $_POST['course_description'];
    $objectives = $_POST['objectives'];

    // Update the course details in the database
    $query = "UPDATE courses SET 
        course_name = '$courseName',
        course_instructor = '$courseInstructor',
        course_difficulty = '$courseDifficulty',
        course_description = '$courseDescription',
        objectives = '$objectives'
        WHERE course_id = $courseId";

    if (mysqli_query($conn, $query)) {
        // The update was successful
        echo json_encode(['message' => 'Course updated successfully']);
    } else {
        // The update failed
        echo json_encode(['error' => 'Failed to update course']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

// Close the database connection
mysqli_close($conn);
