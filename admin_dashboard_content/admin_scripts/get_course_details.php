<?php
// Include your database connection file (conn.php)
include('conn.php');

// Check if the course_id is provided via POST request
if (isset($_POST['course_id'])) {
    $courseId = $_POST['course_id'];

    // Query to fetch course details by course_id
    $query = "SELECT course_id, course_thumbnail_image, course_name, course_instructor, course_difficulty, course_description, objectives, course_date_creation FROM courses WHERE course_id = $courseId";
    $result = mysqli_query($conn, $query);

    // Check if there are any results
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Create an array to hold course details
        $courseDetails = [
            'course_thumbnail_image' => 'admin_dashboard_content/admin_scripts/' . $row['course_thumbnail_image'], 
            'course_name' => $row['course_name'],
            'course_instructor' => $row['course_instructor'],
            'course_difficulty' => $row['course_difficulty'],
            'course_description' => $row['course_description'],
            'objectives' => $row['objectives'],
            'course_date_creation' => $row['course_date_creation']
        ];

        echo json_encode($courseDetails);
    } else {
        echo json_encode(['error' => 'Course details not found.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request. Course ID not provided.']);
}

// Close the database connection
mysqli_close($conn);
?>
