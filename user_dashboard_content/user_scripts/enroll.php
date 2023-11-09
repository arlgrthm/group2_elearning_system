<?php
include('conn.php'); // Include your database connection file
session_start();
$userID = $_SESSION['user_id'];

if (isset($_POST['course_id'])) {
    $courseID = $_POST['course_id'];

    // Check if the user is already enrolled in the course
    $enrollmentCheckQuery = "SELECT * FROM enrollments WHERE user_id = $userID AND course_id = $courseID";
    $enrollmentCheckResult = mysqli_query($conn, $enrollmentCheckQuery);

    if (mysqli_num_rows($enrollmentCheckResult) > 0) {
        $response = array('success' => false, 'message' => 'You are already enrolled in this course.');
    } else {
        // User is not enrolled, so insert the enrollment into the 'enrollments' table
        $query = "INSERT INTO enrollments (user_id, course_id, enrollment_date) VALUES ($userID, $courseID, NOW())";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $response = array('success' => true, 'message' => 'Enrolled successfully.');
        } else {
            $response = array('success' => false, 'message' => 'Failed to enroll. ' . mysqli_error($conn));
        }
    }

    echo json_encode($response);
} else {
    $response = array('success' => false, 'message' => 'Invalid request');
    echo json_encode($response);
}

mysqli_close($conn);
?>
