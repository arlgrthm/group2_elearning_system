<?php
// Include your database connection file (conn.php)
include('conn.php');

if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    // Query to fetch course details based on course ID
    $query = "SELECT * FROM courses WHERE course_id = $course_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $course = mysqli_fetch_assoc($result);

        // Convert the course details to JSON format
        echo json_encode($course);
    } else {
        echo "Course not found";
    }
} else {
    echo "Invalid request";
}

// Close the database connection
mysqli_close($conn);
?>
